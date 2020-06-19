<?php

use brisacode\TibiaCalculator;

$app->get('/api/PartyHuntanalyser', function () {
    echo "retorna a lógica para party hunt analyser";
});


$app->post('/api/analyser/getdata', function () {    

   if( isset( $_POST['analyserData']) ){

        $data = new TibiaCalculator($_POST['analyserData']);       

        echo json_encode($data->FindPlayersData());

    }else{

        echo json_encode([
            "error"=>2222,
            "msg"=>"Analyser data expected not found."

        ]);
    }
    
});





