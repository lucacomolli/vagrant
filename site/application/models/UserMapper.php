<?php
require_once './application/models/DatabaseConnection.php';
require_once './application/models/DataCleaner.php';
require_once './application/models/User.php';

class UserMapper
{
    public static function getAll(){
        $conn = new DatabaseConnection();
        $query = "SELECT * FROM user";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $users = array();
        while ($res = $stmt->fetch()){
            $users[] = new User($res['id'], $res['name'], $res['surname'], $res['email'], $res['authLevel']);
        }
        return $users;
    }

    public static function getById($userId){
        $conn = new DatabaseConnection();
        $query = "SELECT * FROM user WHERE id = :uid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":uid", $userId, PDO::PARAM_INT);
        $stmt->execute();
        if($res = $stmt->fetch()) {
            return new User($res['id'], $res['name'], $res['surname'], $res['email'], $res['authLevel']);
        }
        return null;
    }
    public static function login($uname, $pass)
    {
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        $conn = new DatabaseConnection();
        $uname = DataCleaner::cleanEmail($uname);
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $uname, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $inspass = hash("sha256", $pass);
        if ($result['password'] == $inspass) {
            $usr = new User($result['id'], $result['name'], $result['surname'], $result['email'], $result['authLevel']);
            $_SESSION[S_IS_LOGGED] = true;
            $_SESSION[S_USER] = $usr;
            $_SESSION[S_CHNGPW] = false;
            if($inspass == hash('sha256', FIRST_LOGIN_SECURE_PW)){
                $_SESSION[S_CHNGPW] = true;
            }
            return true;
        }
        return false;
    }

    public static function delete($id){
        if($_SESSION[S_USER]->getId() != $id){
            $conn = new DatabaseConnection();
            $query = "DELETE FROM user where id = :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':uid', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                header('location: ' . URL . 'administration/index/succ_usr_deleted');
            }else{
                header('location: ' . URL . 'administration/index/err_usr_not_deleted');
            }
        }else{
            header('location: ' . URL . 'administration/index/err_usr_not_deleted_yourself');
        }
    }

    public static function addNewUser(User $user){
        $conn = new DatabaseConnection();
        $query = "INSERT INTO user (name, surname, email, authLevel, password) VALUES (:name, :surname, :email, :al, :pw)";
        $stmt = $conn->prepare($query);
        $name = $user->getName();
        $surname = $user->getSurname();
        $email = $user->getEmail();
        $al = $user->getIsAdmin();
        $pw = hash('sha256', FIRST_LOGIN_SECURE_PW);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":surname", $surname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":al", $al, PDO::PARAM_INT);
        $stmt->bindParam(":pw", $pw);
        if($stmt->execute()){
            header('location: ' . URL . 'administration/index/succ_usr_created');
        }else{
            header('location: ' . URL . 'administration/index/err_usr_not_created');
        }
    }

    public static function changeNewUserPassword(User $user, $plainPass){
        $conn = new DatabaseConnection();
        $uid = $user->getId();
        $query = "UPDATE user SET password = :pw WHERE id = :id";
        $stmt = $conn->prepare($query);
        $pass = hash('sha256', $plainPass);
        $stmt->bindParam(":pw", $pass);
        $stmt->bindParam(":id", $uid, PDO::PARAM_INT);
        if($stmt->execute()){
            header('location: ' . URL);
        }else{
            echo "Error while changing password";
        }
    }
}