<?php
$authorId = $requestParam->_int('author_id');
$result = null;
$edit = new stdClass();

$params = array(
    'location' => 'http://localhost/bookstore/includes/classes/Author.php',
    'uri' => 'urn://localhost/bookstore/includes/classes/Author.php',
    'trace' => 1
);
$authParam = ['username' => SOAP_USERNAME, 'password' => SOAP_PASSWORD];
$soapVar = new SoapVar($authParam, SOAP_ENC_OBJECT);
$soapHeader = new SoapHeader('bookstore', 'soapLogin', $soapVar, false);
$soapClient = new SoapClient(null, $params);
$soapClient->__setSoapHeaders([$soapHeader]);

switch ($doAction) {
    case 'save':
        $authorName = $requestParam->_post('author_name');

        if ($authorName) {
            $authorArray = ['name' => $authorName];

            try {
                if ($authorId) {
                    $result = $soapClient->__soapCall('update', array($authorArray, $authorId));
                } else {
                    $result = $soapClient->__soapCall('create', array($authorArray));
                }
            } catch (Exception $e) {
                print_r($e->getMessage());
                echo '<pre>';
                print_r($soapClient->__getLastResponse());
            }
        }
        break;
    case 'delete':
        if (is_int($authorId)) {
            try {
                $result = $soapClient->__soapCall('delete', array(array('id', '=', $authorId)));
            } catch (Exception $e) {
                print_r($e->getMessage());
                echo '<pre>';
                print_r($soapClient->__getLastResponse());
            }
        }
        break;
    case 'edit':
        if(is_int($authorId)) {
            try {
                $edit = $soapClient->__soapCall('getAuthor', array($authorId));
            } catch (Exception $e) {
                print_r($soapClient->__getLastResponse());
            }
        }
        break;
}

try {
    $list = $soapClient->__soapCall('getAuthors', array());
} catch (Exception $e) {
    print_r($e->getMessage());
}


