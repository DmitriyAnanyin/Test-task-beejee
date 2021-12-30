<?php

namespace application\models;

use application\core\Model;

class AccountModel extends Model {

    public function login($uname, $password) {

        return $this->db->getFromDb("SELECT login, is_admin FROM users WHERE login = '$uname' AND password = '$password'");
        
    }
    public function checkUser($uname, $password) {

        return $this->db->getFromDb("SELECT COUNT(*) FROM users WHERE login = '$uname' AND password = '$password'");
        
    }
}
?>