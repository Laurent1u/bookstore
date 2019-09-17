<?php
include '../../config.php';

class Books
{
    private $_db,
        $_data;

    public function __construct()
    {
        $this->_db = Db::getInstance();
    }

    public function create($fields, $table = 'books')
    {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception('Cartea nu a fost introdusa !');
        }
        return (object)array('last_insert_id' => Db::getLastInsertId(), 'message' => 'Cartea a fost adaugata in biblioteca !');
    }

    public function delete($fields)
    {
        if (!$this->_db->delete('books', $fields)) {
            throw new Exception('Cartea nu a putut fi stersa sau nu exista !');
        }
        return (object)['message' => 'Cartea a fost sters'];
    }

    public function update($fields = array(), $id = null)
    {
        if (is_int($id)) {
            if (!$this->_db->update('books', $id, $fields)) {
                throw new Exception('Cartea nu a putut fi modificat !');
            }
            $this->_db->delete('authors_books', array('book_id', '=', $id));
            return (object)['message' => 'Cartea a fost modificata !'];
        }
    }

    public function getAuthors()
    {
        $data = $this->_db->get('author', array('id', '>=', '1'));
        if ($data->count()) {
            return $data->results();
        }
        return false;
    }

    public function getBooks($filters = array())
    {
        $sql = "select b.*, group_concat(a.name separator ' / ') as authors_name, group_concat(a.id) as author_id,
                p.name as publisher"
                . " from books b"
                . " inner join authors_books ab on ab.book_id = b.id"
                . " inner join author a on a.id = ab.author_id"
                . " inner join publishers p on p.id = b.publisher_id"
                . " where 1"
                . ($filters->author ? " and a.id = '" . $filters->author . "'" : '')
                . ($filters->publisher ? " and p.id = '" . $filters->publisher . "'" : '')
                . ($filters->dateStart ? " and b.appearance_date >= '" . $filters->dateStart . "'" : '')
                . ($filters->dateEnd ? " and b.appearance_date <= '" . $filters->dateEnd . "'" : '')
                . ($filters->id ? " and b.id = '" . $filters->id . "'" : '')
                . " group by b.id";
        //print_r($sql);
        //die;
        $data = $this->_db->query($sql);
        if ($data->count()) {
            $this->_data = $data->results();
            return $this->_data;
        }
        return false;
    }

    public function getPublisher()
    {
        $data = $this->_db->get('publishers', array('id', '>=', '1'));
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

$params = ['uri' => 'http://localhost/bookstore/includes/classes/Books.php'];
$server = new SoapServer(null, $params);
$server->setClass('Books');
$server->addSoapHeader();
$server->handle();