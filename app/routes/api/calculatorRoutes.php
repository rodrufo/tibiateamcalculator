<?php

use brisacode\TibiaCalculator;
use brisacode\TibiaDataExtractor;

$app->get('/api/PartyHuntanalyser', function () {
    echo "retorna a lógica para party hunt analyser";
});


$app->post('/api/analyser/getdata', function () {

    if (isset($_POST['analyserData'])) {
        $data = new TibiaCalculator($_POST['analyserData']);

        $response = array(
            'payments' => $data->getPayments(),
            'topListLoot' => $data->getTopListLoot(),
            'topListSupplies' => $data->getTopListSupplies(),
            'topListBalance' => $data->getTopListBalance(),
            'topListDamage' => $data->getTopListDamage(),
            'topListHealing' => $data->getTopListHealing()
        );

        echo json_encode($response);
    } else {

        echo json_encode([
            "error" => 2222,
            "msg" => "Analyser data expected not found."
        ]);
    }
});

$app->get('/teste', function () {

    $analyserData = "Session data: From 2020-06-19, 19:07:25 to 2020-06-19, 19:26:49
Session: 00:19h
Loot Type: Leader
Loot: 1,434,639
Supplies: 1,052,720
Balance: 381,919
Bamzay
	Loot: 142,989
	Supplies: 236,950
	Balance: -93,961
	Damage: 152,738
	Healing: 450,876
Biro Devius
	Loot: 98,628
	Supplies: 56,201
	Balance: 42,427
	Damage: 333,811
	Healing: 15,376
Casillera (Leader)
	Loot: 108,273
	Supplies: 73,010
	Balance: 35,263
	Damage: 132,858
	Healing: 47,530
Huguera Cremosin
	Loot: 178,676
	Supplies: 189,440
	Balance: -10,764
	Damage: 245,831
	Healing: 362,376
Oktoryz
	Loot: 177,870
	Supplies: 61,137
	Balance: 116,733
	Damage: 117,648
	Healing: 47,334
Palla du lipe
	Loot: 105,900
	Supplies: 42,951
	Balance: 62,949
	Damage: 239,278
	Healing: 21,587
Rods Rufo
	Loot: 239,714
	Supplies: 153,333
	Balance: 86,381
	Damage: 282,145
	Healing: 1,183
Takash
	Loot: 151,089
	Supplies: 19,260
	Balance: 131,829
	Damage: 359,027
	Healing: 23,675
Timatos
	Loot: 91,200
	Supplies: 47,523
	Balance: 43,677
	Damage: 348,652
	Healing: 15,095
Xongu
	Loot: 140,300
	Supplies: 172,915
	Balance: -32,615
	Damage: 297,059
	Healing: 0";


    $data = new TibiaCalculator($analyserData);

    $response = array(
        'payments' => $data->getPayments(),
        'topListLoot' => $data->getTopListLoot(),
        'topListSupplies' => $data->getTopListSupplies(),
        'topListBalance' => $data->getTopListBalance(),
        'topListDamage' => $data->getTopListDamage(),
        'topListHealing' => $data->getTopListHealing()
    );

    echo json_encode($response);
});





