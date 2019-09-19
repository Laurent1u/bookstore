<?php
$name = $requestParam->_post('name');
$surname = $requestParam->_post('surname');
$loanDays = $requestParam->_int('loan_days', 1);
$bookId = $requestParam->_int('book_id');
$loanBookId = $requestParam->_int('loan_book_id');
$loanPublisherId = $requestParam->_int('loan_publisher_id');
$loanId = $requestParam->_int('loan_id');

switch ($doAction) {
    case 'save':
        $loanArray = array(
            'name' => $name,
            'surname' => $surname,
            'days_loan' => $loanDays,
            'return_date' => date('Y-m-d', strtotime($loanDays . 'days'))
        );

        if ($loanId) {
            $soapClient->__soapCall('updateLoan', array($loanArray, $loanId));
        } else {
            $loanArray['book_id'] = $bookId ?: $loanBookId;
            $soapClient->__soapCall('createLoan', array($loanArray));

            $bookArray = array('is_loan' => 1);
            $response = $soapClient->__soapCall('updateBook', array($bookArray, $loanArray['book_id']));
        }
        break;
    case 'delete':
        if (!empty($loanId)) {
            $result = $soapClient->__soapCall('deleteLoan', array(array('id', '=', $loanId)));

            $bookArray = array('is_loan' => 0);
            $soapClient->__soapCall('updateBook', array($bookArray, $loanArray['book_id']));
        }
        break;
}

$takenBooks = [];
try {
    $takenBooks = $soapClient->__soapCall('getBooks', array((object)['loan' => true]));

    $whereBooksList = $loanPublisherId ? ['publishers' => $loanPublisherId] : ($bookId ? ['id' => $bookId] : []);
    $booksList = $soapClient->__soapCall('getBooks', array((object)$whereBooksList));

    $key = array_search($loanBookId, array_column($booksList ?: [], 'id'));
    $wherePublisher = $loanBookId ? ['id', '=', $booksList[$key]->publisher_id] : [];
    $publisherList = $soapClient->__soapCall('getPublisher', array($wherePublisher));
    //var_dump($booksList, $_REQUEST);
    $bookLoansList = $soapClient->__soapCall('getBookLoans', array());
    if ($loanId) {
        $booksList = $soapClient->__soapCall('getBookLoans', array((object)['id' => $loanId]));
    }
} catch (Exception $e) {
    print_r($e->getMessage());
    print_r($soapClient->__getLastResponse());
}