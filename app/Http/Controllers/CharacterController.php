<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller {

    public function results(Request $request) {
        //Get current page from the GET query parameters in the request.
        $page = (int)$request->input('page', 1);

        //Check if the page parameter a positive integer.
        if ($page <= 0) {
            return response()->view('characters.error', ['alert' => 'Malformed request. Page must be an integer greater than 0.'], 400);
        }

        //Get the five valid filters usable with the character endpoint.
        $filters = array_filter(array_intersect_key($request->all(), array_flip(['name', 'status', 'species', 'type', 'gender'])));

        //Check if the status filter parameter is one of the valid options if it is specified.
        if (!empty($filters['status']) && !in_array($filters['status'], ['alive', 'dead', 'unknown'])) {
            return response()->view('characters.error', ['alert' => "Malformed request. Status must be either 'alive', 'dead' or 'unknown'."], 400);
        //Check if the gender filter parameter is one of the valid options if it is specified.
        } else if (!empty($filters['gender']) && !in_array($filters['gender'], ['female', 'male', 'genderless', 'unknown'])) {
            return response()->view('characters.error', ['alert' => "Malformed request. Gender must be either 'female', 'male', 'genderless' or 'unknown'."], 400);
        }

        try {
            //Get the list of characters for the requested page with the requested filters from the API.
            $charReponse = Http::timeout(10)->get('https://rickandmortyapi.com/api/character', array_merge($filters, ['page' => $page]));
        } catch (ConnectionException $e) {
            return response()->view('characters.error', ['alert' => 'Request to the Rick and Morty API timed out. Please try again later.'], 503);
        }

        //There are no results for this query. Personal preference to not make this a 404 on the website, request was still valid after all.
        if ($charReponse->status() == 404) {
            return response()->view('characters.error', ['alert' => 'No results found. Try changing your search parameters.']);
        //We are rate limited.
        } elseif ($charReponse->status() == 429) {
            return response()->view('characters.error', ['alert' => 'You are rate limited, please try again later.'], 429);
        }

        //Throw an exception to be caught by the error handler if anything unexpected happens. ¯\_(ツ)_/¯
        $charReponse->throw();

        //Get the results of characters and convert them into objects.
        $characters = $charReponse->collect('results')->mapInto(Character::class);

        //Put the info from the response in an array.
        $info = $charReponse->json('info');

        //Render the list of characters in a blade view.
        return view('characters.list', compact('characters', 'info', 'page'));
    }

    public function view(Request $request, int $id) {
        //Check if the ID parameter is a positive integer.
        if ($id <= 0) {
            return response()->view('characters.error', ['alert' => 'Malformed request. Page must be an integer greater than 0.'], 400);
        }

        //Get the single character response from the API.
        $charReponse = Http::timeout(10)->get("https://rickandmortyapi.com/api/character/$id");

        //Check that the character was found.
        if ($charReponse->status() == 404) {
            return response()->view('characters.error', ['alert' => 'This character does not exist.'], 404);
        }

        //Throw an exception to be caught by the error handler if anything unexpected happens. ¯\_(ツ)_/¯
        $charReponse->throw();

        //Create a model based on the array of information passed by the API.
        $character = new Character($charReponse->json());

        //Get the episodes that this character appeared in, or an error message explaining why we couldn't.
        $episodes = $character->episodeList;

        //Render the character data in a blade view.
        return view('characters.view', compact('character', 'episodes'));
    }

}
