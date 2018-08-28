<?php
declare(strict_types=1);
namespace App;

class GetData implements Eventinterface
{
    static public $conn;
    // Hardcoded limits, I don't like it.
    static private $CFG_MAX_POP = 10;
    static private  $CFG_MIN_POP = 0;
    
    public function __construct(\PDO $conn)
    {
        self::$conn = $conn;
    }

    static public function getCFG_MAX_POP()
    {
        return self::$CFG_MAX_POP;
    }

    static public function getCFG_MIN_POP()
    {
        return self::$CFG_MIN_POP;
    }

    public function getEventName(string $raw_event_name)
    {
        $db_event_name = htmlspecialchars($raw_event_name);
        $temp_op = new GenericFunctions();
        $temp_op->camelcaser($raw_event_name);
        $event_name_array = [$db_event_name,$raw_event_name];
        return $event_name_array;
        
        echo '<pre>';
        var_dump($event_name_array);
        echo '</pre>';
    }
    public function getEventDate(\PDO $conn, string $event_date)
    {
    }
    public function getEventLoc(\PDO $conn, string $event_loc)
    {
    }
    public function getEventPop(int &$num_member)
    {
        if (!isset($_SESSION['num_member'])) {
            $_SESSION['num_member']=$num_member;
        } else {
            $num_member=$_SESSION['num_member'];
        }
    }
    public function pushEventData(\PDO $conn, string $event_stringid, string $event_name, int $event_pop, string $event_date, string $event_loc)
    {
        $date = new \DateTime();
        $last_saved = $date->format ('Y-m-d H:i:s');
        echo $last_saved;
        try {
            $stmt = $conn->prepare("
                INSERT IGNORE INTO events (event_stringid,event_name,event_pop,last_saved, event_date, event_loc)
                VALUES (:event_stringid, :event_name, :event_pop, :last_saved,  :event_date,  :event_loc)
            ");
            $stmt->bindValue('event_stringid', $event_stringid);
            $stmt->bindValue('event_name', $event_name);
            $stmt->bindValue('event_pop', $event_pop);
            $stmt->bindValue('last_saved', $last_saved);
            $stmt->bindValue('event_date', $event_date);
            $stmt->bindValue('event_loc', $event_loc);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function increase(int &$num_member): void
    {
        if ($num_member<self::$CFG_MAX_POP) {
            $num_member++;
        } elseif ($num_member>=self::$CFG_MAX_POP) {
            $num_member=self::$CFG_MAX_POP;
        } else {
            $num_member=self::$CFG_MIN_POP;
        }
    }

    public function decrease(int &$num_member): void
    {
        if ($num_member>self::$CFG_MAX_POP) {
            $num_member=self::$CFG_MAX_POP;
        }
        if ($num_member>self::$CFG_MIN_POP) {
            $num_member--;
        } else {
            $num_member=self::$CFG_MIN_POP;
        }
    }

    public function resetPopCount(): void
    {
        // setcookie($_COOKIE["PHPSESSID"],'',time()-3600);
        session_destroy();
        // session_unset();
    }
}
