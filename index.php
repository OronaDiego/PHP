<?php 
require_once __DIR__ . '/functions.php';
require 'const.php';

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

?>

<?php render_template('head',$data);?>
<?php render_template('main', $data);?>
<?php render_template('styles');?>


