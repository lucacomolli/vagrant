<?php

class BandUserMapper
{
    public static function getBandsIdsByUser(User $user){
        $conn = new DatabaseConnection();
        $uid = $user->getId();
        $queryUserId = "SELECT bandId from band_user where userId = :uid";
        $stmt = $conn->prepare($queryUserId);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        $bands = array();
        while($res = $stmt->fetch()){
            $bands[] = $res['bandId'];
        }
        return $bands;
    }

    public static function addUserToBand(User $user, Band $band){
        $conn = new DatabaseConnection();
        $uid = $user->getId();
        $bid = $band->getId();
        $query = "INSERT INTO band_user(userId, bandId) VALUES (:uid, :bid)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":bid", $bid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('location: ' . URL . 'administration/index/succ_usrband_added');
        } else {
            echo "Error while adding a band to user. // Please report this to the developers.";
        }
    }

    public static function removeUserFromBand(User $user, Band $band){
        $conn = new DatabaseConnection();
        $uid = $user->getId();
        $bid = $band->getId();
        $query = "DELETE FROM band_user WHERE userId = :uid AND bandId = :bid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->bindParam(":bid", $bid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('location: ' . URL . 'administration/index/succ_usr_removed_from_band');
        } else {
            echo "Error while adding a band to user. // Please report this to the developers.";
        }
    }
}