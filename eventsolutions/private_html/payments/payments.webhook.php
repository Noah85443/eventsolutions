<?php
require_once '../core/system.init.php';

if(!empty(filter_input(INPUT_GET, 'id', FILTER_DEFAULT))) {
    $transactieId = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
    $mollie = new mollie();
    $dataset = $mollie->getPaymentInfo($transactieId);
    
    $paymentStatus = $dataset->status;
    
    switch($paymentStatus) {
        case 'canceled':
            sendMail::sendit("axel@eventsolutions.nu", "Betaling geannuleerd", "Betaling van factuur ".$dataset->metadata->factuurNr." is geannuleerd");
            break;
        case 'expired':
            sendMail::sendit("axel@eventsolutions.nu", "Betaling verlopen", "Betaling van factuur ".$dataset->metadata->factuurNr." is verlopen");
            break;
        case 'failed':
            sendMail::sendit("axel@eventsolutions.nu", "Betaling mislukt", "Betaling van factuur ".$dataset->metadata->factuurNr." is mislukt");
            break;
        case 'paid':
            $factuurNr = $dataset->metadata->factuurNr;
            facturatie::updateStatus($factuurNr, 8);
            $moneybird = new moneybird();
            $mbAction = $moneybird->createInvoicePayment($factuurNr, $dataset->paidAt, $dataset->amount->value);
            sendMail::sendit("axel@eventsolutions.nu", "Betaling voltooid", "Betaling van factuur ".$dataset->metadata->factuurNr." is succesvol afgerond en verwerkt in het systeem.");
            break;
        default:
            /* Do nothing for now */
            break;
    }
}