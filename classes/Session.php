<?php
/**
 * Beskrivelse kommer snarest
 *
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @copyright   Aarhus Tech SKP 2017
 */

class Session {
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function flash ($name, $string = 'null') {
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
                return $session;
        } else {
            self::put($name, $string);
        }
    }

    public static function ajaxResp($status, $msg) {
        die('<div class="alert alert-dismissible alert-'.$status.'"><p class="text-center" style="margin-bottom: 0;">'.$msg.'</p></div>');
        //header('Content-type: application/json', true);
        //die(json_encode(array('status' => $status, 'message' => $msg)));
    }
}
