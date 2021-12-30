<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

    public $errors = [];
    public $user = [];

    public function loginAction () {
        $this->errors = [];
        if (isset($_POST['signIn'])) {
            $this->validateInputDate($_POST);
            if (empty($this->errors)) {
                $this->user = $this->model->login($_POST['uname'], $_POST['password']);
                if (empty($this->user)){
                    array_push($this->errors, 'Name or password is not valid');
                } else {
                    $_SESSION['loggedUser'] = $this->user;
                    $this->view->redirect('/');
                }
            }
        }
        $this->view->render('Authorization', $this->errors);
    }

    public function validateInputDate($post) {
        if ($post['uname'] == '' || $post['password'] == '') {
            array_push($this->errors, 'Data is incorrect');
        }
    }
}
?>