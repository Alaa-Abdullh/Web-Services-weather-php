<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

class GuzzleWeather {
    private $cityId;
    private $apiKey = '823e599f59d771f902cb9f20d5ff8b9c';

    public function __construct($cityId) {
        $this->cityId = $cityId;
    }

    public function getWeather() {
        $client = new Client();
        $url = "https://api.openweathermap.org/data/2.5/weather?id={$this->cityId}&appid={$this->apiKey}&units=metric";

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if (isset($data['main'])) {
                return [
                    'temp_min' => $data['main']['temp_min'],
                    'temp_max' => $data['main']['temp_max'],
                    'humidity' => $data['main']['humidity'],
                    'pressure' => $data['main']['pressure'],
                    'wind_speed' => $data['wind']['speed'] ,
                ];
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
    }
}
?>
