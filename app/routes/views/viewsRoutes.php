<?php

use brisacode\Page;
use brisacode\TibiaCalculator;


$app->get('/', function () {	
	

	$page = new page();	
	$page->draw("home");

});


$app->post('/result', function () {	

	$data = $_POST['partyanalyser'];

	$result = new TibiaCalculator($data);

	//echo json_encode( $result->getTopData() );
	
	$page = new page([
		'sessiondata'=>$result->getPayments(),
		'toploot'=>$result->getTopListLoot(),
		'topsupplies'=>$result->getTopListSupplies(),
		'topbalance'=>$result->getTopListBalance(),
		'topdamage'=>$result->getTopListDamage(),
		'tophealing'=>$result->getTopListHealing()
	]);	

	$page->draw("result");

});



$app->get('/brisa', function () {	
	
	
	$page = new page();	
	$page->draw("brisa");

});


