<?php

class Currencies{
    
   public $usd;
   public $eur;

   public $extUsd;
   public $extEur;

    public function __construct()
    {}

    public function calculate() {

        $settedCurrencies = get_option('wsep_currencies');

        $extCurrencies = $this->getCurrencies();

        $this->extUsd = $extCurrencies['usd'];
        $this->extEur = $extCurrencies['eur'];

        if($settedCurrencies) {
            $this->usd = $settedCurrencies['usd'];
            $this->eur = $settedCurrencies['eur'];
            
        } else {
            $this->usd = $extCurrencies['usd'];
            $this->eur = $extCurrencies['eur'];
        }       
    }

    /*
     * Get optimal currencies (usd / eur) via nbu and privatbank api 
     */
    private function getCurrencies() {
        $nbuCurrencies = json_decode($this->request('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json'));
        $privarCurrencies = json_decode($this->request('https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5'));

        $nbuUsd = $this->findCurrency( $nbuCurrencies, 'USD', 'cc', 'rate');
        $nbuEur = $this->findCurrency( $nbuCurrencies, 'EUR', 'cc', 'rate');

        $privUsd = $this->findCurrency( $privarCurrencies, 'USD', 'ccy', 'sale');
        $privEur = $this->findCurrency( $privarCurrencies, 'EUR', 'ccy', 'sale');

        if(isset($privUsd) && isset($privEur)){
            return array('usd' => $privUsd, 'eur' => $privEur);
        }
        
        return array('usd' => $nbuUsd, 'eur' => $nbuEur);
    }
    /**
     * Find currency in array of objects
     */
    private function findCurrency($rows, $curency, $currencyFieldName, $currencyFieldValue) {
        $index = array_search($curency, array_column($rows, $currencyFieldName));
        return $rows[$index]->$currencyFieldValue;
    }
    /**
     * For api request
     */
    private function request($url) {
        $curl = curl_init(); 

        $headers = []; 

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_VERBOSE, 1); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);

        $result = curl_exec($curl);

        return $result;

    }
}