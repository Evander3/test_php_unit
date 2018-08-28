<?php
declare(strict_types=1);
namespace App;

class DB_Connect
{
    public $conn;
    private const DEV_MODE = true;
    const DB_NAME = 'db_event_mngr';
    
    public static function getDevMode(): bool
    {
        return self::DEV_MODE;
    }
    public function init_db(): \PDO
    {
        $conn = self::init_db_connection();
        self::init_events_table($conn);
        self::init_records_table($conn);
        return $conn;
    }

    private function init_db_connection()
    {
        $user = 'root';
        $password = '';
        $dsn = "mysql:host=localhost";
        $sql_db = "CREATE DATABASE IF NOT EXISTS ".self::DB_NAME.
                    " CHARACTER SET utf8";
        
        try {
            $conn = new \PDO($dsn, $user, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            echo 'Connexion échouée : '.$e->getMessage();
        }
        
        try {
            $db_init = $conn->query($sql_db);
            echo "Database successfully initialized<br>";
            return $conn;
        } catch(\Exception $e) {
            echo 'Problème dans la création de la DB : '.$e->getMessage().'<br>';
        }
    }

    private function init_events_table(\PDO $conn): void
    {
        $sql_events_table = "CREATE TABLE IF NOT EXISTS ".self::DB_NAME.".events
                            (
                                id INT PRIMARY KEY NOT NULL,
                                event_stringid VARCHAR(255),
                                event_name VARCHAR(255),
                                event_pop INT,
                                last_saved DATETIME,
                                event_date DATE,
                                event_loc VARCHAR(255),
                                event_image MEDIUMBLOB
                            )";
        try {
            $evt_t_init = $conn->exec($sql_events_table);
            echo "Events table created successfully<br>";
        } catch(\PDOException $e) {
            echo 'Problème dans la création de la table des events : '.$e->getMessage().'<br>';
        }
    }

    private function init_records_table(\PDO $conn): void
    {
        $sql_event = "CREATE TABLE IF NOT EXISTS ".self::DB_NAME.".records
                        (
                            id INT PRIMARY KEY NOT NULL,
                            time_record DATETIME,
                            event_id INT NOT NULL,
                            event_pop INT,
                            FOREIGN KEY (event_id) REFERENCES events(id)
                        )";
        try {
            $rec_t_init = $conn->exec($sql_event);
            echo "Records table created successfully<br>";
        } catch(\PDOException $e) {
            echo 'Failed to create the records table : '.$e->getMessage().'<br>';
        }
    }

    public static function close_db_connection(\PDO $conn): void
    {
        unset($conn);
    }
}
