<?php
include '../../config.php';

class ServerSoap extends BooksLoans
{
    public function soapLogin($headerParamas = null)
    {
        if ($headerParamas->username == SOAP_USERNAME && $headerParamas->password == SOAP_PASSWORD) {
            return true;
        }
        throw new SoapFault('Wrong username/password ', 401);
    }
}

$params = ['uri' => 'http://localhost/bookstore/includes/classes/ServerSoap.php'];
$server = new SoapServer(null, $params);
$server->setClass('ServerSoap');
$server->addSoapHeader();
$server->handle();