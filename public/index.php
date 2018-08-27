<?php

declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';
// require __DIR__.'/../src/DB_Connect.php';
// require __DIR__.'/../src/GenericFunctions.php';
// require __DIR__.'/../src/GetData.php';
// require __DIR__.'/../src/EventInterface.php';

session_start();

echo '<pre>';
var_dump($_POST);
echo '</pre>';

$num_member = 0;

// $dbco is the oject "connection to the database".
$dbco = new App\DB_Connect();
// $conn is the PDO object linking with the SQL db.
$conn = $dbco->init_db();

var_dump($conn);

// TODO : get the event data and put it in the db
$datalnk = new App\GetData($conn);

$datalnk->getEventPop($num_member);

$test1 = isset($_POST["operation"]);
$test2 = isset($_POST["event_name"]);

if ($test1 || $test2)
{
    // If the operations buttons are clicked, the pop value changes
    if ($test1)
    {
        if (function_exists($_POST["operation"]))
        {
            $_POST["operation"]($num_member);
        }
        $_SESSION['num_member'] = $num_member;
    }
    // The creation/modification of the event data
    if ($test2)
    {
        $datalnk->getEventData($_POST,$num_member);
    }
    
    $redir = new App\GenericFunctions();
    $redir->redirect($dbco);
} else
{
    echo "La, y a un os ...";
}
var_dump($num_member);
// After this, the connection to the db is destroyed
// $dbco::close_db_connection($conn);

?>

<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TP5 - Compteur de participants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <h2>Définir un évènement :</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="event_date_label">Date</label>
            <input type="date" class="form-control" name="event_date" placeholder="YYYY-MM-DD">
        </div>
        <div class="form-group">
            <label for="event_name_label">Nom de l'évènement</label>
            <input type="text" class="form-control" name="event_name" >
        </div>
        <div class="form-group">
            <label for="event_loc_label">Lieu de l'évènement</label>
            <input type="text" class="form-control" name="event_loc" >
        </div>
        <!-- <div class="form-group">
            <label for="event_img_label">Choose an event image</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div> -->
        <button type="submit" name="event" value="event_data" class="btn btn-success">Envoi</button>
    </form>

    <table style="width:100%">
    
        <tr>
            <th><center>Diminuer</center></th>
            <th><center><h1>Participants actuels</h1></center></td>
            <th><center>Augmenter</center></td>
        </tr>
        <tr>
            <td>
                <form method="POST">
                    <center>
                        <?php if ($_SESSION['num_member']>App\GetData::getCFG_MIN_POP()): ?>
                            <button type="submit" name="operation" value="decrease"class="btn btn-primary"><h1>-</h1></button>
                        <?php else: ?>
                            <button type="submit" name="operation" value="decrease" disabled="true"class="btn btn-primary"><h1>-</h1></button>
                        <?php endif; ?>
                    </center>
                </form>
            </td>
            <td>
                <center>
                    <h1 class="display-1"><?php echo $_SESSION['num_member'];?> </h1>
                </center>
            </td> 
            <td>
                <form method="POST">
                    <center>
                        <?php if ($_SESSION['num_member']<App\GetData::getCFG_MAX_POP()): ?>
                            <button type="submit" name="operation" value="increase"class="btn btn-primary"><h1>+</h1></button>
                        <?php else: ?>
                            <button type="submit" name="operation" value="increase" disabled="true"class="btn btn-primary"><h1>+</h1></button>
                        <?php endif; ?>
                    </center>
                </form>
            </td>
        </tr>
    </table>

    <form method="POST">
        <hr>
        <button type="submit" name="operation" value="resetPopCount" class="btn btn-danger">Réinitialiser</button>
    </form>
    
</body>
</html>