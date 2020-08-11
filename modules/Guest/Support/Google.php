<?php

namespace Modules\Guest\Support;

use Google_Client;

class Google {
    /** @var Google_Client  */
    protected $client;

    /** @var GooglePlace  */
    protected $place;

    /** @var GoogleGeocode */
    protected $geocode;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName(config('app.name'));
        $this->client->setDeveloperKey(env('GOOGLE_API_KEY'));
    }

    /**
     * @param array $params
     * @return mixed|null
     */
    public function placeSearch($params)
    {
        if (!($this->place instanceof GooglePlace)) {
            $this->place = new GooglePlace($this->client);
        }
        return $this->place->search($params);
    }

    /**
     * @param $params
     * @return string|null A json string of the search's results
     */
    public function geocodeSearch($params)
    {
        if (!($this->geocode instanceof GoogleGeocode)) {
            $this->geocode = new GoogleGeocode($this->client);
        }
        return $this->geocode->search($params);

    }
}
