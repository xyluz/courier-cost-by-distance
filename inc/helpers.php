<?php 

if (!function_exists('dd')) {

    /**
     * For debugging purposes, dump the contents of a variable to the screen.
     */

    function dd($die = true, $var = null, $pretty = true) {
        if($pretty) echo "<pre>";
        var_dump(func_get_args()); 
        if($pretty) echo "</pre>";
        $die ? die() : null;
    }

}


