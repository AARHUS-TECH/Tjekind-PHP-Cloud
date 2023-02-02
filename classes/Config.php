<?php
/**
 * Reads and sets config values
 * 
 * @package     Tjekind Cloud
 * @file        Config.php "classes/Config.php"
 * @class       Config  
 * @version     1.0.0
 
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @copyright   Aarhus Tech SKP 2017
 */

class Config {
    public static function get($path = null) {
        if ($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach($path as $bit) {
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }

            return $config;
        }

        return false;
    }
}