<?php
class APC extends CacheDriver {
    
    /*
     *  Stores cache using APC
     */

    protected function _set ($key, $value) {
        
        /*
         *  Set value of key in apc cache
         */
        
        return apc_store(
            $key,
            $value,
            $this->config['expire']
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
