<?php

class Books extends Author
{
    public function createBook($fields, $table = 'books')
    {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception('Cartea nu a fost introdusa !');
        }
        return (object)array('last_insert_id' => Db::getLastInsertId(), 'message' => 'Cartea a fost adaugata in biblioteca !');
    }

    public function deleteBook($fields)
    {
        if (!$this->_db->delete('books', $fields)) {
            throw new Exception('Cartea nu a putut fi stersa sau nu exista !');
        }
        return (object)['message' => 'Cartea a fost sters'];
    }

    public function updateBook($fields = array(), $id = null)
    {
        if (is_int($id)) {
            if (!$this->_db->update('books', $id, $fields)) {
                throw new Exception('Cartea nu a putut fi modificat !');
            }
            return (object)['message' => 'Cartea a fost modificata !'];
        }
    }

    public function getBooks($filters = array())
    {
        $sql = "select b.*, b.name as book_name, group_concat(a.name separator ' / ') as authors_name, group_concat(a.id) as author_id,
                p.name as publisher"
                . " from books b"
                . " inner join authors_books ab on ab.book_id = b.id"
                . " inner join author a on a.id = ab.author_id"
                . " inner join publishers p on p.id = b.publisher_id"
                . " where 1"
                . ($filters->author ? " and a.id = '" . $filters->author . "'" : '')
                . ($filters->publisher ? " and p.id = '" . $filters->publisher . "'" : '')
                . ($filters->publishers ? " and p.id in ('" . $filters->publishers . "')" : '')
                . ($filters->dateStart ? " and b.appearance_date >= '" . $filters->dateStart . "'" : '')
                . ($filters->dateEnd ? " and b.appearance_date <= '" . $filters->dateEnd . "'" : '')
                . ($filters->id ? " and b.id = '" . $filters->id . "'" : '')
                . ($filters->loan === true ? " and b.is_loan = '1'" : '')
                . ($filters->loan === false ? " and b.is_loan = '0'" : '')
                . " group by b.id";

        $data = $this->_db->query($sql);
        if ($data->count()) {
            $this->_data = $data->results();
            return $this->_data;
        }
        return [];
    }
}