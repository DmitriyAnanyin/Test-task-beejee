<?php

namespace application\models;

use application\core\Model;

class MainModel extends Model {

    public $count; 
    public $sortName;
    public function getTasks($page, $sortBy, $perPage = 3) {

        $totalCountTask = $this->db->getFromDb('SELECT COUNT(*) FROM `tasks`');
        $totalCountTask = end($totalCountTask[0]);
        $totalPages = ceil($totalCountTask / $perPage);
        if ($page <= 1 || $page > $totalPages) {
            $page = 1;
        }

        $offset = ($perPage * $page) - $perPage;
        
        if (empty($sortBy)){
            $sortBy = 'uname_down';
        }

        $sortByArr = explode('_',  $sortBy);
        $sortName = $sortByArr[0];

        if ($sortByArr[1] == 'up') {
            $tasksArray = $this->db->getFromDb("SELECT * FROM `tasks` ORDER BY $sortName ASC LIMIT $offset,$perPage");
        } else {
            $tasksArray = $this->db->getFromDb("SELECT * FROM `tasks` ORDER BY $sortName DESC LIMIT $offset,$perPage");
        }

        return $result = [
            'count' => $totalCountTask,
            'tasks' => $tasksArray,
            'totalPages' => $totalPages,
        ];
    }

    public function putTask($uname, $email, $text, $status, $taskId) {
        if (!empty($status)) {
            $status = '1';
        } else {
            $status = '0';
        }
        $params = [
            'uname' => $uname,
            'email' => $email,
            'txt' => $text,
            'statusTask' => $status,
            'taskId' => (string)$taskId,
        ];
        $this->db->getFromDb('UPDATE `tasks` SET `uname` = :uname, `email` = :email, `text` = :txt, `status` = :statusTask WHERE `tasks`.`task_id` = :taskId', $params);
    }

    public function setTask($uname, $email, $text) {
        $params = [
            'uname' => $uname,
            'email' => $email,
            'txt' => $text,
        ];
        $this->db->getFromDb('INSERT INTO `tasks` (`uname`, `email`, `text`) VALUES (:uname, :email, :txt)', $params);
    }
}
?>