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

    $analyserData = "Session data: From 2020-06-27, 15:28:06 to 2020-06-27, 17:00:06
	Session: 01:32h
	Loot Type: Leader
	Loot: 2,299,000
	Supplies: 1,151,690
	Balance: 1,147,310
	Bambamsz
		Loot: 0
		Supplies: 537,069
		Balance: -537,069
		Damage: 3,328,708
		Healing: 2,290,161
	Kall Aley (Leader)
		Loot: 1,762,070
		Supplies: 146,515
		Balance: 1,615,555
		Damage: 2,719,248
		Healing: 86,654
	King Zarug
		Loot: 531,380
		Supplies: 225,025
		Balance: 306,355
		Damage: 1,933,417
		Healing: 220,804
	Xongu
		Loot: 5,550
		Supplies: 243,081
		Balance: -237,531
		Damage: 4,056,825
		Healing: 336,930";


    $data = new TibiaCalculator($analyserData);

    $response = array(
        'payments' => $data->getPayments(),
        
    );

    echo json_encode($response);
});





