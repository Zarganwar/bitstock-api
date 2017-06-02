<?php

namespace Zarganwar\Bitstock-api;

class Bitstock
{
  const URL = 'https://www.bitstock.com/api';

  const CURRENCY_CZK = 'czk';
  const CURRENCY_EUR = 'eur';
               
  private $keyPublic;
  
  private $keyPrivate;
  
  private $currency = self::CURRENCY_CZK;
  
  public function __construct($keyPublic = null, $keyPrivate = null)
  {
    if ($keyPublic !== null && $keyPrivate !== null) {
      $this->keyPublic = $keyPublic;
      $this->keyPrivate = $keyPrivate;
    }
  }
  
  public function switchCurrency($currency)
  {
    if (!in_array($currency, self::CURRENCY_CZK, self::CURRENCY_EUR)) {
      throw new \InvalidArgumentException("Unsupported currency '$currency'");
    }
    $this->currency = $currency;
  }
  
  public function getSignature($nonce)
  {
    $message = $nonce . $userId . $this->keyPublic;		
    $signature = hash_hmac("sha256", $message, $this->keyPrivate);
    $signature = strtoupper($signature);
  }
  
  protected function createRequest($method = 'GET', $postData = [])
  { 
    $curl = curl_init(self::URL);
     
    if ($method === 'POST') {
      $nonce = time();  
    
      $postData['nonce'] = $nonce;
      $postData['signature'] = $this->getSignature($nonce);;
      $postData['key'] = $this->keyPublic;
    
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
     }

     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
     $response = curl_exec($curl);
     curl_close($curl);
     
     return json_encode($response);       
  }
    
  public function orders()
  {
    return json_encode('{"asks":[[6780,0.05,0.05],[6800,0.05,0.05]],"bids":[[6580,1.6921,0.05],[6420,0.1026874,0.05]]}');
    return $this->createRequest('GET');
  }
  
  public function account()
  {
    
  }
    
  public function userTrades()
  {
    
  }
  
  public function openedOrders()
  {
    
  }
  
  public function createOrder()
  {
    
  }
  
}
