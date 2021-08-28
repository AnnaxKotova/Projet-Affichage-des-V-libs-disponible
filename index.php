<?php
    include('apiVelib.php')
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma carte</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
    <div class="carte">
        <?php
        foreach ($dataStations as $key => $value){
            $codeStation = $value['code_station'];
            $totalDispo = $value['total_dispo'];

            echo "<div id='vel{$codeStation}' class='caseVelo'>{$totalDispo}</div>";

            // <div id="vel17033" class="caseVelo"></div>
            // <div id="vel8056" class="caseVelo"></div>
            // <div id="vel8057" class="caseVelo"></div>
            // <div id="vel8028" class="caseVelo"></div>
            // <div id="vel8003" class="caseVelo"><?php echo $totalDispo8003</div>
            // <div id="vel16001" class="caseVelo"></div>
            // <div id="vel16103" class="caseVelo"></div> -->
        }
        ?>
    </div>
    

    <?php
    foreach ($dataStations as $key => $value){
        $codeStation = $value['code_station'];
        $nomStation = $value['nom_station'];
        $totalDispo = $value['total_dispo'];
        $eveloDispo = $value['evelo_dispo'];
        $veloDispo = $value['velo_dispo'];

        echo "<div class='infos' id='infos'>
                <div id='infos{$codeStation}' class='infosVelo'>
                <div class='identificationStation'>
                <div class='name'>{$nomStation}</div>
            </div>

        <div class='disponibilite'>
            <div class='nbVelosTotal'>
                <img src='img/total.png' alt='total' class='picto'>
                <span>{$totalDispo}</span>
            </div>
            <div class='nbVelosMecanique'>
                <img src='img/bike.png' alt='bike' class='picto'>
                <span>{$veloDispo}</span>
            </div>
            <div class='nbVelosElectric'>
                <img src='img/ebike.png' alt='ebike' class='picto'>
                <span>{$eveloDispo}</span>
            </div>
        </div>      
        
    </div>";
      
    }
    ?>
    </div>

    <script src="js/script.js"></script>
</body>
</html>