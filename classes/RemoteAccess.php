<?php
/**
 * Methods for database connection and queries
 * 
 * @package     Tjekind Cloud
 * @file        RemoteAccess.php "classes/RemoteAccess.php"
 * @version     0.0.0 - prototype
 *
 * @author      Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @copyright   Aarhus Tech SKP 2023
 */

class RemoteAccess
{
    private $_numberOfAccesses = 0;

    public function __construct()
    {
        $this->_numberOfAccesses++;
    }
    
    public function __destruct() 
    {
        ($this->_numberOfAccesses >= 1)?$this->_numberOfAccesses--:0;
    }
    
    public function getNumberOfAccesses() : int
    {
        return (int)$this->_numberOfAccesses;
    }
    
    public static function checkToken(?string $token)
    {
        // Check if token is valid ref. config array in init.php
        $token_whitelist = Config::get('token_whitelist') ?? false;
        $token_terminal = Config::get('token_terminal') ?? false;

        if ( $token_whitelist ) {
            if ( in_array( $token, $token_whitelist ) ) {
                return true;
            } else {
                return false;
            }
        } elseif ( $token_terminal ) {
            if ( in_array( $token, $token_terminal ) ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

        var_dump($a);

        /*if ( $token == TOKEN ) {
            return true;
        } else {
            return false;
        }*/
    }

    

}
?>
