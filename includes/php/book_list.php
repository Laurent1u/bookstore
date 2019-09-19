<?php
$bookId = $requestParam->_int('book_id');
$authorParam = $requestParam->_get('author');
$publisherParam = $requestParam->_get('publisher');
$dateStart = $requestParam->_get('date_start');
$dateEnd = $requestParam->_get('date_end');
$loan = $requestParam->_bool('loan');

switch ($doAction) {
    case 'delete':
        if (is_int($bookId)) {
            try {
                $result = $soapClient->__soapCall('deleteBook', array(array('id', '=', $bookId)));
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
        'dateEnd' => $dateEnd,
        'loan' => $loan
    );

    $results = $soapClient->__soapCall('getBooks', array((object)$bookFilters));
    $authorsList = $soapClient->__soapCall('getAuthors', array());
    $publishersList = $soapClient->__soapCall('getPublisher', array());
} catch (Exception $e) {
    print_r($e->getMessage());
    print_r($soapClient->__getLastResponse());
}