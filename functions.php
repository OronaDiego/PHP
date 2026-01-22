<?php
function ensureCacheDirectory(string $cacheDir): void
{
    // Si la carpeta no existe, la creo
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }
}

function render_template(string $template, array $data = [])
{
    extract($data);
    require"templates/$template.php";
}

function getMarvelData(
    string $apiUrl,
    string $cacheDir,
    string $cacheFile,
    int $cacheTime
): ?array {

    // Me aseguro que exista la carpeta cache
    ensureCacheDirectory($cacheDir);

    //  Si el cache existe y sigue siendo válido
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
        $result = file_get_contents($cacheFile);
        return json_decode($result, true);
    }

    //  Si no hay cache válido → llamo a la API
    $ch = curl_init($apiUrl);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP cURL)',
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    //  Si falla la API pero hay cache viejo → uso el cache
    if ($result === false && file_exists($cacheFile)) {
        $result = file_get_contents($cacheFile);
        return json_decode($result, true);
    }

    //  Si la API respondió bien → guardo cache
    if ($result !== false) {
        file_put_contents($cacheFile, $result);
        return json_decode($result, true);
    }

    //  Si todo falla
    return null;
}

function calculateDaysUntil(string $releaseDate): int
{
    // Fecha de estreno
    $release = new DateTime($releaseDate);

    // Fecha actual
    $today = new DateTime();

    // Diferencia en días
    return $today->diff($release)->days;
}