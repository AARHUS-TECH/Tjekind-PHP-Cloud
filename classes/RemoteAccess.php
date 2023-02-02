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
    private int $_numberOfAccesses = 0;

    public function __construct()
    {
        $this->_numberOfAccesses++;
    }
    
    public function __destruct() 
    {
        $this->_numberOfAccesses < 1 ? 0 : $this->_numberOfAccesses--;
    }

    /**
     * @name    getNumberOfAccesses
     * @return  number of current accessing users and terminal
     */
    public function getNumberOfAccesses() : int
    {
        return $this->_numberOfAccesses;
    }
    
    public static function checkToken(?string $token): false|string
    {   
        // Test values
        //$token = "cj>!pQLMseLRx}oqM/8'3Q~{nP(R;W";
        //$token = "5f51a4a917841eb4210b2c97979886d1cdcc1ece77e0bc1a2d49579449baf019";

        // Check if token is valid ref. config array in init.php
        $token_whitelist = Config::get('token_whitelist') ?? false;
        //var_dump($token_whitelist);

        $token_terminal = Config::get('token_terminal') ?? false;
        //var_dump($token_terminal);
            
        if ( in_array( $token, $token_whitelist ) ) {
            $result = "token_whitelist: " . array_search($token, $token_whitelist); 
            echo "Result: " . $result;
            return $result;
        } elseif ( in_array( $token, $token_terminal ) ) {
            $result = "token_terminal: " . array_search($token, $token_terminal); 
            echo "Result: " . $result;
            return $result;
        } else {
            return false;
        }
    }
}

