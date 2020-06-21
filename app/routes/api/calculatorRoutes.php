<?php

use brisacode\TibiaCalculator;

$app->get('/api/PartyHuntanalyser', function () {
    echo "retorna a lógica para party hunt analyser";
});


$app->post('/api/analyser/getdata', function () {    

   if( isset( $_POST['analyserData']) ){

        $data = new TibiaCalculator($_POST['analyserData']); 
        
        $data->generateExtractedSessionData();

        echo json_encode($data->getExtractedSessionData());

    }else{

        echo json_encode([
            "error"=>2222,
            "msg"=>"Analyser data expected not found."

        ]);
    }
    
});



$app->get('/teste', function () {

    $analyserData = "Session data: From 2020-06-20, 19:40:01 to 2020-06-20, 20:02:13
    Session: 00:22h
    Loot Type: Leader
    Loot: 1,335,861
    Supplies: 1,596,629
    Balance: -260,768
    Biro Devius
        Loot: 157,401
        Supplies: 97,558
        Balance: 59,843
        Damage: 347,501
        Healing: 53,543
    Huguera Cremosin
        Loot: 180,027
        Supplies: 261,440
        Balance: -81,413
        Damage: 284,383
        Healing: 639,098
    Kinawarloke
        Loot: 51,626
        Supplies: 188,380
        Balance: -136,754
        Damage: 124,875
        Healing: 198,341
    Oktoryz
        Loot: 102,418
        Supplies: 82,065
        Balance: 20,353
        Damage: 129,557
        Healing: 52,946
    Palla du lipe
        Loot: 157,451
        Supplies: 77,376
        Balance: 80,075
        Damage: 265,059
        Healing: 22,450
    Rods Rufo
        Loot: 173,968
        Supplies: 228,080
        Balance: -54,112
        Damage: 323,534
        Healing: 4,001
    Takash
        Loot: 147,769
        Supplies: 61,397
        Balance: 86,372
        Damage: 392,361
        Healing: 36,518
    Timatos
        Loot: 151,309
        Supplies: 73,189
        Balance: 78,120
        Damage: 382,782
        Healing: 23,515
    Umponeifeliz Valepordois
        Loot: 96,300
        Supplies: 294,119
        Balance: -197,819
        Damage: 184,412
        Healing: 589,375
    Xongu (Leader)
        Loot: 117,592
        Supplies: 233,025
        Balance: -115,433
        Damage: 362,761
        Healing: 0";
    

        $data = new TibiaCalculator($analyserData); 
        
        $data->generateExtractedSessionData();

        echo json_encode($data->getExtractedSessionData());
        

        
       

       
});





