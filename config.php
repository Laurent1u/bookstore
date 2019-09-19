<?php
define('HTTP_SERVER', 'http://localhost/bookstore/');
define('DATABASE_NAME', 'bookstore');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', 'root');
define('SOAP_USERNAME', 'root');
define('SOAP_PASSWORD', 'password');

define('DIR_INCLUDES', 'includes/');
define('DIR_CSS', DIR_INCLUDES . 'css/');
define('DIR_JS', DIR_INCLUDES . 'js/');
define('DIR_JQUERY', DIR_INCLUDES . 'jquery/');
define('DIR_IMAGES', 'images/');

//define path addresses
define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/bookstore/');
define('PATH_INCLUDES', PATH_ROOT . 'includes/');
define('PATH_HTML', PATH_INCLUDES . 'html/');
define('PATH_PHP', PATH_INCLUDES . 'php/');
define('PATH_FUNCTIONS', PATH_INCLUDES . 'functions/');
define('PATH_CLASSES', PATH_INCLUDES . 'classes/');


require_once PATH_FUNCTIONS . 'general.php';

spl_autoload_register(function ($class) {
    $fileAddress = PATH_CLASSES . $class . '.php';
    if (is_file($fileAddress)) {
        include_once $fileAddress;
    }
});

$params = array(
    'location' => 'http://localhost/bookstore/includes/classes/ServerSoap.php',
    'uri' => 'urn://localhost/bookstore/includes/classes/ServerSoap.php',
    'trace' => 1
);

$authParam = ['username' => SOAP_USERNAME, 'password' => SOAP_PASSWORD];
$soapVar = new SoapVar($authParam, SOAP_ENC_OBJECT);
$soapHeader = new SoapHeader('bookstore', 'soapLogin', $soapVar, false);
$soapClient = new SoapClient(null, $params);
$soapClient->__setSoapHeaders([$soapHeader]);

$requestParam = new Request();
$page = $requestParam->_request('p');
$doAction = $requestParam->_request('doAction');

