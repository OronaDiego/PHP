<?php 
require_once __DIR__ . '/functions.php';

$API_URL = "https://whenisthenextmcufilm.com/api";

// CACHE config
$cacheDir  = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/marvel.json';
$cacheTime = 604800; // 7 Dias

// Obtener datos
$data = getMarvelData(
    $API_URL,
    $cacheDir,
    $cacheFile,
    $cacheTime
);


//Validacion
if (!$data || !isset($data['title'])) {
    echo "No se pudo cargar la información.";
    exit;
}

// Cálculo de días
$daysUntil = calculateDaysUntil($data['release_date']);

?>

<?php require 'sections/head.php';?>
<?php require 'sections/styles.php';?>
<?php require 'sections/main.php';?>


