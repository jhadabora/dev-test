<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller {

    public function results(Request $request) {
        //Get current page from the GET query parameters in the request.
        $page = $request->get('page', 1);

        //Get the five valid filters usable with the character endpoint.
        $filters = array_filter(array_intersect_key($request->all(), array_flip(['name', 'status', 'species', 'type', 'gender'])));

        //Get the list of characters for the requested page with the requested filters from the API.
        $charReponse = Http::timeout(10)->get('https://rickandmortyapi.com/api/character', array_merge($filters, ['page' => $page]));

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
        //Get the single character response from the API.
        $charReponse = Http::timeout(10)->get("https://rickandmortyapi.com/api/character/$id");

        //Throw an exception to be caught by the error handler if anything unexpected happens. ¯\_(ツ)_/¯
        $charReponse->throw();

        //Create a model based on the array of information passed by the API.
        $character = new Character($charReponse->json());

        //Render the character data in a blade view.
        return view('characters.view', compact('character'));
    }

}
