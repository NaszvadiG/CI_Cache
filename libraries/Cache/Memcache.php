<?php
require_once(APPPATH.'libraries/Cache/CacheDriver'.EXT);
class Memcache extends CacheDriver {
    
    /*
     *  Memcache Driver with multi-get support
     *
     *  Note; most of the functionality inherited from the CacheDriver
     *  class has been overloaded.
     *
     *  Also, if the memcache library is not installed 
     */
    
    protected $servers = array();
    protected $memcache = NULL;

    protected function _connect () {
        
        /*
         *  Connect to Memcache Servers
         */
        
        if (!function_exists('memcache_connect')) {
            show_error('You do not have the php memcache module installed.');
            return false;
        }

        $this->memcache = new Memcache;

        $error_display = ini_get('display_errors');
        $error_reporting = ini_get('error_reporting');

        //  Should we stay quiet if we can't connect?
        if ($this->settings['silent']) {
            ini_set('display_errors', "Off");
            ini_set('error_reporting', 0);
        }

        //  Connect to the servers
        foreach ($this->settings['servers'] as $server) {
            if ($this->memcache->addServer($server['host'], $server['port'])) {
                $this->servers[] = $server; 
            }
        }

        //  Turn it back on error reporting and display.
        if ($this->settings['silent']) {
            ini_set('display_errors', $error_display);
            ini_set('error_reporting', $error_reporting);
        }
    }
    
    public function set ($key, $value = NULL) {
        
        /*
         *  Set the value of the key(s)
         */

        if (is_array($key)) {
            return $this->memcache->multiset(
                $key,
                0,
                $this->settings['expire']
            );
        }

        return $this->memcache->set(
            $key,
            $value,
            0,
            $this->settings['expire']
        );
    }
    
    public function get ($key) {
        
        /*
         *  Return the values of key(s)
         */

        if (is_array($key)) {
            return $this->memcache->multiget($key);
        }

        return $this->memcache->get($key);
    }

    protected function _replace ($key, $value) {
        $this->memcache->replace(
            $key,
            $value,
            0,
            $this->settings['expire']
        );
    }

    protected function _delete ($key) {
        $this->memcache->delete($key);
    }
}
