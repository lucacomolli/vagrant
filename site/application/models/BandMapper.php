<?php

require_once "./application/models/Band.php";
require_once "./application/models/BandUserMapper.php";
require_once "./application/models/SongMapper.php";
require_once "./application/models/DatabaseConnection.php";
require_once "./application/models/User.php";
require_once "./application/models/UserMapper.php";


/**
 * Class Band
 */
class BandMapper
{
    public static function getAll(){
        $conn = new DatabaseConnection();
        $bands = array();
        $query = "SELECT * FROM band";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        while ($res = $stmt->fetch()){
            $bands[] = new Band($res['id'], $res['name']);
        }
        return $bands;
    }

    public static function getMembers(Band $band)
    {
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        $conn = new DatabaseConnection();
        $members = array();
        $bid = $band->getId();
        $query = "SELECT userId FROM band_user WHERE bandId = :bid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":bid", $bid, PDO::PARAM_INT);
        $stmt->execute();
        while ($res = $stmt->fetch()){
            $members[] = UserMapper::getById($res['userId']);
        }
        return $members;
    }

    public static function getBandsByUser(User $user){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        $conn = new DatabaseConnection();
        $bands = array();
        foreach (BandUserMapper::getBandsIdsByUser($user) as $bandId){
            $query = "SELECT * FROM band where id = :bid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':bid', $bandId, PDO::PARAM_INT);
            $stmt->execute();
            while ($res = $stmt->fetch()){
                $bands[] = new Band($res['id'], $res['name']);
            }
        }
        return $bands;
    }

    public static function getById($id){
        $conn = new DatabaseConnection();
        $bands = array();
        $query = "SELECT * FROM band WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($res = $stmt->fetch()){
            return new Band($res['id'], $res['name']);
        }
        return null;
    }
    public static function getBandNameById($id){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        $conn = new DatabaseConnection();
        $query = "SELECT name FROM band where id = :bid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':bid', $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        if(!$res){
            return -1;
        }else{
            return $res['name'];
        }
    }

    public static function delete($id){
        $conn = new DatabaseConnection();
        $query = "DELETE FROM band where id = :bid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':bid', $id, PDO::PARAM_INT);
        foreach (SongMapper::getAllMapped()[$id] as $song){
            SongMapper::delete($song->getId());
        }
        if($stmt->execute()){
            header('location: ' . URL . 'administration/index/succ_band_deleted');
        }else{
            header('location: ' . URL . 'administration/index/err_band_not_deleted');
        }
    }

    public static function add(Band $band){
        $conn = new DatabaseConnection();
        $query = "INSERT INTO band(name) VALUES (:bname)";
        $stmt = $conn->prepare($query);
        $bandname = $band->getName();
        $stmt->bindParam(':bname', $bandname);
        if($stmt->execute()){
            header('location: ' . URL . 'administration/index/succ_band_created');
        }else{
            header('location: ' . URL . 'administration/index/err_band_not_created');
        }
    }
}