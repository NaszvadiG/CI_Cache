<?php
require_once(APPPATH.'libraries/Cache/CacheDriver'.EXT);
class APC extends CacheDriver {
    
    /*
     *  Stores cache using APC
     */
    
    protected function _connect () {
        if (!function_exists('apc_store')) {
            return show_error('You do not have the php apc module installed');
        }
    }

    protected function _set ($key, $value) {
        
        /*
         *  Set value of key in apc cache
         */
        
        return apc_store(
            $key,
            $value,
            $this->settings['expire']
        );
    }

    protected function _get ($key) {
        
        /*
         *  Get vlaue of key in apc cache
         */

        return apc_fetch($key);
    }

    protected function _replace ($key, $value) {
        
        /*
         *  Replace value of key in apc cache
         */

        if (!$this->_delete($key)) {
            return false;
        }

        return $this->_set($key, $value);
    }

    protected function _delete ($key) {
        
        /*
         *  Delete key in apc cache
         */

        return apc_delete($key);
    }
}
