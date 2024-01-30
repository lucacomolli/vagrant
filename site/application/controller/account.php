<?php
require_once './application/models/UserMapper.php';
require_once './application/models/AuthChecker.php';
class account
{
    public function index(){
        header('location: ' . URL);
    }

    public function login($error_code = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        if($_SESSION[S_IS_LOGGED] ?? 0 == 1)
            header('location: ' . URL);
        $html_title = "Login - Band Manager";
        require "./application/views/templates/head.php";
        require "./application/views/login/login.php";
        require "./application/views/templates/footer.php";
    }

    public function auth($param = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();

        if($param == "newpass"){
            UserMapper::changeNewUserPassword($_SESSION[S_USER], $_POST['password']);
        }else{
            if(UserMapper::login($_POST['username'], $_POST['password'])){
                if($_SESSION[S_CHNGPW]){
                    header('Location: ' . URL . "account/changepass");
                }else{
                    header('Location: ' . URL . "home");
                }
            }else{
                header('location: ' . URL . "account/login/err_creds");
            }
        }
    }

    public function logout(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        session_destroy();
        unset($_SESSION);
        unset($_COOKIE);
        header('location: ' . URL);
    }

    public function changepass(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        if($_SESSION[S_CHNGPW]){
            require "./application/views/templates/head.php";
            require "./application/views/login/change_password.php";
            require "./application/views/templates/footer.php";
        }else{
            header('location: ' . URL);
        }
    }
}