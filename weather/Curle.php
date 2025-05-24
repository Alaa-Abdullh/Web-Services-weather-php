<?php
class Curle {
    private $cityId;
    private $apiKey = '823e599f59d771f902cb9f20d5ff8b9c';

    public function __construct($cityId) {
        $this->cityId = $cityId;
    }

    public function getWeather() {
        $url = "http://api.openweathermap.org/data/2.5/weather?id={$this->cityId}&appid={$this->apiKey}&units=metric";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['main'])) {
            return [
                'temp_min' => $data['main']['temp_min'],
                'temp_max' => $data['main']['temp_max'],
                'humidity' => $data['main']['humidity'],
                'pressure' => $data['main']['pressure'],
                'wind_speed' => $data['wind']['speed']
            


            ];
        } else {
            return null;
        }
    }
}
?>
