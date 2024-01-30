<?php
require_once './application/models/DatabaseConnection.php';
require_once './application/models/User.php';
require_once './application/models/Band.php';
require_once './application/models/BandUserMapper.php';
require_once './application/models/BandMapper.php';
require_once './application/models/FileUtils.php';
class SongMapper
{
    public static function getAllMapped(){
        $conn = new DatabaseConnection();
        $songs = array();
        $bands = BandMapper::getAll();
        foreach ($bands as $band){
            $query = "SELECT * from song WHERE bandId = :bid";
            $stmt = $conn->prepare($query);
            $bid = $band->getId();
            $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);
            $stmt->execute();
            while ($res = $stmt->fetch()){
                $song = new Song($res['id'], $res['title'], $res['author'], $res['year'], $res['description'],
                    $res['audio'], $res['video'], $res['cover'], $res['album'], $res['text'], $res['bpm'], $res['genre'],
                    $res['type'], $res['instruments'], $res['notes'], $res['bandId']);
                $songs[$bid][] = $song;
            }
        }
        return $songs;
    }


    public static function getUserSongs(User $user, $useAPI = false){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        $conn = new DatabaseConnection();
        $songs = array();
        foreach(BandUserMapper::getBandsIdsByUser($_SESSION[S_USER]) as $bandId){
            $query = "SELECT * from song where bandId = :bandid";
            $stmt2 = $conn->prepare($query);
            $stmt2->bindParam(':bandid', $bandId, PDO::PARAM_INT);
            $stmt2->execute();
            while ($res2 = $stmt2->fetch()){
                $songs[] = new Song($res2['id'], $res2['title'], $res2['author'], $res2['year'], $res2['description'],
                    $res2['audio'], $res2['video'], $res2['cover'], $res2['album'], $res2['text'], $res2['bpm'], $res2['genre'],
                    $res2['type'], $res2['instruments'], $res2['notes'], $res2['bandId']);
            }
        }
        if($useAPI){
            return json_encode($songs);
        }
        return $songs;
    }

    public static function getSongById($id)
    {
        $conn = new DatabaseConnection();
        $query = "SELECT * FROM song WHERE id = :sid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":sid", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        if($res){
            return new Song($res['id'], $res['title'], $res['author'], $res['year'], $res['description'],
                $res['audio'], $res['video'], $res['cover'],$res['album'], $res['text'], $res['bpm'], $res['genre'],
                $res['type'], $res['instruments'], $res['notes'], $res['bandId']);
        }else{
            return null;
        }
    }

    public static function checkSongBand(?Song $song){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        if($song != null){
            $song = self::getSongById($song->getId());
            $userBands = BandUserMapper::getBandsIdsByUser($_SESSION[S_USER]);
            return in_array($song->getBandId(), $userBands);
        }else{
            return false;
        }
    }

    public static function getSongCover($id){
        $conn = new DatabaseConnection();
        $query = "SELECT cover FROM song WHERE id = :sid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":sid", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        if($res){
            return $res[0];
        }else{
            return null;
        }
    }

    public static function insertNewSong(Song $song){
        $conn = new DatabaseConnection();

        $title = $song->getTitle();
        $author = $song->getAuthor();
        $year = $song->getYear();
        $description = $song->getDescription();
        $audio = $song->getAudio();
        $video = $song->getVideo();
        $image = $song->getImage();
        $album = $song->getAlbum();
        $text = $song->getText();
        $bpm = $song->getBpm();
        $genre = $song->getGenre();
        $type = $song->getType();
        $instruments = $song->getInstruments();
        $notes = $song->getNotes();
        $bandId = $song->getBandId();

        $query = "INSERT INTO song
          (title, author, year, description, audio, video, cover, album, text, bpm, genre, type, instruments, notes, bandId)
          VALUES (:title, :author, :year, :desc, :audio, :video, :image, :album, :text, :bpm, :genre, :type, :instr, :notes, :bid)";

        $stmt = $conn->prepare($query);
        $res = $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':year' => $year,
            ':desc' => $description,
            ':audio' => $audio,
            ':video' => $video,
            ':image' => $image,
            ':album' => $album,
            ':text' => $text,
            ':bpm' => $bpm,
            ':genre' => $genre,
            ':type' => $type,
            ':instr' => $instruments,
            ':notes' => $notes,
            ':bid' => $bandId
        ]);
        if($res){
            header('location: ' . URL . 'songs/index/succ_song_inserted');
        }else{
            header('location: ' . URL . 'songs/index/err_song_not_inserted');
        }
    }

    public static function addNoteToSong($songId, $notes){
        $conn = new DatabaseConnection();
        $query = "UPDATE song SET notes = :notes WHERE id = :sid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":notes", $notes);
        $stmt->bindParam(":sid", $songId, PDO::PARAM_INT);
        if($stmt->execute()){
            header('location: ' . URL . 'songs/text/' . $songId . '/viewnotes');
        }else{
            echo "ERROR";
        }
    }

    public static function getNotes($songId){
        $conn = new DatabaseConnection();
        $query = "SELECT notes FROM song WHERE id = :sid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":sid", $songId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public static function delete($id){
        $conn = new DatabaseConnection();
        $query = "DELETE FROM song where id = :sid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sid', $id, PDO::PARAM_INT);
        $song = SongMapper::getSongById($id);
        if($stmt->execute()){
            if(FileUtils::deleteFile("\\" . $song->getImage()) && FileUtils::deleteFile("\\" . $song->getAudio()) &&
            FileUtils::deleteFile("\\" . $song->getVideo())){
                header('location: ' . URL . 'administration/index/err_song_not_deleted');
            }
            header('location: ' . URL . 'administration/index/succ_song_deleted');
        }else{
            header('location: ' . URL . 'administration/index/err_song_not_deleted');
        }
    }
}