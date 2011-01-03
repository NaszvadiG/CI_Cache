<?php
/*
 *  Driver Driven Cache Library
 *
 *  To extend this library simply add a driver to the Cache folder
 *  and then add the driver name to the driver array in the config file.
 *
 *  Supports multiple get, set, replace and delete.
 */

function build_cache () {
    
    /*
     *  Factory function used to build the cache objects.
     *
     *  Returns the cache objects in an array.
     */
    
    //  Load the configuration settings from the file
    $CI =& get_instance();
    $this->CI->config->load('cache', true);
    $config = $this->CI->config->item('cache');
    $loaded = array();
    $objs = array();

    //  Instantiate the Cache Objects
    foreach ($config['caches'] as $name => $cache) {
        if (!in_array($cache['driver'], $loaded)) {
            require(APPPATH.'libraries/Cache/'.$cache['driver'].EXT);
            $loaded[] = $cache['driver'];
        }

        $objs[$name] = new $cache['driver']($cache, $config);
    }

    return $objs;
}

class CacheDriver {
    
    /*
     *  Abstract Cache Driver Class
     *
     *  To create your own driver override the _set, _get, _replace,
     *  _connect, and _delete methods accordingly.
     */
    
    protected $settings = array();
    protected $config = array();

    public function __construct ($config, $main_config) {
        $this->settings = array();
        $this->config = array();

        $this->_connect();
    }
    
    protected function _connect () {
        
        /*
         *  Connects to the server if required.
         *
         *  Returns a boolean whether or not it was successful
         */
        
        return true;
    }

    public function set ($key, $value = NULL) {
        
        /*
         *  Sets the given key to value.
         *  Can receive an associative array or $key => $value pair.
         *
         *  Returns a boolean whether or not it was successful
         */

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                 if (!$this->_set($k, $v)) {
                    return false;
                 }
            }
        }

        return $this->_set($key, $value);
    }
    
    protected function _set ($key, $value) {
        /*
         *  Override this for your driver
         */
    }

    public function get ($key) {
        
        /*
         *  Returns the value for the given key.
         *  Can receive an array of keys to perform a multi-get
         *
         *  Returns a boolean whether or not it was successful
         */
        
        if (!is_array($key)) {
            return $this->_get($key);
        }

        $data = array();
        foreach ($key as $k) {
            $data[$k] = $this->_get($k);
        }

        return $data;
    }

    protected function _get ($key) {
        /*
         *  Override this for your driver
         */
    }

    public function replace ($key, $value = NULL) {
    
        /*
         *  Replaces the value for the key
         *  Can receive an associative array of $key=>$value for
         *  multi-replace
         *
         *  Returns a boolean whether or not it was successful
         */

        if (!is_array($key)) {
            return $this->_replace($key, $value);
        }

        $data = array();
        foreach ($key as $k => $v) {
            $data[$k] = $this->_replace($k, $v);
        }
    }

    protected function _replace ($key, $value) {
        /*
         *  Override this for your driver
         */
    }

    public function delete ($key) {
        
        /*
         *  Deletes the given key from the cache.
         *  Can receive an array of keys for multi-delete.
         *
         *  Returns a boolean whether or not it was successful.
         */

        if (!is_array($key)) {
            return $this->_delete($key);
        }

        $data = array();
        foreach ($key as $k) {
            $data[$k] = $this->_delete($k);
        }
    }

    protected function _delete ($key) {
        /*
         *  Override this for your driver.
         */
    }

}
