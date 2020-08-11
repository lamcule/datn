<?php

namespace Modules\Guest\Support;

use Google_Client;

class GooglePlace {
    protected $http;
    protected const API_URL = 'https://maps.googleapis.com/maps/api/place/';

    /**
     * GooglePlace constructor.
     * @param Google_Client $client
     */
    public function __construct($client)
    {
        $this->http = $client->authorize();
    }

    /**
     * @param array $params
     * @return mixed|null
     */
    public function search($params)
    {
        $defaultParams = [
            'fields' => 'formatted_address,geometry,icon,id,name,permanently_closed,photos,place_id,plus_code,types',
            'query' => 'Hà Nội'
        ];
        $params = array_merge($defaultParams, $params);
        $url = self::API_URL."textsearch/json?".http_build_query($params);
        $rs = $this->http->get($url);
        if ($rs->getStatusCode() === 200)  {
            return json_decode($rs->getBody()->getContents());
        }
        return null;
    }
}
