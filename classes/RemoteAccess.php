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

    public function getNumberOfAccesses()
    {
        return $this->_numberOfAccesses;
    }

    

}
?>
