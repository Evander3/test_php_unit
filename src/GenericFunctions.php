<?php
declare(strict_types=1);
namespace App;

use phpDocumentor\Reflection\Types\Void_;


class GenericFunctions
{
    public $name;

    public function sanitazer(string &$name): void
    {
        $name = trim($name);
        $name = htmlspecialchars($name);
    }
    public function camelcaser(string &$name): void
    {
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                    'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                    'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                    'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                    'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
        );
        // Replace diacritics.
        $name = strtr( $name, $unwanted_array );
        $name = trim($name);
        // Put all initials as caps
        $name = ucwords($name);
        // Removes special chars.
        $name = preg_replace('/[^A-Za-z0-9\-]/','', $name);
    }
    public function redirect($dbco)
    {
        if ( ! $dbco->getDevMode())
        {
            echo 'test';
            header('Location: index.php');
        }
    }
}
