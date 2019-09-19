<?php

class Author extends Publisher
{
    public function createAuthor($fields)
    {
        if (!$this->_db->insert('author', $fields)) {
            throw new Exception('Autorul nu a fost introdus !');
        }
        return 'Autorul a fost adaugat cu succes !';
    }

    public function deleteAuthor($fields)
    {
        if (!$this->_db->delete('author', $fields)) {
            throw new Exception('Autorul nu a putut fi sters sau nu exista !');
        }
        return 'Autorul a fost sters';
    }

    public function updateAuthor($fields = array(), $id = null)
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

    public function deleteAuthorsBooks($id) {
        $this->_db->delete('authors_books', array('book_id', '=', $id));
    }
}