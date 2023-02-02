<?php
/**
 * Beskrivelse kommer snarest
 *
 * @package     Tjekind Cloud
 * @file        Input.php "classes/Input.php"
 * @version     1.0
 *  
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @author      Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @copyright   Aarhus Tech SKP 2017-2023
 */

 
class Input {
    public static function exists($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    
    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if(isset($_GET[$item])) {
            return $_GET[$item];
        }

        return '';
    }
}
