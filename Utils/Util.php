<?php  

class Util {
    static function redirect($location, $type = null, $message = null) {
        $query = [];
        if ($type) $query[$type] = $message;
        
        $url = $location . (!empty($query) ? '?' . http_build_query($query) : '');
        header("Location: $url");
        exit;
    }
}


