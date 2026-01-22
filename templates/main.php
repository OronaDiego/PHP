
<?php  
$daysUntil = calculateDaysUntil($release_date);
?>
<main> 
    <section>
    <img src="<?= $poster_url;?>" width="300" alt="Poster de <?= $title; ?>" 
    style="border-radius:16px"/>
    </section>
    <hgroup>
        <h3><?= $title; ?> Se estrena en <?= $daysUntil; ?> Dias</h3>
        <p>Fecha de estreno <?= $release_date; ?></p>
        <p>La siguiente es: <?= $following_production["title"]; ?></p>
    </hgroup>
    
</main>



