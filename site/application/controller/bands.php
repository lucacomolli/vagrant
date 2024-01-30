<?php
require_once './application/models/AuthChecker.php';
require_once './application/models/Band.php';
require_once './application/models/User.php';
require_once './application/models/UserMapper.php';
require_once './application/models/BandMapper.php';
require_once './application/models/BandUser.php';
require_once './application/models/BandUserMapper.php';
require_once './application/models/Song.php';
require_once './application/models/SongMapper.php';
class Bands
{
    public function index()
    {
        header('location: ' . URL);
    }

    public function view($bandId = -1)
    {
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $band = BandMapper::getById($bandId);
        $usersBands = BandMapper::getBandsByUser($_SESSION[S_USER]);
        if(in_array($band, $usersBands)){
            $html_title = $band->getName() . " - BandManager";
            $members = BandMapper::getMembers($band);
            $songs = SongMapper::getAllMapped()[$bandId];
            require "./application/views/templates/head.php";
            require "./application/views/band/view.php";
        }else{
            $html_title = "View band - BandManager";
            require "./application/views/templates/head.php";
            require "./application/views/errors/error403.php";
        }
        require "./application/views/templates/footer.php";
    }
}