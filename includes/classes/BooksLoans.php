<?php

class BooksLoans extends Books
{
    public function createLoan($fields, $table = 'book_loans')
    {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception('Imprumutul nu a putut fi realizat !');
        }
        return (object)array('last_insert_id' => Db::getLastInsertId(), 'message' => 'Cererea de imprumut a fost salvata cu succes !');
    }

    public function deleteLoan($fields)
    {
        if (!$this->_db->delete('book_loans', $fields)) {
            throw new Exception('Cartea imprumutata nu a putut fi stersa sau nu exista in lista !');
        }
        return (object)['message' => 'Cartea imprumutata a fost stersa din lista'];
    }

    public function updateLoan($fields = array(), $id = null)
    {
        if (is_int($id)) {
            if (!$this->_db->update('book_loans', $id, $fields)) {
                throw new Exception('Detaliile nu au putut fi modificate !');
            }
            return (object)['message' => 'Datele au fost actualizate !'];
        }
    }

    public function getBookLoans($filters = array())
    {
        $sql = "select bl.*, b.name as book_name, p.name as publisher, a.name as authors_name, "
            . " b.appearance_date, b.page_number, b.bar_code"
            . " from book_loans bl"
            . " inner join books b on b.id = bl.book_id"
            . " inner join publishers p on p.id = b.publisher_id"
            . " inner join authors_books ab on ab.book_id = bl.book_id"
            . " inner join author a on a.id = ab.author_id"
            . " where 1"
            . ($filters->author ? " and a.id = '" . $filters->author . "'" : '')
            . ($filters->id ? " and bl.id = '" . $filters->id . "'" : '')
            . ($filters->book_id ? " and b.id = '" . $filters->book_id . "'" : '')
            . ($filters->loanExceeded === true ? " and bl.return_date <= CURDATE()" : '')
            . ($filters->loanExceeded === false ? " and bl.return_date >= CURDATE()" : '')
            . " group by bl.id order by bl.return_date asc";

        $data = $this->_db->query($sql);
        if ($data->count()) {
            $this->_data = $data->results();
            return $this->_data;
        }
        return [];
    }
}