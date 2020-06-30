<?php

//url aquispe
define('URL_SITIO', 'http://localhost/PROYECTO%20GDLWEBCAMP/');

require 'paypal/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        '', //Cliente ID a rellenar
        '' //SECRET a rellenar
    )
);
