<?php
class MY_Loader extends CI_Loader {
    
    /*
     *  Core extension of loader to implement the Cache Loading
     */

    var $_cache_config = array();

    function __construct () {
        parent::CI_Loader();
        
        $CI =& get_instance();
        $CI->config->load('cache', TRUE);
        $this->_cache_config = $CI->config->item('cache');
    }
    
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
        
        if (!array_key_exists($name, $this->_cache_config['servers'])) {
            show_error(
                'The cache you are requesting to load does not exist:'.$name
            );
            return false;
        }
        
        $cache = $this->_cache_config['servers'][$name];
        return $this->library('Cache/'.$cache['driver'], array(
            'name' => $name,
            'config' => $this->_cache_config,
            'settings' => $cache
        ), $name.'_cache');
    }
}
