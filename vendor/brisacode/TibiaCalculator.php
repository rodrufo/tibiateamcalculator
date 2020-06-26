<?php

namespace brisacode;


class TibiaCalculator extends TibiaDataExtractor
{

    private $payments = [];    
    private $higherLoot = [];
    private $higherSupplies = [];
    private $higherBalance = [];
    private $higherDamage = [];
    private $higherHealing = [];   



    

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

    /**
     * Get the value of higherDamage
     */
    public function getHigherDamage()
    {
        return $this->higherDamage;
    }

    /**
     * Set the value of higherDamage
     *
     * @return  self
     */
    public function setHigherDamage($higherDamage)
    {
        $this->higherDamage = $higherDamage;

        return $this;
    }


    /**
     * Get the value of higherSupplies
     */ 
    public function getHigherSupplies()
    {
        return $this->higherSupplies;
    }

    /**
     * Set the value of higherSupplies
     *
     * @return  self
     */ 
    public function setHigherSupplies($higherSupplies)
    {
        $this->higherSupplies = $higherSupplies;

        return $this;
    }


    /**
     * Get the value of higherBalance
     */ 
    public function getHigherBalance()
    {
        return $this->higherBalance;
    }

    /**
     * Set the value of higherBalance
     *
     * @return  self
     */ 
    public function setHigherBalance($higherBalance)
    {
        $this->higherBalance = $higherBalance;

        return $this;
    }


    /**
     * Get the value of higherHealing
     */ 
    public function getHigherHealing()
    {
        return $this->higherHealing;
    }

    /**
     * Set the value of higherHealing
     *
     * @return  self
     */ 
    public function setHigherHealing($higherHealing)
    {
        $this->higherHealing = $higherHealing;

        return $this;
    }



    public function __construct( $analyserData )
    {

        parent::__construct($analyserData);

        $this->findpayments();
        $this->findHigherDamage();
        $this->findHigherSupplies();
        $this->findHigherBalance();
        $this->findHigherHealing();
    }

    



    public function findpayments()
    {

        // $extractedData = new TibiaDataExtractor($this->getPartyData());

        $calculator = array(

            'individualBalance' => 0,
            'pay' => array(),
            'receiver' => array()
        );

        $payments = array();


        if ($this->getTotalBalance() != 0) {

            $calculator['individualBalance'] = $this->getTotalBalance() / $this->getNumberOfPlayers();
        }

        foreach ($this->getplayersData()['players'] as $i => $player) {

            $calculator['pay'][$player['name']] = $calculator['individualBalance'] - $player['balance'];
        }

        foreach ($calculator['pay'] as $name => $correctedIndividualBalance) {

            if ($correctedIndividualBalance < 0)

                $calculator['receiver'][$name] = $correctedIndividualBalance;
        }

        foreach ($calculator['pay'] as $name => $correctedIndividualBalance) {

            if ($correctedIndividualBalance > 0) {

                foreach ($calculator['receiver'] as $namePlayerPositivo => $positivePlayer) {

                    if ($correctedIndividualBalance > 0 && $positivePlayer != 0) {

                        if ((-1 * $positivePlayer) > $correctedIndividualBalance) {

                            $payments[] = array(

                                'payer' => $namePlayerPositivo,
                                'value' => round($correctedIndividualBalance),
                                'receiver' => $name

                            );

                            $calculator['receiver'][$namePlayerPositivo] = $positivePlayer + $correctedIndividualBalance;

                            $correctedIndividualBalance = 0;
                        } else {

                            $payments[] = array(

                                'payer' => $namePlayerPositivo,
                                'value' => round(-1 * $positivePlayer),
                                'receiver' => $name
                            );

                            $calculator['receiver'][$namePlayerPositivo] = 0;

                            $correctedIndividualBalance += $positivePlayer;
                        }
                    }
                }
            }
        }

        $payments =  array(
            'totalbalance' => $this->getTotalBalance(),
            'individualBalance' => round($calculator['individualBalance']),
            'payments' => $payments
        );

        $this->setPayments($payments);
    }




   public function findHigherDamage(){ 
       
        $higherDamage = $this->findHigher('damage');

        $higherDamageArr = [];

        foreach ($this->getPlayersData()['players'] as $key => $value) {            

            if( $value['damage'] == $higherDamage ){

                array_push( $higherDamageArr, [
                    'name' => $value['name'],
                    'damage' => $value['damage']
                    
                ] );
            }            
        }

        $this->setHigherDamage($higherDamageArr);
        
    }


    public function findHigherSupplies(){ 
       
        $higherSupplies = $this->findHigher('supplies');

        $higherSuppliesArr = [];

        foreach ($this->getPlayersData()['players'] as $key => $value) {            

            if( $value['supplies'] == $higherSupplies ){

                array_push( $higherSuppliesArr, [
                    'name'=> $value['name'],
                    'supplies'=> $value['supplies']
                ]);
            }            
        }

        $this->setHigherSupplies($higherSuppliesArr);
        
    }
    



    public function findHigherBalance(){

        $higherBalance = $this->findHigher('balance');

        $higherBalanceArr = [];

        foreach ($this->getPlayersData()['players'] as $key => $value) {            

            if( $value['balance'] == $higherBalance){

                array_push( $higherBalanceArr, [
                    'name'=> $value['name'],
                    'balance'=> $value['balance']
                ]);
            }            
        }

        $this->setHigherBalance($higherBalanceArr);
    }



    public function findHigherHealing(){

        $higherHealing = $this->findHigher('healing');

        $higherHealingArr = [];

        foreach ($this->getPlayersData()['players'] as $key => $value) {            

            if( $value['healing'] == $higherHealing){

                array_push( $higherHealingArr, [
                    'name'=> $value['name'],
                    'healing'=> $value['healing']
                ]);
            }            
        }

        $this->setHigherhealing($higherHealingArr);
        
    }
    


    public function findHigher( $serchedKey ){         
        
        $players = $this->getPlayersData()['players'];
        $higher = 0;

        foreach ( $players as $key => $value ) {            
            
            if( $value[$serchedKey] > $higher ){ 

                $higher = $value[$serchedKey];                
            }    
        }       

        return $higher;

    }










    

    

    
}
