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

    $analyserData = "Session data: From 2020-06-10, 19:05:09 to 2020-06-10, 19:26:12
Session: 00:21h
Loot Type: Leader
Loot: 1,450,466
Supplies: 1,048,579
Balance: 401,887
Bamzay
	Loot: 84,556
	Supplies: 184,233
	Balance: -99,677
	Damage: 218,651
	Healing: 460,218
Biro Devius
	Loot: 144,455
	Supplies: 40,586
	Balance: 103,869
	Damage: 323,241
	Healing: 21,683
Casillera (Leader)
	Loot: 257,221
	Supplies: 93,566
	Balance: 163,655
	Damage: 150,835
	Healing: 76,706
Incsent Blackfingers
	Loot: 175,611
	Supplies: 214,092
	Balance: -38,481
	Damage: 187,107
	Healing: 375,707
Oktoryz
	Loot: 110,189
	Supplies: 98,165
	Balance: 12,024
	Damage: 123,147
	Healing: 91,122
Palla du lipe
	Loot: 128,058
	Supplies: 29,196
	Balance: 98,862
	Damage: 227,027
	Healing: 20,682
Rods Rufo
	Loot: 131,532
	Supplies: 175,937
	Balance: -44,405
	Damage: 314,814
	Healing: 2,921
Takash
	Loot: 105,130
	Supplies: 24,920
	Balance: 80,210
	Damage: 317,762
	Healing: 44,869
Timatos
	Loot: 198,718
	Supplies: 48,519
	Balance: 150,199
	Damage: 327,758
	Healing: 40,944
Xongu
	Loot: 114,996
	Supplies: 139,365
	Balance: -24,369
	Damage: 297,061
	Healing: 0";


    $data = new TibiaCalculator($analyserData);


    var_dump($data->payments());
});





