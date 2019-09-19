<?php

class Clients
{
    private $_db,
            $_data;

    public function __construct()
    {
        $this->_db = Db::getInstance();
    }

    public function createClient($fields, $table = 'clients')
    {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception('Persoana nu a fost adaugata !');
        }
        return (object)array('last_insert_id' => Db::getLastInsertId(), 'message' => 'Persoana a fost adaugata !');
    }

    public function updateClient($fields = array(), $id = null)
    {
        if (is_int($id)) {
            if (!$this->_db->update('clients', $id, $fields)) {
                throw new Exception('Nu am putut modifica clientul !');
            }
            return (object)['message' => 'Datele au fost actualizate !'];
        }
    }

    public function deleteClient($fields)
    {
        if (!$this->_db->delete('clients', $fields)) {
            throw new Exception('s-a produs o eroare la stergerea clientului !');
        }
        return (object)['message' => 'Clientul a fost sters !'];
    }
}