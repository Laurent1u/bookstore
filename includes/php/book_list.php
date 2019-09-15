<?php
$params = array(
    'location' => 'http://localhost/bookstore/includes/classes/Books.php',
    'uri' => 'urn://localhost/bookstore/includes/classes/Books.php',
    'trace' => 1
);
$authParam = ['username' => SOAP_USERNAME, 'password' => SOAP_PASSWORD];
$soapVar = new SoapVar($authParam, SOAP_ENC_OBJECT);
$soapHeader = new SoapHeader('bookstore', 'soapLogin', $soapVar, false);
$soapClient = new SoapClient(null, $params);
$soapClient->__setSoapHeaders([$soapHeader]);

try {
    $results = $soapClient->__soapCall('getBooks', array());
    //echo '<pre>';
    //print_r($results);
} catch (Exception $e) {
    print_r($e->getMessage());
}