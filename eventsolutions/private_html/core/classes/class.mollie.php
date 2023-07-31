<?php
class mollie {	
    
    private $token = "live_sTvSQJWaUEQTTWNJCvukGs6fabxCwS";
    //private $token = "test_RASHVHSGs46GxvME9WKvQhgz5r4xep";
    
    function createPayment(string $betaalcode, string $method, string $issuer = null) {
        
        $factuurdata = facturatie::opBetaalcode($betaalcode);
        $redirectUrl = "https://payments.".HOST."/status/".$factuurdata->betaalcode;
        $webhookUrl = "https://payments.".HOST."/webhook/response";
        
        $factuurTotaal = number_format($factuurdata->totaal, 2,'.','');
        $data = array(
            "description" => "Factuur ".$factuurdata->nummer, 
            "amount" => array(
                "currency" => "EUR",
                "value" => $factuurTotaal
            ),
            "locale" => "nl_NL",
            "redirectUrl" => $redirectUrl,
            "webhookUrl" => $webhookUrl,
            "method" => $method,
            "issuer" => $issuer,
            "metadata" => array("factuurNr" => $factuurdata->nummer, "betaalcode" => $factuurdata->betaalcode)
        ); 
        $dataset = json_encode($data, true);
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token,                          
                'Content-Length: ' . strlen($dataset))
        );
        $curl = curl_init("https://api.mollie.com/v2/payments");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataset);                                                                                                                                       

        $result = json_decode(curl_exec($curl));
        return $result->_links->checkout->href;
    }

    
    function getPaymentInfo($transactionId) {
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token)
        );
        $curl = curl_init("https://api.mollie.com/v2/payments/".$transactionId);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                                                                                      

        $result = json_decode(curl_exec($curl));
        return $result;
    }
    
    function getMethods() {
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token)
        );
        $curl = curl_init("https://api.mollie.com/v2/methods?includeWallets=applepay&include=issuers");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                                                                                      

        $result = json_decode(curl_exec($curl));
        return $result;
    }
}