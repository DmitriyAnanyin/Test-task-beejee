<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {
    public $error; 
    public $success; 
    public $tasksArray = [];

    public function indexAction () {
        if (isset($_POST['logOut'])) {
            $_SESSION['loggedUser'] = [];
        }

        if (isset($_POST['taskForm'])) {
            $this->validateTask($_POST);
        }

        if (isset($_POST['page'])) {
            $_SESSION['page'] = (int) $_POST['page'];
        }

        if (!empty($_POST['sortSelect'])){
            $_SESSION['sortSelect'] = $_POST['sortSelect'];
        }
        
        if (isset($_POST['putTask'])){
            if ($_SESSION['loggedUser'][0]['is_admin'] == 1){
                $this->model->putTask($_POST['uname'],$_POST['email'],$_POST['text'],$_POST['status'],$_POST['taskId']);
            } else {
                $this->error = 'To change tasks, you need to sign in';
            }
        }

        $this->tasksArray = $this->model->getTasks($_SESSION['page'], $_SESSION['sortSelect']);
        
        if (isset($_POST['setTaskToForm'])) {
            $_SESSION['taskId'] = (int)$_POST['taskId'];
            $putTaskArray = $this->setTaskToForm($this->tasksArray['tasks']);
        }

        require $sortArray = 'application/config/sortArray.php';

        $vars = [
            'tasks' => $this->tasksArray['tasks'],
            'count' => $this->tasksArray['count'],
            'totalPages' => $this->tasksArray['totalPages'],
            'error' => $this->error,
            'success' => $this->success,
            'sortArray' => $sortArray,
            'putTaskArray' => $putTaskArray,
        ];

        $this->view->render('Start page', $vars);
    }

    public function validateTask($post) {
        if ($post['uname'] == '') {

            $this->error = 'Username is undefined';

        } else if ($post['email'] == '') {

            $this->error = 'Email is undefined';

        } else if ($post['text'] == '') {

            $this->error = 'Text is undefined';

        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {

            $this->error = 'Email is not valid';

        } else {
            $this->success = 'Done';
            $this->model->setTask($post['uname'], $post['email'], $post['text']);

        }
    }
    public function setTaskToForm( $tasksArray) {
        $taskId = $_SESSION['taskId'];
        
        foreach ($tasksArray as $task) {
            if ($task['task_id'] == $taskId) {
                
                return $task;
                
            }
        }
    }
}
?>