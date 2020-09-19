<?php

namespace App\Models;


use Illuminate\Support\Facades\Log;

class WsPay
{
    
    /**
     * @var string
     */
    protected $secret;
    
    
    /**
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }
    
    
    /**
     * @param string $shopId
     * @param string $orderId
     * @param float  $amount
     *
     * @return string
     */
    public function signature($shopId, $orderId, $amount)
    {
        $amountForSignature = $this->cleanAmount($amount);
        
        return md5(implode($this->secret, [$shopId, $orderId, $amountForSignature]) . $this->secret);
    }
    
    
    /**
     * @param $returnSignature
     * @param $shopId
     * @param $orderId
     * @param $success
     * @param $approvalCode
     *
     * @return bool
     */
    public function validate($returnSignature, $shopId, $orderId, $success, $approvalCode)
    {
        return $returnSignature === $this->calculateValidationSignature($shopId, $orderId, $success, $approvalCode);
    }
    
    
    /**
     * @param $shopId
     * @param $orderId
     * @param $success
     * @param $approvalCode
     *
     * @return string
     */
    public function calculateValidationSignature($shopId, $orderId, $success, $approvalCode)
    {
        return md5(implode($this->secret, [$shopId, $orderId, $success, $approvalCode]) . $this->secret);
        //return md5($shopId . $this->secret . $orderId . $this->secret . $success . $this->secret . $approvalCode . $this->secret);
    }
    
    
    /**
     * @param $amount
     *
     * @return string
     */
    protected function cleanAmount($amount)
    {
        return number_format($amount, 2, '', '');
    }
    
    
    /**
     * @param $currency
     *
     * @return mixed
     */
    public static function getHNBCurrencyValue($currency = 'EUR')
    {
        if (session()->has($currency)) {
            return session($currency);
        }
        
        $response = json_decode(file_get_contents('http://api.hnb.hr/tecajn/v1?valuta=' . $currency));
        $value    = str_replace(',', '.', $response[0]->{'Srednji za devize'});
        
        session([$currency => $value]);
        
        return $value;
    }
    
}
