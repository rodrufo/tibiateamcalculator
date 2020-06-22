<?php

namespace brisacode;

class TibiaCalculator extends TibiaDataExtractor {

    private $partyData;

    public function payments() {

        $extractedData = new TibiaDataExtractor($this->getPartyData());
        $calculator = array(
            'balance' => 0,
            'individualBalance' => 0,
            'pay' => array(),
            'payto' => array()
        );
        $payments = array();

        foreach ($extractedData->getExtractedSessionData()['players'] as $i => $player)
            $calculator['balance'] += $player['balance'];

        if ($calculator['balance'] != 0)
            $calculator['individualBalance'] = $calculator['balance'] / $extractedData->getNumberOfPlayers();

        foreach ($extractedData->getExtractedSessionData()['players'] as $i => $player)
            $calculator['pay'][$player['nome']] = $calculator['individualBalance'] - $player['balance'];

        foreach ($calculator['pay'] as $nome => $individualBalanceCorrigido)
            if ($individualBalanceCorrigido < 0)
                $calculator['payto'][$nome] = $individualBalanceCorrigido;

        foreach ($calculator['pay'] as $nome => $individualBalanceCorrigido)
            if ($individualBalanceCorrigido > 0) {
                foreach ($calculator['payto'] as $nomePlayerPositivo => $individualBalanceCorrigidoPayto) {
                    if ($individualBalanceCorrigido > 0 && $individualBalanceCorrigidoPayto != 0) {
                        if ((-1 * $individualBalanceCorrigidoPayto) > $individualBalanceCorrigido) {
                            $payments[] = array(
                                'pagador' => $nomePlayerPositivo,
                                'valor' => round($individualBalanceCorrigido),
                                'recebedor' => $nome
                            );
                            $calculator['payto'][$nomePlayerPositivo] = $individualBalanceCorrigidoPayto + $individualBalanceCorrigido;
                            $individualBalanceCorrigido = 0;
                        } else {
                            $payments[] = array(
                                'pagador' => $nomePlayerPositivo,
                                'valor' => round(-1 * $individualBalanceCorrigidoPayto),
                                'recebedor' => $nome
                            );
                            $calculator['payto'][$nomePlayerPositivo] = 0;
                            $individualBalanceCorrigido += $individualBalanceCorrigidoPayto;
                        }
                    }
                }
            }

        return array(
            'balance' => $calculator['balance'],
            'individualBalance' => round($calculator['individualBalance']),
            'payments' => $payments
        );
    }

    public function setPartyData($data) {
        $this->partyData = $data;
    }

    public function getPartyData() {
        return $this->partyData;
    }

    public function __construct($partyData) {
        $this->setPartyData($partyData);
    }

}
