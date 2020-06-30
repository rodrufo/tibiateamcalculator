<?php

require('./config.php');

use slim\Slim;
use brisacode\Page;
use brisacode\TibiaCalculator;

$app = new \Slim\Slim();


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






















