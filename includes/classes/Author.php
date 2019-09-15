<?php
include '../../config.php';

class Author
{
    private $_db,
            $_data;

    public function __construct()
    {
        $this->_db = Db::getInstance();
    }

    public function create($fields)
    {
        if (!$this->_db->insert('author', $fields)) {
            throw new Exception('Autorul nu a fost introdus !');
        }
        return 'Autorul a fost adaugat cu succes !';
    }

    public function delete($fields)
    {
        if (!$this->_db->delete('author', $fields)) {
            throw new Exception('Autorul nu a putut fi sters sau nu exista !');
        }
        return 'Autorul a fost sters';
    }

    public function update($fields = array(), $id = null)
    {
        if (is_int($id)) {
            if (!$this->_db->update('author', $id, $fields)) {
                throw new Exception('Autorul nu a putut fi modificat !');
            }
            return 'Autorul a fost modificat !';
        }
    }

    public function getAuthor($authorId)
    {
        $data = $this->_db->get('author', array('id', '=', $authorId));
        if ($data->count()) {
            return $data->first();
        }
        return false;
    }

    public function getAuthors()
    {
        $data = $this->_db->get('author', array('id', '>=', '1'));
        if ($data->count()) {
            $this->_data = $data->results();
            return $this->_data;
        }
        return false;
    }

    public function soapLogin($headerParamas = null)
    {
        if ($headerParamas->username == SOAP_USERNAME && $headerParamas->password == SOAP_PASSWORD) {
            return true;
        }
        throw new SoapFault('Wrong username/password ', 401);
    }
}

$params = ['uri' => 'http://localhost/bookstore/includes/classes/Author.php'];
$server = new SoapServer(null, $params);
$server->setClass('Author');
$server->addSoapHeader();
$server->handle();