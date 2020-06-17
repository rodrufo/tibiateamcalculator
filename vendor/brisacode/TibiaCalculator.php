<?php

namespace brisacode;

class TibiaCalculator{

    
/**
 * Atributos
 */

private $partyData;
private $numberOfPlayers;
private $totalBalance;



/**
 * Geters & Seters
 */

public function SetPartyData($partyData){

    $this->partyData = $partyData;
}


public function GetPartyData(){

    return $this->partyData;
}


public function SetNumbersOfPlayers($numberOfPlayers){

    $this->numberOfPlayers = $numberOfPlayers;
}


public function GetNumbersOfPlayers(){

    return $this->numberOfPlayers;
}


public function SetTotalBalance($totalBalance){

    $this->totalBalance = $totalBalance;
}


public function GetTotalBalance(){

    return $this->totalBalance;
}




public function __construct($partyData){

    $this->SetPartyData($partyData); 

    $this->SetTotalBalance($this->FindTotalBalance());
    
    $this->SetNumbersOfPlayers($this->FindNumberOfPlayers());  
    
}



/**
 * Returns Total Balance of team hunt
 */
public function FindTotalBalance(): int {

    $balancePosition =  strpos( $this->partyData, 'Balance: ');

    $totalbalance = str_replace(",", "", str_replace(" ", "", substr($this->partyData, $balancePosition + 9, 12 ) ))   ;
    
    return (int)$totalbalance;

}

/**
 * Returns the number of players in party analyser
 */
public function FindNumberOfPlayers(): int {

    $numberOfPlayers = substr_count($this->partyData, "Balance:");

    return  (int)$numberOfPlayers -1;
}


/**
 * Returns players data
 */
public function FindPlayersData(){     

    $partydata = $this->SanitazePartyData(); 

    $playersAndBalance = [];

   for ($i=0; $i < $this->GetNumbersOfPlayers(); $i++) {     

    $name = preg_replace('/[0-9]+/', '', trim(substr($partydata, 0, strpos($partydata, "Loot:") ) )  );

    $loot = trim($this->GetStringBetween($partydata, "Loot:", "Supplies:"));

    $supplies = trim($this->GetStringBetween($partydata, "Supplies:", "Balance:"));

    $balance = trim( $this->GetStringBetween($partydata, "Balance:", "Damage:") );

    $damage = trim($this->GetStringBetween($partydata, "Damage:", "Healing:"));

    $healing = preg_replace("/[^0-9]/", "", $this->GetStringBetween($partydata, "Healing: ", " ")) ;
        
    array_push($playersAndBalance, [
        "nome"     => $name,
        "Loot"     => $loot,
        "balance"  => $balance,
        "Supplies" => $supplies,
        "damage"   => $damage,
        "healing"  => $healing

    ]);

    $partydata = substr_replace($partydata, "", 0, strpos($partydata, "Healing: ") + strlen("Healing: "));
        
    }
 
    

    //var_dump($partydata); 
    return $playersAndBalance; 
    
}



/**
 * Helpers
 */

public  function GetStringBetween($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}



public function SanitazePartyData(){

    $partyData = $this->GetPartyData();

    $partyData = substr_replace($partyData,"",0,strpos($partyData, "Balance:") + 8);
    
    $firstPlayer = strpos( $partyData, "Loot:");

    $firstPlayer = substr( $partyData, 0, $firstPlayer );

    $firstPlayer = str_replace(",", "", $firstPlayer );

    $firstPlayer = preg_replace('/[0-9]+/', '', $firstPlayer ); 

    $firstPlayer = trim($firstPlayer);

    $cleanedData = $this->GetPartyData();

    $cleanedData = substr_replace($cleanedData,"", 0, strpos($cleanedData, $firstPlayer));

    $cleanedData = str_replace(",", "", $cleanedData);

    $cleanedData = str_replace(" (Leader)", "", $cleanedData);
    
    $cleanedData = str_replace("\n", "", $cleanedData);

    $cleanedData = str_replace("\r", "", $cleanedData);

    return $cleanedData;
}


}

