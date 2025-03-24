<?php
require_once __DIR__ . '/getapikey.php';

function generateTransactionId() {


    
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 10)), 0, 15);
}

function calculateControlValue($api_key, $transaction, $montant, $vendeur, $status) {




    return md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");
}

function verifyReturnControl($api_key, $transaction, $montant, $vendeur, $status) {



    return calculateControlValue($api_key, $transaction, $montant, $vendeur, $status);


}
