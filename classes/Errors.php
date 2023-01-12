<?php  

class Errors {

    public static function getErrorMessage($session) {
        if(Session::exists($session)) {
            $message  = '<div class="alert alert-dismissible alert-danger">';
            $message .= '<p class="text-center" style="margin-bottom: 0;">' . Session::get($session) . '</p>';
            $message .= '</div>';

            Session::delete($session);

            return $message;
        }
        return false;
    }

    
    public static function getSuccessMessage($session) {
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

?>