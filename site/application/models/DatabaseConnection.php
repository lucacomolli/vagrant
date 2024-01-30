<?php

class DatabaseConnection extends PDO
{
    private static PDO $_connection;

    function __construct()
    {
        try{
            //Creo PDO per mysql
            $dns = 'mysql:host=' . HOST . ';dbname=' . DB_NAME;
            parent::__construct($dns, USERNAME, PASSWORD);
            //Setto attributo per ritornare errori PDOException
            $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Meglio disabilitare gli emulated prepared con i driver MySQL
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        //Ritorno gli errori (se ce ne sono)
        catch (PDOException $e){
            echo "Internal Server Error.";
            echo $e;
            die();
        }
    }
}