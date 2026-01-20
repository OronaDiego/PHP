<?php 


$API_URL = "https://whenisthenextmcufilm.com/api";

# Inicializo una nueva sesión de CURL; ch = Curl handle
$ch = curl_init($API_URL);

//Desactivo la verificacion SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP cURL)',
]);

$result = curl_exec($ch);

// Chequeo de error
if ($result === false) {
    echo 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($result, true);

//Altenativa mas sencilla utilizar file_get_contents
//$result = file_get_contents(API_URL);
//Si solo queremos hacer un GET de una API
?>




<head>
    <title>La Proxima pelicula de Marvel</title>
    <meta name="description" content="La Proxima Pelicula de marvel">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Centered viewport -->
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css"
    >
</head>

<main> 
    <section>
    <img src="<?= $data["poster_url"];?>" width="300" alt="Poster de <?= $data["title"]; ?>" 
    style="border-radius:16px"/>
    </section>

    <hgroup>
        <h3><?= $data["title"]; ?> Se estrena en <?= $data["days_until"]; ?> Dias</h3>
        <p>Fecha de estreno <?= $data["release_date"]; ?></p>
        <p>La siguiente es: <?= $data["following_production"]["title"]; ?></p>
    </hgroup>
    
</main>

<style>
    :root {
        color-scheme: light dark;
    }
    body {
        display: grid;
        place-content: center;
    }
    section {
        display: flex;
        justify-content: center;
        text-align: center;
    }
    hgroup {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }
</style>
