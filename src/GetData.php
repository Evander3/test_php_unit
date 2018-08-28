<?php
declare(strict_types=1);
namespace App;

class GetData implements Eventinterface
{
    private const CFG_MAX_POP = 10;
    private const CFG_MIN_POP = 0;
    private static $conn;

    public function __construct(\PDO $conn)
    {
        self::$conn = $conn;
    }

    public static function getCFG_MIN_POP(): int
    {
        return self::CFG_MIN_POP;
    }
    public static function getCFG_MAX_POP(): int
    {
        return self::CFG_MAX_POP;
    }
    
    public function pushEventData(\PDO $conn)
    {
        
    $datalnk->pushEventData(
        $conn,
        $event_name_array[1],
        $event_name_array[0],
        $num_member,
        $_POST["event_date"],
        $_POST["event_loc"]
    );
    }

    public function getEventData($post,int $event_pop)
    {
        // first let's get that damn last_saved
        $date = new \DateTime('',new \DateTimeZone('Europe/Paris'));
        $last_saved = serialize($date);

        try {
            $stmt = self::$conn->prepare("
                INSERT INTO events (
                    event_name,
                    event_pop,
                    last_saved,
                    event_date,
                    event_loc)
                VALUES (
                    :event_name,
                    :event_pop,
                    :last_saved,
                    :event_date,
                    :event_loc)
            ");
            $stmt->bindValue('event_name', $post['event_name']);
            $stmt->bindValue('event_pop', $event_pop);
            $stmt->bindValue('last_saved', $last_saved);
            $stmt->bindValue('event_date', $post['event_date']);
            $stmt->bindValue('event_loc', $post['event_loc']);
            // on execute le code derriere sans avoir besoin de rappeler les variables
            $stmt->execute();
            echo "The Push Is Done, sir!";
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getEventPop(int &$num_member): void
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

    private function increase(int &$num_member): void
    {
        if ($num_member<self::CFG_MAX_POP) {
            $num_member++;
        } elseif ($num_member>=self::CFG_MAX_POP) {
            $num_member=self::CFG_MAX_POP;
        } else {
            $num_member=self::CFG_MIN_POP;
        }
    }

    private function decrease(int &$num_member): void
    {
        if ($num_member>self::CFG_MAX_POP) {
            $num_member=self::CFG_MAX_POP;
        }
        if ($num_member>self::CFG_MIN_POP) {
            $num_member--;
        } else {
            $num_member=self::CFG_MIN_POP;
        }
    }

    public function resetPopCount(): void
    {
        // setcookie($_COOKIE["PHPSESSID"],'',time()-3600);
        session_destroy();
        // session_unset();
    }
}
