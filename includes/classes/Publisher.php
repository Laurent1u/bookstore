<?php

class Publisher
{
    protected $_db,
        $_data;

    public function __construct()
    {
        $this->_db = Db::getInstance();
    }

    public function getPublisher(array $filter = [])
    {
        $where = empty($filter) ? ['id', '>=', '1'] : $filter;
        $data = $this->_db->get('publishers', $where);
        if ($data->count()) {
            $this->_data = $data->results();
            return $this->_data;
        }
        return false;
    }
}