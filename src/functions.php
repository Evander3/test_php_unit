<?php

use phpDocumentor\Reflection\Types\Void_;


// TEST TEST TEST
// function ShowMyName($name) {
//     return sprintf('Your name is %s', $name);
// }

// function incrementalHash($len = 5){
//     $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
//     $base = strlen($charset);
//     $result = '';
  
//     $now = explode(' ', microtime())[1];
//     while ($now >= $base){
//       $i = $now % $base;
//       $result = $charset[$i] . $result;
//       $now /= $base;
//     }
//     return substr($result, -5);
// }

// function randstr(int $len): string {
//     $out = substr(md5(microtime()),rand(0,26),$len);
//     return $out;
// }

// ENDTEST ENDTEST ENDTEST


function camelcaser(string &$name)
{
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
    );
    $str = strtr( $str, $unwanted_array );
    $name = strtr(ucwords($name),' ','');
}

function create_event_table(string $event_name): void
{
    camelcaser($event_name);
    $sql = "CREATE TABLE IF NOT EXISTS $event_name";
        //     CREATE TABLE utilisateur
        // (
        //     id INT PRIMARY KEY NOT NULL,
        //     nom VARCHAR(100),
        //     prenom VARCHAR(100),
        //     email VARCHAR(255),
        //     date_naissance DATE,
        //     pays VARCHAR(255),
        //     ville VARCHAR(255),
        //     code_postal VARCHAR(5),
        //     nombre_achat INT
        // )
    try {
        $stmt = $conn->query($sql);
        // echo "Database created successfully<br>";
    } catch(PDOException $e) {
        echo 'Problème dans la création de la DB : '.$e->getMessage();
    }
}
function init_db_access(string $dbname)
{
    $user = 'root';
    $password = '';
    $dsn = "mysql:host=localhost";
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    
    try {
        $conn = new PDO($dsn, $user, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'Connexion échouée : '.$e->getMessage();
    }

    try {
        $stmt = $conn->query($sql);
        // echo "Database created successfully<br>";
    } catch(PDOException $e) {
        echo 'Problème dans la création de la DB : '.$e->getMessage();
    }
    return $conn;
}

function close_db_connection($conn)
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
