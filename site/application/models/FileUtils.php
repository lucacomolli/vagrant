<?php
require_once './application/models/DataCleaner.php';
class FileUtils
{
    public static function uploadFile($file){
        $target_dir = 'uploads';
        $target_file = $target_dir . basename($file["name"]);
        $fileType = $file['type'];
        $upload = true;
        $shortfilename = basename($file["name"]);
        $shortfilename = DataCleaner::cleaAll($shortfilename);
        $shortfilename = strtolower($shortfilename);
        $shortfilename = str_replace(' ', '_', $shortfilename);
        $shortfilename = str_replace('%', '', $shortfilename);
        $shortfilename = str_replace('&', '', $shortfilename);
        $shortfilename = str_replace(';', '', $shortfilename);
        $shortfilename = str_replace('<', '', $shortfilename);
        $shortfilename = str_replace('>', '', $shortfilename);
        $shortfilename = str_replace('`', '', $shortfilename);
        $shortfilename = str_replace('\'', '', $shortfilename);
        $shortfilename = str_replace('"', '', $shortfilename);

        switch ($fileType){
            case 'audio/mpeg':
                $target_dir = getcwd() . '\\uploads\\audios\\';
                break;
            case 'video/mp4':
                $target_dir = getcwd() . '\\uploads\\videos\\';
                break;
            case 'image/png':
                $target_dir = getcwd() . '\\uploads\\artworks\\';
                break;
            default:
                $upload = false;
                break;
        }

        $target_file = $target_dir . bin2hex(openssl_random_pseudo_bytes(32)) . $shortfilename;

        // Check if file already exists
        if (file_exists($target_file)) {
            $upload = false;
            header('location: ' . URL . 'songs/addSong/err_fileexists');
        }

        // Check file size max 100MB
        if ($file["size"] > 100000000) {
            $upload = false;
            header('location: ' . URL . 'songs/addSong/err_filetoolarge');
        }
        if($upload){
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return str_replace('\\', '/', strstr($target_file, 'uploads'));
            } else {
                header('location: ' . URL . 'songs/addSong/err_upload_unknown');
            }
        }else{
            header('location: ' . URL . 'songs/index/err_mediamismatch');
        }
        return null;
    }

    public static function deleteFile($path)
    {
        $path = str_replace("\\", "/", $path);
        $path = getcwd() . $path;
        if(file_exists($path)){
            unlink($path);
            return true;
        }
        return false;
    }
}