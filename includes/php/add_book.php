<?php
$bookId = $requestParam->_int('book_id');
$result = null;
$getBookAuthor = null;

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
                if ($bookId) {
                    $response = $soapClient->__soapCall('update', array($bookArray, $bookId));
                    $bookAuthorArray = array();
                    foreach ($authorArrayIds as $author_id) {
                        $bookAuthorArray['book_id'] = $bookId;
                        $bookAuthorArray['author_id'] = $author_id;
                        $soapClient->__soapCall('create', array($bookAuthorArray, 'authors_books'));
                    }
                } else {
                    $response = $soapClient->__soapCall('create', array($bookArray));
                }
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
        break;
}

try {
    $params = ['id' => $bookId];

    if ($bookId) {
        $list = $soapClient->__soapCall('getBooks', array((object)$params));
        $getBookAuthor = explode(',', $list[0]->author_id);
        $getBookAuthor = array_combine($getBookAuthor, $getBookAuthor);
    }
    $authorList = $soapClient->__soapCall('getAuthors', array());
    $publisherList = $soapClient->__soapCall('getPublisher', array());
    //print_r($list);
} catch (Exception $e) {
    print_r($e->getMessage());
    print_r($soapClient->__getLastResponse());
}