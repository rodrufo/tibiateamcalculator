<?php

namespace brisacode;

class TibiaDataExtractor
{


    /**
     * Atributos
     */

    private $partyData;
    private $numberOfPlayers;
    private $totalBalance;
    private $playersData;
    private $sessionDate;
    private $sessionStart;
    private $sessionEnd;
    private $extractedSessionData;



    /**
     * Get the value of partyData
     */
    public function getPartyData()
    {
        return $this->partyData;
    }

    /**
     * Set the value of partyData
     *
     * @return  self
     */
    public function setPartyData($partyData)
    {
        $this->partyData = $partyData;

        return $this;
    }

    /**
     * Get the value of numberOfPlayers
     */
    public function getNumberOfPlayers()
    {
        return $this->numberOfPlayers;
    }

    /**
     * Set the value of numberOfPlayers
     *
     * @return  self
     */
    public function setNumberOfPlayers($numberOfPlayers)
    {
        $this->numberOfPlayers = $numberOfPlayers;

        return $this;
    }

    /**
     * Get the value of totalBalance
     */
    public function getTotalBalance()
    {
        return $this->totalBalance;
    }

    /**
     * Set the value of totalBalance
     *
     * @return  self
     */
    public function setTotalBalance($totalBalance)
    {
        $this->totalBalance = $totalBalance;

        return $this;
    }

    /**
     * Get the value of playersData
     */
    public function getPlayersData()
    {
        return $this->playersData;
    }

    /**
     * Set the value of playersData
     *
     * @return  self
     */
    public function setPlayersData($playersData)
    {
        $this->playersData = $playersData;

        return $this;
    }

    /**
     * Get the value of sessionDate
     */
    public function getSessionDate()
    {
        return $this->sessionDate;
    }

    /**
     * Set the value of sessionDate
     *
     * @return  self
     */
    public function setSessionDate($sessionDate)
    {
        $this->sessionDate = $sessionDate;

        return $this;
    }

    /**
     * Get the value of sessionStart
     */
    public function getSessionStart()
    {
        return $this->sessionStart;
    }

    /**
     * Set the value of sessionStart
     *
     * @return  self
     */
    public function setSessionStart($sessionStart)
    {
        $this->sessionStart = $sessionStart;

        return $this;
    }

    /**
     * Get the value of sessionEnd
     */
    public function getSessionEnd()
    {
        return $this->sessionEnd;
    }

    /**
     * Set the value of sessionEnd
     *
     * @return  self
     */
    public function setSessionEnd($sessionEnd)
    {
        $this->sessionEnd = $sessionEnd;

        return $this;
    }

    /**
     * Get the value of extractedSessionData
     */
    public function getExtractedSessionData()
    {
        return $this->extractedSessionData;
    }

    /**
     * Set the value of extractedSessionData
     *
     * @return  self
     */
    public function setExtractedSessionData($extractedSessionData)
    {
        $this->extractedSessionData = $extractedSessionData;

        return $this;
    }



    /**
     * Metodos
     */



    public function __construct($partyData)
    {

        $this->SetPartyData($partyData . " ");
        $this->findTotalBalance();
        $this->findNumberOfPlayers();
        $this->findSessionDate();
        $this->findSessionDate();
        $this->findSessionStart();
        $this->findSessionEnd();
        $this->findPlayersData();
        $this->findNumberOfPlayers();
        $this->generateExtractedSessionData();
    }


    public function findSessionDate()
    {

        $partyData = $this->getPartyData();

        $partyData = substr($partyData, 0, strpos($partyData, "Session:"));

        $sessionDate = trim($this->GetStringBetween($partyData, "From", ","));

        $this->setSessionDate(date("d/m/Y", strtotime($sessionDate)));
    }


    public function findSessionStart()
    {

        $partyData = $this->getPartyData();

        $partyData = substr($partyData, 0, strpos($partyData, "Session:"));

        $sessionStart = trim($this->getStringBetween($partyData, ",", "to"));

        $this->setSessionStart($sessionStart);
    }


    public function findSessionEnd()
    {

        $partyData = $this->getPartyData();

        $partyData = trim(substr($partyData, 0, strpos($partyData, "Session:")));

        $sessionEnd = date("h:m:i", strtotime(substr($partyData, strlen($partyData) - 8, 8)));

        $this->setSessionEnd($sessionEnd);
    }


    public function findTotalBalance()
    {

        $partyData = $this->getPartyData();

        $totalBalance = trim($this->getStringBetween($partyData, "Balance: ", " "));

        $totalBalance = str_replace(",", "", $totalBalance);

        $this->setTotalBalance($totalBalance);
    }


    public function findNumberOfPlayers()
    {

        $numberOfPlayers = substr_count($this->getPartyData(), "Balance:") - 1;

        $this->setNumberOfPlayers((int) $numberOfPlayers);
    }



    public function findPlayersData()
    {

        $partyData = $this->SanitazePartyData();

        $playersData['players'] = [];

        for ($i = 0; $i < $this->getNumberOfPlayers(); $i++) {

            $name = trim(preg_replace('/[0-9]+/', '', str_replace(",", "", substr($partyData, 0, strpos($partyData, "Loot:")))));

            $loot = trim(str_replace(",", "", $this->GetStringBetween($partyData, "Loot:", "Supplies:")));

            $supplies = trim(str_replace(",", "", $this->GetStringBetween($partyData, "Supplies:", "Balance:")));

            $balance = trim(str_replace(",", "", $this->GetStringBetween($partyData, "Balance:", "Damage:")));

            $damage = trim(str_replace(",", "", $this->GetStringBetween($partyData, "Damage:", "Healing:")));

            $healing = preg_replace("/[^0-9]/", "", $this->GetStringBetween($partyData, "Healing: ", " "));

            array_push($playersData['players'], [
                "name"     => $name,
                "loot"     => $loot,
                "supplies" => $supplies,
                "balance"  => $balance,
                "damage"   => $damage,
                "healing"  => $healing

            ]);

            $partyData = substr_replace($partyData, "", 0, strpos($partyData, "Healing: ") + strlen("Healing: "));
        }

        $this->SetPlayersData($playersData);
    }



    public function generateExtractedSessionData()
    {

        $playersData = $this->getPlayersData();

        $playersData['sessiondate'] = $this->getSessionDate();

        $playersData['sessionstart'] = $this->getSessionStart();

        $playersData['sessionend'] = $this->getSessionEnd();

        $this->setExtractedSessionData($playersData);
    }


    /**
     * Helpers
     */

    private  function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    public function sanitazePartyData()
    {

        $partyData = $this->GetPartyData();

        $partyData = substr_replace($partyData, "", 0, strpos($partyData, "Balance:") + 8);

        $firstPlayer = strpos($partyData, "Loot:");

        $firstPlayer = substr($partyData, 0, $firstPlayer);

        $firstPlayer = str_replace(",", "", $firstPlayer);

        $firstPlayer = str_replace("-", "", $firstPlayer);

        $firstPlayer = preg_replace('/[0-9]+/', '', $firstPlayer);

        $firstPlayer = trim($firstPlayer);

        $cleanedData = $this->GetPartyData();

        $cleanedData = substr_replace($cleanedData, "", 0, strpos($cleanedData, $firstPlayer));

        $cleanedData = str_replace("\n", "", $cleanedData);

        $cleanedData = str_replace("\r", "", $cleanedData);

        $cleanedData = str_replace(" (Leader)", "", $cleanedData);

        return $cleanedData;
    }
}
