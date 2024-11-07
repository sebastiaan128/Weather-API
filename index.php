<?php
if (isset($_POST["submit"])) {
    if (empty($_POST["city"])) {
        echo "<p class='text-red-500 font-bold mt-4'>Voer een stadsnaam in</p>";
    } else {
        $city = $_POST["city"];
        $api_key = "d8922050e3cc6370956d948a38133f57";
        $api = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key";
        $api_data = file_get_contents($api);
        $weather = json_decode($api_data, true);

        if ($weather && $weather["cod"] == 200) {
            $description = $weather["weather"][0]["description"];
            $icon = $weather["weather"][0]["icon"];
            $temp = $weather["main"]["temp"] - 273;
            $feels_like = $weather["main"]["feels_like"] - 273;
            $temp_min = $weather["main"]["temp_min"] - 273;
            $temp_max = $weather["main"]["temp_max"] - 273;
            $pressure = $weather["main"]["pressure"];
            $humidity = $weather["main"]["humidity"];
            $wind_speed = $weather["wind"]["speed"];
            $wind_deg = $weather["wind"]["deg"];
            $country = $weather["sys"]["country"];
            $sunrise = date("H:i:s", $weather["sys"]["sunrise"]);
            $sunset = date("H:i:s", $weather["sys"]["sunset"]);
        } else {
            echo "<p class='text-red-500 font-bold mt-4'>We konden de gegevens voor $city niet vinden. Probeer het opnieuw.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 to-blue-600 text-gray-800">
    <section class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">
        <form method="post" class="mb-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-4">The Weather App</h1>
            <input type="text" name="city" placeholder="Stadsnaam" class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input name="submit" type="submit" value="Controleer" class="w-full bg-blue-600 text-white p-3 rounded-lg cursor-pointer hover:bg-blue-700 transition">
        </form>

        <?php if (isset($description)) { ?>
            <h2 class="text-xl font-semibold text-gray-700">Weer in <?php echo htmlspecialchars($city) . ", " . $country; ?>:</h2>
            <p class="capitalize text-lg text-gray-600 mb-2"><?php echo $description; ?></p>
            <p><img src="http://openweathermap.org/img/wn/<?php echo $icon; ?>@2x.png" alt="Weather icon" class="mx-auto mb-4"></p>
            <div class="text-left">
                <p>🌡️ Temperatuur: <?php echo round($temp, 2); ?> °C</p>
                <p>🥶 Gevoelstemperatuur: <?php echo round($feels_like, 2); ?> °C</p>
                <p>🔻 Minimale temperatuur: <?php echo round($temp_min, 2); ?> °C</p>
                <p>🔺 Maximale temperatuur: <?php echo round($temp_max, 2); ?> °C</p>
                <p>📊 Luchtdruk: <?php echo $pressure; ?> hPa</p>
                <p>💧 Luchtvochtigheid: <?php echo $humidity; ?>%</p>
                <p>🌬️ Windsnelheid: <?php echo $wind_speed; ?> m/s</p>
                <p>🧭 Windrichting: <?php echo $wind_deg; ?>°</p>
                <p>🌅 Zonsopgang: <?php echo $sunrise; ?></p>
                <p>🌇 Zonsondergang: <?php echo $sunset; ?></p>
            </div>
        <?php } ?>
    </section>
</body>
</html>
