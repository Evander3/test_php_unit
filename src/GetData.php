<?php
declare(strict_types=1);
namespace App;

class GetData
{
    public function get_event_data(PDO $conn)
    {
        // $_POST['event_date']
        // $_POST['event_name']
        // $_POST['event_loc']
        // try {
        //     $stmt = $pdo->prepare("
        //         DELETE FROM `personnes`
        //         WHERE lastname LIKE :lastname AND 
        //         firstname LIKE :firstname
        //     ");
        //     // bindvalue injecte la valeur de mes variables
        //     $stmt->bindValue('firstname', $firstname);
        //     $stmt->bindValue('lastname', $lastname);
        //     // bindparam injecte la référence de mes varaibles
        //     $stmt->bindParam('firstname', $firstname);
        //     $stmt->bindParam('lastname', $lastname);
        //     // on execute le code derriere sans avoir besoi nde rappeler les variables
        //     $stmt->execute();
        // } catch (PDOException $e) {
        //     echo $e->getMessage();
        // }
    }

    public function get_session_pop(int &$num_member): void
    {
        if (!isset($_SESSION['num_member'])) {
            $_SESSION['num_member']=$num_member;
        } else {
            $num_member=$_SESSION['num_member'];
        }
    }

    public function increase(int &$num_member): void
    {
        if ($num_member<CFG_MAX_POP) {
            $num_member++;
        } elseif ($num_member>=CFG_MAX_POP) {
            $num_member=CFG_MAX_POP;
        } else {
            $num_member=CFG_MIN_POP;
        }
    }

    public function decrease(int &$num_member): void
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

    public function resetPopCount(): void
    {
        // setcookie($_COOKIE["PHPSESSID"],'',time()-3600);
        session_destroy();
        // session_unset();
    }
}
