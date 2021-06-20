<?php

namespace App\Models;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Jenssegers\Model\Model;

class Character extends Model {

    protected $fillable = ['id', 'name', 'status', 'species', 'type', 'gender', 'origin', 'location', 'image', 'episode', 'url', 'created'];

    /**
     * Accessor to get a list of episode objects from the R&M API.
     * Use sparingly, every call is a call to the API.
     *
     * @return \App\Models\Episode[]|string
     */
    public function getEpisodeListAttribute() {
        //Get a list of IDs derived from the episode links of the episode attribute.
        $ids = array_map(fn(string $resource) => (int)str_replace('https://rickandmortyapi.com/api/episode/', '', $resource), $this->episode);

        //Get the list of characters for the requested page with the requested filters from the API.
        try {
            $epReponse = Http::timeout(10)->get('https://rickandmortyapi.com/api/episode/' . implode(',', $ids));
        } catch (ConnectionException $e) {
            return 'Failed to get episode names for episodes ' . implode(', ', $ids);
        }

        //Return an array of the results mapped to Episode objects.
        return Episode::hydrate($epReponse->collect()->toArray());
    }

}
