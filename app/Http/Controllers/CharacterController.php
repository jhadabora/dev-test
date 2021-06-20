<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller {

    public function results(Request $request) {
        //Get the response containing paged list of characters from the API.
        $charReponse = Http::timeout(10)->get('https://rickandmortyapi.com/api/character', ['page' => $request->get('page', 1)]);

        //Throw an exception to be caught by the error handler if anything unexpected happens. ¯\_(ツ)_/¯
        $charReponse->throw();

        //Get the results of characters and convert them into objects.
        $characters = $charReponse->collect('results')->mapInto(Character::class);

        //Render the list of characters in a blade view.
        return view('characters.list', compact('characters'));
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
