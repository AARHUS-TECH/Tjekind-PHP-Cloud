<?php  
/**
 * Beskrivelse kommer snarest
 *
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @author 		Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @copyright   Aarhus Tech SKP 2017-2023
 */


class Errors {

    /**
     * @param $session
     * @return false|string
     */
    public static function getErrorMessage($session): false|string
    {
        if(Session::exists($session)) {
            $message  = '<div class="alert alert-dismissible alert-danger">';
            $message .= '<p class="text-center" style="margin-bottom: 0;">' . Session::get($session) . '</p>';
            $message .= '</div>';

            Session::delete($session);

            return $message;
        }
        return false;
    }


    /**
     * @param $session
     * @return false|string
     */
    public static function getSuccessMessage($session): false|string
    {
        if(Session::exists($session)) {
            $message  = '<div class="alert alert-dismissible alert-success">';
            $message .= '<p class="text-center" style="margin-bottom: 0;">' . Session::get($session) . '</p>';
            $message .= '</div>';

            Session::delete($session);

            return $message;
        }
        return false;
    }

}

