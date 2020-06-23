<?php

require('./config.php');

use slim\Slim;
use brisacode\Page;

$app = new \Slim\Slim();

/**
 * Rota Home
 */
$app->get('/', function () {	
	
	$page = new page();	
	$page->draw("home");

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






















