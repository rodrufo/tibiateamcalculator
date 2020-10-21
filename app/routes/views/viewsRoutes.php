<?php

use brisacode\Page;
use brisacode\TibiaCalculator;


$app->get('/', function () {	
	

	$page = new page();	
	$page->draw("home");
        if (isset($_GET['error']) && $_GET['error'] == 500)
            echo '<script>alert("Desculpe, ocorreu um erro interno. Por favor, tente novamente.");</script>';
});


$app->post('/result', function () {	

	$data = $_POST['partyanalyser'];

        try {
            $result = new TibiaCalculator($data);

        } catch (Exception $e) {
            header('Location: /?error=500');
            exit;
        }

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
$app->get('/boss', function () {	
	
	
	$page = new page();	
	$page->draw("boss");

});


