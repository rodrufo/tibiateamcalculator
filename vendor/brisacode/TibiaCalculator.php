<?php

namespace brisacode;

class TibiaCalculator extends TibiaDataExtractor{

private $payments;






/**
 * Get the value of payments
 */ 
public function getPayments()
{
return $this->payments;
}

/**
 * Set the value of payments
 *
 * @return  self
 */ 
public function setPayments($payments)
{
$this->payments = $payments;

return $this;
}




public function payments(){

$profit = $this->getTotalBalance();

return $profit;

if( $profit > 0 ){    

}else{

}





}





}






















