<?php
//Connexion à la base de données
try{    
    $dsn = 'mysql:dbname=velib;host=127.0.0.1;charset=UTF8';
    $user = 'root';
    $password = '';

    $bdd = new PDO($dsn, $user, $password);
}catch (PDOException $e){
     die ('Problème de connexion à la base de données');
}

//ECRIRE LE CODE ICI
//Insertion de données
$allStations = getAllCodeVelibStationFromBDD($bdd); //bdd - c'est notre base de données créer par Paris

foreach($allStations as $key => $value) //dealing with an array associatif
{
    $codeStation = $value['code_station']; //récuperation d'un numéro de station

   $data = getJsonFromAPI($codeStation); //transformation sur le texte

//    print_r($codeStation);
   setVelibData($bdd, $codeStation, $data); //téléchargement dans le tableau dispo

   //VOILA ! ! !
}


//Récupération de la donnée
// function insertData($codeStation){



$station8003 = getOneVelibStationFromBDD($bdd, 8003);
$nom_station8003 = $station8003['nom_station'];
$codeStation_dispo8003 = $station8003['codeStation_dispo'];
$totalDispo8003 = $station8003['total_dispo'];
$eveloDispo8003 = $station8003['evelo_dispo'];
$veloDispo8003 = $station8003['velo_dispo'];
// print_r($station8003);


// foreach($dataStation as $key =>$value){



// $allStations = getAllCodeVelibStationFromBDD($bdd); //bdd - c'est notre base de données créer par Paris

// foreach($allStations as $key => $value) //dealing with an array associatif
// {
    // $codeStation = $value['code_station'];

    $dataStations = getAllVelibStationFromBDD($bdd, $codeStation);
    foreach($dataStations as $key => $value){
            // print_r($dataStations[$i]); //Array ( [code_station] => 17033 [ouvert_dispo] => 0 [evelo_dispo] => 0 [velo_dispo] => 0 [total_dispo] => 0 [capacite_dispo] => 33 )
            $value['code_station'];
            print_r($dataStations[$codeStation]);


    // foreach($dataStations[$i] as $key => $value){
    //     $nom_station[$i] = $dataStations[$i]['nom_station'];
    //     $code_station[$i] = $dataStations[$i]['code_station'];
    //     $ouvert_dispo[$i] = $dataStations[$i]['ouvert_dispo'];
    //     $evelo_dispo[$i] = $dataStations[$i]['evelo_dispo'];
    //     $velo_dispo[$i] = $dataStations[$i]['velo_dispo'];
    //     $total_dispo[$i] = $dataStations[$i]['total_dispo'];
    //     }
    }

    // print_r($total_dispo[5]); //mais dans ce cas la on est besoin de numero de station

    //normalement on est besoin 


//FONCTIONS
/*
    Récupération de tous les codes stations de Vélib
    @pdo object : variable où l'on a initialisé la base de données
*/
function getAllCodeVelibStationFromBDD($pdo){
    $requete = "SELECT `code_station`
    FROM stations LEFT JOIN `dispo`
    ON `code_station` = `codeStation_dispo`"; //voici left join car là on recupère que les numéros de stations
    $sql = $pdo->prepare($requete);
    $sql->execute();
    if($sql->errorInfo()[0] != 00000 ){
        print_r($sql->errorInfo());
    }
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/*
    Récupération d'une station de Vélib avec les données de disponnibilités
    @pdo object : variable où l'on a initialisé la base de données

    là on est besoin de recuperer touts les données car on les a besoin pour les afficher
*/
function getOneVelibStationFromBDD($pdo, $codeStation){
    $requete = "SELECT `nom_station`, `codeStation_dispo`, `ouvert_dispo`, `evelo_dispo`, 
    `velo_dispo`, `total_dispo`, `capacite_dispo`    
    FROM `stations` RIGHT JOIN `dispo`
    ON `code_station` = `codeStation_dispo`
    WHERE code_station = :codeStation;"; //car la fonction asks for une seule station
    $sql = $pdo->prepare($requete);
    $sql->bindValue(':codeStation', $codeStation, PDO::PARAM_INT);
    $sql->execute();
    if($sql->errorInfo()[0] != 00000 ){
        print_r($sql->errorInfo());
    }
    return $sql->fetch(PDO::FETCH_ASSOC); 
    // rutourne que le 1er resultat
}





/*
    Récupération de toutes les stations vélib avec les données de disponnibilités
    @pdo object : variable où l'on a initialisé la base de données
*/
function getAllVelibStationFromBDD($pdo, $codeStation){
    $requete = "SELECT `nom_station`, `code_station`,
    `ouvert_dispo`,
    `evelo_dispo`,
    `velo_dispo`,
    `total_dispo`,
    `capacite_dispo`
    FROM `stations` RIGHT JOIN `dispo`
    ON `code_station` = `codeStation_dispo`";
    //ici right join car on est besoin de disponibilité
    $sql = $pdo->prepare($requete);
    $sql->execute();
    if($sql->errorInfo()[0] != 00000 ){
        print_r($sql->errorInfo());
    }
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/*
    Ajout ou modification des informations pour une station de Vélib
    @pdo object : variable où l'on a initialisé la base de données
*/
function setVelibData($pdo, $codeStation, $data){

    if(getOneVelibStationFromBDD($pdo, $codeStation)){
        $requeteUpdate = "UPDATE `dispo` SET
        -- `code_station` =  :codeStation, on n'a pas besoin car on l'a met dans WHERE
        `ouvert_dispo` = :ouvert_dispo,
        `evelo_dispo` = :evelo_dispo,
        `velo_dispo` = :velo_dispo,
        `total_dispo` = :total_dispo,
        `capacite_dispo` = :capacite_dispo
        WHERE `codeStation_dispo` = :codeStation;";
        $sqlUpdate = $pdo->prepare($requeteUpdate);
        $sqlUpdate->bindValue(':ouvert_dispo', checkIfOpenStation($data->is_renting), PDO::PARAM_INT);
        $sqlUpdate->bindValue(':evelo_dispo', $data->ebike, PDO::PARAM_INT);
        $sqlUpdate->bindValue(':velo_dispo', $data->mechanical, PDO::PARAM_INT);
        $sqlUpdate->bindValue(':total_dispo', $data->numbikesavailable, PDO::PARAM_INT);
        $sqlUpdate->bindValue(':capacite_dispo', $data->capacity, PDO::PARAM_INT);
        $sqlUpdate->bindValue(':codeStation', $codeStation, PDO::PARAM_INT);
        $sqlUpdate->execute();
        if($sqlUpdate->errorInfo()[0] != 00000 ){
            print_r($sqlUpdate->errorInfo());
        }
    } else { //ajout si le tableau est vide
        $requeteInsert = "INSERT INTO `dispo` (`codeStation_dispo`, `ouvert_dispo`, `evelo_dispo`, `velo_dispo`, `total_dispo`, `capacite_dispo`) VALUES (:codeStation, :ouvert_dispo, :evelo_dispo, :velo_dispo, :total_dispo, :capacite_dispo);";
        // pas de guimmets ici avant :
        $sqlInsert = $pdo->prepare($requeteInsert);
        $sqlInsert->bindValue(':codeStation', $codeStation, PDO::PARAM_INT);

        $sqlInsert->bindValue(':ouvert_dispo', checkIfOpenStation($data->is_renting), PDO::PARAM_INT);

        $sqlInsert->bindValue(':evelo_dispo', $data->ebike, PDO::PARAM_INT);
        $sqlInsert->bindValue(':velo_dispo', $data->mechanical, PDO::PARAM_INT);
        $sqlInsert->bindValue(':total_dispo', $data->numbikesavailable, PDO::PARAM_INT);
        $sqlInsert->bindValue(':capacite_dispo', $data->capacity, PDO::PARAM_INT);
        $sqlInsert->execute();
        if($sqlInsert->errorInfo()[0] != 00000 ){
            print_r($sqlInsert->errorInfo());
        }
        
    }

}


/*
    Vérification qu'une station est ouverte
    @data string : valeur OUI/NON de l'ouverture d'une station
*/
function checkIfOpenStation($data){
    return $data == "OUI" ? 1 : 0;
}


/* 
    Récupération des données de l'API VELIB
    @codeArret int : code de l'arrêt de vélib
*/
function getJsonFromAPI($codeArret){
    $source = "http://opendata.paris.fr/api/records/1.0/search/?dataset=velib-disponibilite-en-temps-reel&q=&facet=stationcode&refine.stationcode=".$codeArret;
    $ch = curl_init($source);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec ($ch);
    $error = curl_error($ch); 
    curl_close ($ch);

    if($error){
        error_log($error);
        die('Problème pour la récupération de données');
    }
    return json_decode($data)->records[0]->fields;
}