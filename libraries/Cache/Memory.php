<?php
class Memory extends CacheDriver {
    
    /*
     *  Stores a local cache in memory.
     *
     *  The cache is erased at every instantiation of the process. In terms
     *  of web development, for every page load. Useful for making sure you
     *  only poll results once.
     */
    
    protected $data = array();

    protected function _set ($key, $value) {
        
        /*
         *  Set value of the key
         */

        $this->data[$key] = new CacheItem($value);
        return true;
    }

    protected function _get ($key) {
        
        /*
         *  Get value of key
         */

        if (array_key_exists($key, $this->data)) {
            
            //  Make sure the data has not expired.
            if ($this->data[$key]->time < (now() - $this->config['expire'])) {
                $this->_delete($key);
                return false;
            }

            return $this->data[$key]->value;
        }
        
        return false;
    }

    protected function _replace ($key, $value) {
        
        /*
         *  Replaces the value fo key
         */

        if (array_key_exists($key, $this->data)) {
            return $this->_set($key, $value);
        }

        return false;
    }
    
    protected function _delete ($key) {
        
        /*
         *  Deletes a key
         */

        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
            return true;
        }

        return false;
    }
}

class CacheItem {
    
    /*
     *  Class that holds a cache item.
     */

    public $time = 0;
    public $value = NULL;

    public function __construct ($value) {
        $this->time = now();
        $this->value = $value;
    }
}
