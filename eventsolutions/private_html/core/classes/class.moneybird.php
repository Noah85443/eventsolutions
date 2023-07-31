<?php
class Moneybird {	
    
    private $token = "2d523ff622e42ce6a76308ba291da8958b5b45dd672fc48c67157435dc3e57b8";
    private $administration = "165956099413903308"; // ES adminstratie
    
    function exportMoneybird($dataset) {
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token,                          
                'Content-Length: ' . strlen($dataset))
        );
        $curl = curl_init("https://moneybird.com/api/v2/{$this->administration}/external_sales_invoices.json?");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataset);                                                                                                                                       

        $result = json_decode(curl_exec($curl));
        return $result;
    }
	
    function exportMoneyBirdBijlage($id,$link) {
        $cfile = curl_file_create($link,'application/pdf','factuur');	
        $dataset = array("file" => $cfile);
        $headers = array(
            'Content-Type: multipart/mixed',
            sprintf('Authorization: Bearer %s ', $this->token)
        );
        $curl = curl_init("https://moneybird.com/api/v2/{$this->administration}/external_sales_invoices/{$id}/attachment.json?");
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataset);                                                                                                                                       
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  		
        $result = json_decode(curl_exec($curl));
        return $result;
    }
    
    function createInvoicePayment(int $invoiceId, string $paymentDate, string $paymentAmount) {
        $dataset = array(
            "payment" => array(
                "payment_date" => $paymentDate,
                "price" => $paymentAmount
            )
        );
        $dataset = json_encode($dataset,true);
        $extInvoiceId = facturatie::opFactuurNummer($invoiceId)->moneybirdId;
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token,                          
                'Content-Length: ' . strlen($dataset))
        );
        $curl = curl_init("https://moneybird.com/api/v2/{$this->administration}/external_sales_invoices/{$extInvoiceId}/payments.json?");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataset);                                                                                                                                       

        $result = json_decode(curl_exec($curl));
        return $result;
    }
    
    function createNewContact(string $contactCompany, string $contactFirstname, string $contactLastname) {
        $dataset = array (
            "contact" => array(
                "company_name" => $contactCompany,
                "firstname" => $contactFirstname,
                "lastname" => $contactLastname
            )  
        );
        $dataset = json_encode($dataset,true);
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token,                          
                'Content-Length: ' . strlen($dataset))
        );
        $curl = curl_init("https://moneybird.com/api/v2/{$this->administration}/contacts.json?");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataset);

        $result = json_decode(curl_exec($curl));
        return $result;
    }
    
    function editContact(string $contactMoneybirdId, string $contactCompany, string $contactFirstname, string $contactLastname) {
        $dataset = array (
            "contact" => array(
                "company_name" => $contactCompany,
                "firstname" => $contactFirstname,
                "lastname" => $contactLastname
            )  
        );
        $dataset = json_encode($dataset,true);
        $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s ', $this->token,                          
                'Content-Length: ' . strlen($dataset))
        );
        $curl = curl_init("https://moneybird.com/api/v2/{$this->administration}/contacts/{$contactMoneybirdId}.json?");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataset);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');

        $result = json_decode(curl_exec($curl));
        return $result;
    }
}