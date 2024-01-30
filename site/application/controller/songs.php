<?php
require_once './application/models/AuthChecker.php';
require_once './application/models/SongMapper.php';
require_once './application/models/BandMapper.php';
require_once './application/models/BandUserMapper.php';
require_once './application/models/Song.php';
require_once './application/models/FileUtils.php';
class songs
{
    public function index($msg = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Your songs - Band Manager";
        $filter = $_GET['song'] ?? "";
        $songs = SongMapper::getUserSongs($_SESSION[S_USER]);
        if($filter != ""){
            $songs = $this->filterSearch($songs, $filter);
        }
        require './application/views/templates/head.php';
        require './application/views/songs/index.php';
        require './application/views/templates/footer.php';
    }

    public function view($songId = 1){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $song = SongMapper::getSongById($songId);
        if(SongMapper::checkSongBand($song)){
            $html_title = "View Song - Band Manager";
            require './application/views/templates/head.php';
            require './application/views/songs/view.php';
            require './application/views/templates/footer.php';
        }else{
            $html_title = "View Song - Band Manager";
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function text($songId = 1, $action = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $song = SongMapper::getSongById($songId);
        if(SongMapper::checkSongBand($song)){
            $band = BandMapper::getBandNameById($song->getBandId());
            $html_title = "{$song->getTitle()} | {$song->getAuthor()} - Band Manager";
            require './application/views/templates/head.php';
            require './application/views/songs/text.php';
            require './application/views/templates/footer.php';
        }else{
            $html_title = "View Song - Band Manager";
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function video($songId){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $songs = SongMapper::getUserSongs($_SESSION[S_USER]);
        $song = SongMapper::getSongById($songId);
        $html_title = "{$song->getTitle()} | {$song->getAuthor()} - Band Manager";
        if(in_array($song, $songs)){
            require './application/views/templates/head.php';
            require './application/views/songs/video.php';
            require './application/views/templates/footer.php';
        }else{
            $html_title = "View Song - Band Manager";
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }
    }

    public function listen($songId){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $songs = SongMapper::getUserSongs($_SESSION[S_USER]);
        $song = SongMapper::getSongById($songId);
        $html_title = "{$song->getTitle()} | {$song->getAuthor()} - Band Manager";
        if(in_array($song, $songs)){
            require './application/views/templates/head.php';
            require './application/views/songs/audioplayer.php';
            require './application/views/templates/footer.php';
        }else{
            $html_title = "View Song - Band Manager";
            require './application/views/templates/head.php';
            require './application/views/errors/error403.php';
            require './application/views/templates/footer.php';
        }

    }

    public function coverimage($songId){
        echo SongMapper::getSongCover($songId);
    }

    public function addsong($error = ""){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $html_title = "Add a song - Band Manager";
        $bands = BandMapper::getBandsByUser($_SESSION[S_USER]);
        require './application/views/templates/head.php';
        require './application/views/new_song/add_song.php';
        require './application/views/templates/footer.php';
    }

    public function uploadSong(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $songTitle = $_POST['songName'];
        $songText = $_POST['songText'];
        $songGenre = $_POST['songGenre'];
        $songBandid = $_POST['songBand'];
        $songYear = $_POST['songYear'];
        $songAlbum = $_POST['songAlbum'];
        $songDesc = $_POST['songDesc'];
        $songBpm = $_POST['songBpm'];
        $songInstruments = $_POST['songInstruments'];

        //check inputs
        if(empty($songGenre) ||empty($songText) || empty($songTitle) || empty($songBandid) || empty($songAlbum) || empty($songDesc) || empty($songInstruments)) {
            header('location: ' . URL . 'songs/addSong/err_fillall');
        } else if(!is_numeric($songYear) || !is_numeric($songBpm)) {
            header('location: ' . URL . 'songs/addSong/err_numericfields');
        } else {
            $bandName = BandMapper::getBandNameById($songBandid);
            if($bandName != -1){
                //Check and upload files
                if(empty($_FILES['songAudio']['name'])){
                    header('location: ' . URL . 'songs/index/err_audiomissing');
                }
                if(empty($_FILES['songVideo']['name'])){
                    header('location: ' . URL . 'songs/index/err_videomissing');
                }
                if(empty($_FILES['songArtwork']['name'])){
                    header('location: ' . URL . 'songs/index/err_artworkmissing');
                }
                $audioPath = FileUtils::uploadFile($_FILES['songAudio']);
                $artworkPath = FileUtils::uploadFile($_FILES['songArtwork']);
                $videoPath = FileUtils::uploadFile($_FILES['songVideo']);

                if($audioPath == null || $artworkPath == null || $videoPath == null){
                    header('location: ' . URL . 'songs/addSong/err_mediamismatch');
                    return;
                }

                $song = new Song(
                    -1, $songTitle, $bandName, $songYear, $songDesc,
                    $audioPath, $videoPath,$artworkPath ,$songAlbum, $songText, $songBpm,
                    $songGenre, "", $songInstruments, "", $songBandid
                );
                SongMapper::insertNewSong($song);
            }

        }

    }
    public function saveNotes($songId){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        AuthChecker::checkUserLogged();
        $notes = implode("[LN_END]", $_POST);
        SongMapper::addNoteToSong($songId, $notes);
    }

    function filterSearch($objects, $search) {
        $lowerSearch = mb_strtolower($search);
        return array_filter($objects, function($obj) use ($lowerSearch) {
            $methods = get_class_methods($obj);
            foreach ($methods as $method) {
                if (strpos($method, 'get') === 0) {
                    $attr = $obj->$method();
                    if (mb_strpos(mb_strtolower($attr), $lowerSearch) !== false && $method != "getAudio") {
                        return true;
                    }
                }
            }
            return false;
        });
    }
}