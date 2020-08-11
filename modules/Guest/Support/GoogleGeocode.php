<?php

namespace Modules\Guest\Support;

use Google_Client;

class GoogleGeocode {
    /** @var \GuzzleHttp\ClientInterface  */
    protected $http;
    protected const API_URL = 'https://maps.googleapis.com/maps/api/geocode/';

    /**
     * GooglePlace constructor.
     * @param Google_Client $client
     */
    public function __construct($client)
    {
        $this->http = $client->authorize();
    }

    /**
     * @param $params
     * @return mixed|null
     */
    public function search($params)
    {
        $defaultParams = [
            'address' => 'Hà Nội, Việt Nam'
        ];
        $params = array_merge($defaultParams, $params);
        $url = self::API_URL."json?".http_build_query($params);
        $rs = $this->http->get($url);
        if ($rs->getStatusCode() === 200)  {
            return json_decode($rs->getBody()->getContents());
        }
        return null;
    }
}
