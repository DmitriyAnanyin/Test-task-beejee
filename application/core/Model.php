<?php

namespace application\core;

use application\db\DB;

abstract class Model {

    public $db;

    public function __construct() {
        $this->db = new DB;
    }
}
?>