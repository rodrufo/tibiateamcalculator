<?php

use brisacode\Page;

$app->get('/', function () {	
	
	$page = new page();	
	$page->draw("home");

});


$app->get('/brisa', function () {	
	
	$page = new page();	
	$page->draw("brisa");

});


