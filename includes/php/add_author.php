<?php
$authorId = $requestParam->_int('author_id');
$result = null;
$edit = new stdClass();

switch ($doAction) {
    case 'save':
        $authorName = $requestParam->_post('author_name');

        if ($authorName) {
            $authorArray = ['name' => $authorName];
            try {
                if ($authorId) {
                    $result = $soapClient->__soapCall('updateAuthor', array($authorArray, $authorId));
                } else {
                    $result = $soapClient->__soapCall('createAuthor', array($authorArray));
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
                $result = $soapClient->__soapCall('deleteAuthor', array(array('id', '=', $authorId)));
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
    var_dump($soapClient->__getFunctions());
    echo '<pre>';
    print_r($soapClient->__getLastRequest());
}


