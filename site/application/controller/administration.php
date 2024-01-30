<?php
require_once './application/models/AuthChecker.php';
require_once './application/models/User.php';
require_once './application/models/Song.php';
require_once './application/models/Band.php';
require_once './application/models/UserMapper.php';
require_once './application/models/BandMapper.php';
require_once './application/models/SongMapper.php';
class administration
{
    public function index($msg = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            $users = UserMapper::getAll();
            $bands = BandMapper::getAll();
            $songs = SongMapper::getAllMapped();
            require './application/views/templates/head.php';
            require './application/views/admin/admin.php';
            require './application/views/templates/footer.php';
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function delete($what, $id = -1){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1 && $id != -1){
            switch($what){
                case DELETE_BAND:
                    BandMapper::delete($id);
                    break;
                case DELETE_USER:
                    UserMapper::delete($id);
                    break;
                case DELETE_SONG:
                    SongMapper::delete($id);
                    break;
                default:
                    break;
            }
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function add($what, $error = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            switch($what){
                case ADD_USER:
                    require './application/views/templates/head.php';
                    require './application/views/admin/add_user.php';
                    require './application/views/templates/footer.php';
                    break;
                case ADD_BAND:
                    require './application/views/templates/head.php';
                    require './application/views/admin/add_band.php';
                    require './application/views/templates/footer.php';
                    break;
                default:
                    break;
            }
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function addband(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            $band = new Band(-1, DataCleaner::cleanSpecialChars($_POST['bandName']));
            BandMapper::add($band);
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function addUserToBand(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            $user = UserMapper::getById($_POST['userId']);
            $band = BandMapper::getById($_POST['bandId']);
            if($user == null || $band == null){
                header('location: ' . URL . 'administration/index/err_select_band');
                return;
            }
            BandUserMapper::addUserToBand($user, $band);
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function removeUserFromBand($userId = "", $bandId = "")
    {
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            if($userId == "" || $bandId == ""){
                header('location: ' . URL . 'administration/index/err_invalid_band_or_user');
                return;
            }
            $user = UserMapper::getById($userId);
            $band = BandMapper::getById($bandId);
            if($user == null || $band == null){
                header('location: ' . URL . 'administration/index/err_invalid_band_or_user');
            }
            BandUserMapper::removeUserFromBand($user, $band);
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function userBands($userId){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            $user = UserMapper::getById($userId);
            if($user == null){
                header('location: ' . URL . 'administration');
                return;
            }
            $bands = BandMapper::getBandsByUser($user);
            require './application/views/templates/head.php';
            require './application/views/admin/user_bands.php';
            require './application/views/templates/footer.php';
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function adduser(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Admin area - Band Manager";
        if($_SESSION[S_USER]->getIsAdmin() == 1){
            $user = new User(
                -1,
                DataCleaner::cleanHtmlSpecial($_POST['userName']),
                DataCleaner::cleanHtmlSpecial($_POST['userSurname']),
                DataCleaner::cleanEmail($_POST['userEmail']),
                DataCleaner::cleanSpecialChars($_POST['userIsAdmin'])
            );
            UserMapper::addNewUser($user);
        }else{
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }
}