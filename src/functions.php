<?php
declare(strict_types=1);

use phpDocumentor\Reflection\Types\Void_;

function initialization(string $dbname): PDO
{
    $conn = init_db_connection($dbname);
    init_events_table($conn,$dbname);
    create_event_table($conn,$dbname);
    return $conn;
}

function create_event_table(PDO $conn,string $dbname): void
{
    $sql_event = "CREATE TABLE IF NOT EXISTS $dbname.records
                    (
                        id INT PRIMARY KEY NOT NULL,
                        time_record DATETIME,
                        event_id INT NOT NULL,
                        event_pop INT,
                        FOREIGN KEY (event_id) REFERENCES events(id)
                    )";
    try {
        $evt_id_init = $conn->exec($sql_event);
        echo "Records table created successfully<br>";
    } catch(PDOException $e) {
        echo 'Failed to create the '.$event_name.' table : '.$e->getMessage().'<br>';
    }
}

function init_events_table(PDO $conn, string $dbname)
{
    $sql_events_table = "CREATE TABLE IF NOT EXISTS $dbname.events
                        (
                            id INT PRIMARY KEY NOT NULL,
                            event_name VARCHAR(255),
                            event_date DATE,
                            creation_date DATETIME,
                            event_image MEDIUMBLOB,
                            event_loc VARCHAR(255)
                        )";
    try {
        $evt_t_init = $conn->exec($sql_events_table);
        echo "Events table created successfully<br>";
    } catch(PDOException $e) {
        echo 'Problème dans la création de la table des events : '.$e->getMessage().'<br>';
    }
}

function camelcaser(string &$name)
{
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
    );
    // Replace diacritics.
    $name = strtr( $name, $unwanted_array );
        // var_dump($name);
    // Put all initials as caps
    $name = ucwords($name);
        // var_dump($name);
    // Removes special chars.
    $name = preg_replace('/[^A-Za-z0-9\-]/','', $name);
    $name = trim($name);
        // var_dump($name);
    // Replaces all spaces with underscores.
    $name = str_replace(' ', '_', $name);
        // var_dump($name);
}

function init_db_connection(string $dbname)
{
    $user = 'root';
    $password = '';
    $dsn = "mysql:host=localhost";
    $sql_db = "CREATE DATABASE IF NOT EXISTS $dbname";
    
    try {
        $conn = new PDO($dsn, $user, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'Connexion échouée : '.$e->getMessage();
    }
    
    try {
        $db_init = $conn->query($sql_db);
        echo "Database successfully initialized<br>";
        return $conn;
    } catch(exception $e) {
        echo 'Problème dans la création de la DB : '.$e->getMessage().'<br>';
    }
}

function close_db_connection(PDO $conn): void
{
    if (isset($conn))
    {
        $conn = null;
    }
}

function get_session_pop(int &$num_member): void
{
    if (!isset($_SESSION['num_member'])) {
        $_SESSION['num_member']=$num_member;
    } else {
        $num_member=$_SESSION['num_member'];
    }
}

function increase(int &$num_member): void
{
    if ($num_member<CFG_MAX_POP) {
        $num_member++;
    } elseif ($num_member>=CFG_MAX_POP) {
        $num_member=CFG_MAX_POP;
    } else {
        $num_member=CFG_MIN_POP;
    }
}

function decrease(int &$num_member): void
{
    if ($num_member>CFG_MAX_POP) {
        $num_member=CFG_MAX_POP;
    }
    if ($num_member>CFG_MIN_POP) {
        $num_member--;
    } else {
        $num_member=CFG_MIN_POP;
    }
}

function resetPopCount(): void
{
    // setcookie($_COOKIE["PHPSESSID"],'',time()-3600);
    session_destroy();
    // session_unset();
}
