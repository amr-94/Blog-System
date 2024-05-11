<?php

namespace App\services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class openwithermap
{
    protected $apikey;
    protected $baseurl = 'https://api.openweathermap.org/data/2.5/';
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
    }
    public function currentweather($city)
    {
        $response =  Http::baseUrl($this->baseurl)->get('weather', [
            'q' => $city,
            'appid' => $this->apikey,
            'units' => 'metric', //بتحول درجة الحرارة ل سليزيس
            'lang' => App::currentLocale(),
        ]);
        return $response->json();
    }
}
