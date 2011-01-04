<?php
class MY_Loader extends CI_Loader {
    
    /*
     *  Core extension of loader to implement the Cache Loading
     */

    var $_caches = array();

    function cache ($name) {
        
        /*
         *  Loads the cache
         */
        
        //  If we were given an array of names then 
        if (is_array($name)) {
            $output = array();
            foreach ($name as $n) {
                $output[] = $this->cache($n);
            }

            return $output;
        }
        
        return $this->library('Cache/'.$name);
    }
}
