<?php
require_once './application/models/BandMapper.php';
require_once './application/models/AuthChecker.php';
class Home{
    public function index(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Home - Band Manager";
        require "./application/views/templates/head.php";
        $bands = BandMapper::getBandsByUser($_SESSION[S_USER]);
        require "./application/views/home/home.php";
        require "./application/views/templates/footer.php";
    }
}