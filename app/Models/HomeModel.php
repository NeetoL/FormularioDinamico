<?php
class HomeModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getData() {
        $query = $this->db->query('SELECT * FROM usuarios');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
