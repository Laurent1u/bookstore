<?php
$result = null;

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

switch ($doAction) {
    case 'save':
        $bookName = $requestParam->_post('book_name');
        $authorArrayIds = $requestParam->_post('author_id');
        $publisher = $requestParam->_post('publisher');
        $appearanceDate = $requestParam->_post('appearance_date');
        $pageNumber = $requestParam->_int('page_number');
        $barCode = $requestParam->_int('bar_code');
        $price = $requestParam->_double('price', '0.00');
        $description = $requestParam->_post('description');

        $bookArray = array(
            'name' => $bookName,
            'publisher_id' => $publisher,
            'appearance_date' => $appearanceDate,
            'page_number' => $pageNumber,
            'bar_code' => $barCode,
            'price' => $price,
            'description' => $description
        );

        if (!empty($bookName) && !empty($appearanceDate) && !empty($price)) {
            try {
                $response = $soapClient->__soapCall('create', array($bookArray));
                $result = $response->message;

                if ($response->last_insert_id) {
                    $bookAuthorArray = array();
                    foreach ($authorArrayIds as $author_id) {
                        $bookAuthorArray['book_id'] = $response->last_insert_id;
                        $bookAuthorArray['author_id'] = $author_id;
                        $soapClient->__soapCall('create', array($bookAuthorArray, 'authors_books'));
                    }
                }

            } catch (Exception $e) {
                print_r($soapClient->__getLastResponse());
            }
        }

        /*echo '<pre>';
        print_r($authorArrayIds);
        print_r($bookArray);

        die();*/
        break;
}

try {
    $list = $soapClient->__soapCall('getBooks', array());
    $authorList = $soapClient->__soapCall('getAuthors', array());
    $publisherList = $soapClient->__soapCall('getPublisher', array());
    //print_r($list);
} catch (Exception $e) {
    print_r($e->getMessage());
    print_r($soapClient->__getLastResponse());
}