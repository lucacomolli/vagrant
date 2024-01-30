<?php
require "application/models/DatabaseConnection.php";
//------LINK------//
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
$documentRoot = $_SERVER['DOCUMENT_ROOT'];
$dir = str_replace('\\', '/', getcwd().'/');
$final = $actual_link . str_replace($documentRoot, '', $dir);
define("URL", $final);
const HOST = "10.10.20.11";
const USERNAME = "db_connector";
const PASSWORD = "Password&1";
const DB_NAME = "gestionaleband";
const PORT = 3306;

const S_IS_LOGGED = 'sess_islogged';
const S_USER = 'sess_user';
const S_CHNGPW = 'sess_changePassword';

const DELETE_USER = 'd_user';
const DELETE_BAND = 'd_band';
const DELETE_SONG = 'd_song';
const ADD_USER = 'a_user';
const ADD_BAND = 'a_band';
const FIRST_LOGIN_SECURE_PW = "This123Is136FirstLogon998_69So96_Please11--2241Change--134Me1!1_1-1_1";