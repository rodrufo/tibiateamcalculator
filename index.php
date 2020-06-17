<?php

require('./config.php');

use slim\Slim;
use brisacode\page;
use brisacode\TibiaCalculator;

$app = new \Slim\Slim();

/**
 * Rota Home
 */
$app->get('/', function () {
    
    $teste = "Session data: From 2020-06-15, 10:55:08 to 2020-06-15, 12:20:53
Session: 01:25h
Loot Type: Market
Loot: 2,080,228
Supplies: 1,141,748
Balance: 938,480
Bambamsz
	Loot: 54
	Supplies: 451,014
	Balance: -450,960
	Damage: 2,057,357
	Healing: 1,711,012
Kall Aley
	Loot: 1,689,932
	Supplies: 126,035
	Balance: 1,563,897
	Damage: 2,218,125
	Healing: 85,912
Lord Vitinho
	Loot: 345,942
	Supplies: 286,407
	Balance: 59,535
	Damage: 2,137,442
	Healing: 692,228
Xongu (Leader)
	Loot: 44,300
	Supplies: 278,292
	Balance: -233,992
	Damage: 3,253,451
	Healing: 165,366 ";

   
$calc = new TibiaCalculator($teste);




//$calc->FindPlayersAndBalance();

echo json_encode($calc->FindPlayersData());



    

});








/**
 * Inclusão de rotas
 */

// Rotas da api de calculo
require_once('./app/routes/api/calculatorRoutes.php');


// Rotas de carregamento de views
require_once('./app/routes/views/viewsRoutes.php');






/**
 * Chama a inicialização das rotas
 */
$app->run();






















