<!DOCTYPE html>
<html>
<head>
    <title>Weather App</title>
</head>
<body>
    <h1>Weather Information</h1>
    <form method="GET">
        <select name="city_id">
            <?php
            if (file_exists("city.list.json") && is_readable("city.list.json")) {
                $jsonContent = file_get_contents("city.list.json");
                if ($jsonContent !== false) {
                    $cities = json_decode($jsonContent, true);
                    if (is_array($cities) && !empty($cities)) {
                        foreach ($cities as $city) {
                            if (isset($city['id']) && isset($city['name'])) {
                                $selected = (isset($_GET['city_id']) && $_GET['city_id'] == $city['id']) ? 'selected' : '';
                                echo "<option value='{$city['id']}' {$selected}>{$city['name']}</option>";
                            }
                        }
                    }
                }
            }
            ?>
        </select>
        <button type="submit">Get Weather</button>
    </form>

    <?php
    if (isset($_GET['city_id'])) {
        require 'Curle.php'; 
        $weather = new Curle($_GET['city_id']);

        // require 'GuzzleWeather.php'; 
        // $weather = new GuzzleWeather($_GET['city_id']);

        $report = $weather->getWeather();
        if ($report && isset($report['temp_min'], $report['temp_max'], $report['humidity'])) {
            echo "<h2>Weather Report:</h2>";
            echo "Temperature Min: " . $report['temp_min'] . "°C<br>";
            echo "Temperature Max: " . $report['temp_max'] . "°C<br>";
            echo "Humidity: " . $report['humidity'] . "%<br>";
            echo "pressure: " . $report['pressure'] . "%<br>";
            echo "wind_speed: " . $report['wind_speed'] . "%<br>";

        } else {
            echo "<p>Weather information is unavailable for the selected city.</p>";
        }
    }
    ?>
</body>
</html>
