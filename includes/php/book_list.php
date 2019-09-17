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

$bookId = $requestParam->_int('book_id');
$authorParam = $requestParam->_get('author');
$publisherParam = $requestParam->_get('publisher');
$dateStart = $requestParam->_get('date_start');
$dateEnd = $requestParam->_get('date_end');

switch ($doAction) {
    case 'delete':
        if (is_int($bookId)) {
            try {
                $result = $soapClient->__soapCall('delete', array(array('id', '=', $bookId)));
            } catch (Exception $e) {
                print_r($e->getMessage());
                echo '<pre>';
                print_r($soapClient->__getLastResponse());
            }
        }
        break;
}

try {
    $bookFilters = array(
        'author' => $authorParam,
        'publisher' => $publisherParam,
        'dateStart' => $dateStart,
        'dateEnd' => $dateEnd
    );

    $results = $soapClient->__soapCall('getBooks', array((object)$bookFilters));
    $authorsList = $soapClient->__soapCall('getAuthors', array());
    $publishersList = $soapClient->__soapCall('getPublisher', array());
    //echo '<pre>';
    //print_r($authorsList);
} catch (Exception $e) {
    print_r($e->getMessage());
    print_r($soapClient->__getLastResponse());
}