<?php

use brisacode\TibiaCalculator;
use brisacode\TibiaDataExtractor;

$app->get('/api/PartyHuntanalyser', function () {
    echo "retorna a lógica para party hunt analyser";
});


$app->post('/api/analyser/getdata', function () {

    if (isset($_POST['analyserData'])) {

        $data = new TibiaDataExtractor($_POST['analyserData']);

        echo json_encode($data->getExtractedSessionData());
    } else {

        echo json_encode([
            "error" => 2222,
            "msg" => "Analyser data expected not found."
        ]);
    }
});

$app->get('/teste', function () {

    $analyserData = "Session data: From 2020-06-26, 13:08:28 to 2020-06-26, 14:48:41
    Session: 01:40h
    Loot Type: Leader
    Loot: 2,527,880
    Supplies: 889,216
    Balance: 1,638,664
    Bambamsz
        Loot: 0
        Supplies: 475,931
        Balance: -475,931
        Damage: 4,273,541
        Healing: 2,679,044
    Kall Aley (Leader)
        Loot: 2,255,580
        Supplies: 162,480
        Balance: 2,093,100
        Damage: 3,387,807
        Healing: 81,342
    Xongu
        Loot: 272,300
        Supplies: 250,805
        Balance: 21,495
        Damage: 4,464,107
        Healing: 352,501
    ";


    $data = new TibiaCalculator( $analyserData );

    echo json_encode( $data->getHigherHealing() );
   
});





