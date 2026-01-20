<?php 


$API_URL = "https://whenisthenextmcufilm.com/api";


// CACHE
$cacheDir  = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/marvel.json';
$cacheTime = 604800; // 7 Dias

// Creo carpeta cache si no existe
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

// Si el cache existe y es válido
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {

    $result = file_get_contents($cacheFile);

} else {

    // --- CURL ---
    $ch = curl_init($API_URL);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP cURL)',
        CURLOPT_SSL_VERIFYPEER => false, // solo hosting compartido
    ]);

    $result = curl_exec($ch);

    // Si falla la API pero existe cache viejo → lo uso
    if ($result === false && file_exists($cacheFile)) {
        $result = file_get_contents($cacheFile);
    }

    curl_close($ch);

    // Guardo cache solo si vino algo válido
    if ($result !== false) {
        file_put_contents($cacheFile, $result);
    }
}

$data = json_decode($result, true);

if (!$data || !isset($data['title'])) {
    echo "No se pudo cargar la información.";
    exit;
}

// Cálculo dinámico de días
$releaseDate = new DateTime($data['release_date']);
$today = new DateTime();
$daysUntil = $today->diff($releaseDate)->days;

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
        <h3><?= $data["title"]; ?> Se estrena en <?= $daysUntil; ?> Dias</h3>
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
