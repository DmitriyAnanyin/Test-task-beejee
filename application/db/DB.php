<?php

namespace application\db;

use PDO;

class DB {

    public $db;

    public function __construct () {
        $this->db = new PDO('mysql:host=localhost;dbname=beejee_test', 'root', '' );
    }

    public function getFromDb ($query, $params = []) {
        $statment = $this->db->prepare($query);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $statment->bindValue(':'.$key, $val);
            }
        }
        $statment->execute();
        return $statment->fetchAll(PDO::FETCH_ASSOC);
    }
}