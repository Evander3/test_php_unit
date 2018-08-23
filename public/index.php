<?php

declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../src/functions.php';

session_start();

define('CFG_MAX_POP', 10);
define('CFG_MIN_POP', 0);
$num_member = 0;
$dbname = "db_event_mngr";
// $event_name = 'placeholder, for god\'s sake, will you work ?';
// camelcaser($event_name);
// echo $event_name;

$conn = initialization($dbname);

get_session_pop($num_member);

if (isset($_POST["operation"]))
{
    if (function_exists($_POST["operation"]))
    {
        $_POST["operation"]($num_member);
    }
    $_SESSION['num_member'] = $num_member;
    header('Location: index.php');
}

echo '<pre>';
var_dump($_POST);
echo '</pre>';


// $agenda_filename = "agenda.txt" ;
// $output_date = $_POST['input_date'];
// $input_date = explode('-',$output_date);
// $date_now = date("Y-m-d H:i:s");
// // var_dump($input_date);
// // echo (checkdate($input_date[1],$input_date[2],$input_date[0])===false);
// if (checkdate($input_date[1],$input_date[2],$input_date[0])===false) {
//     echo "La date n'est pas valide !" ;
// } else {
//     // echo "La date est valide, bravo champion !" ;
//     $input_data = trim($_POST['input_data']);

//     $ag_file_write = fopen($agenda_filename, "a+") or die("Nein nein nein nein nein !");
//     fwrite($ag_file_write,"\n $output_date || $date_now || $input_data");
//     fclose($ag_file_write);
// }

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
    <!-- <br /> -->
    <form action="" method="POST">
        <div class="form-group">
            <label for="event_date_label">Date</label>
            <input type="date" class="form-control" name="event_date" placeholder="YYYY-MM-DD">
            <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"> -->
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label for="event_name_label">Nom de l'évènement</label>
            <input type="text" class="form-control" name="event_name" >
            <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"> -->
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label for="event_img_label">Choose an event image</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <button type="submit" name="operation" value="event_data" class="btn btn-success">Envoi</button>
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
                        <?php if ($_SESSION['num_member']>CFG_MIN_POP): ?>
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
                        <?php if ($_SESSION['num_member']<CFG_MAX_POP): ?>
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