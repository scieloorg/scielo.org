<?php
/**
 * @author
 * SciELO - Scientific Electronic Library Online 
 * @link 
 * https://www.scielo.org/
 * @license
 * Copyright SciELO All Rights Reserved.
 */

defined('BASEPATH') or exit('No direct script access allowed');

use phpFastCache\CacheManager;

/**
 * Cache Class
 *
 * This class uses the phpfastcache library to cache the website content.
 *
 * @category	Libraries
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Cache
{

    private $internalCacheInstance;
    
    /**
     * Cache constructor.
     */
    public function __construct()
    {
        
        // Include autoloader
        require BASEPATH . '../phpfastcache-6.1.3/src/autoload.php';
 
        // Init default configuration for "files" adapter
        CacheManager::setDefaultConfig([
            "path" => APPPATH . "/cache"
        ]);
 
        // Get instance of files cache
        $this->internalCacheInstance = CacheManager::getInstance('files');
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        $cacheItem = $this->internalCacheInstance->getItem($key);

        if (!$cacheItem->isExpired() && $cacheItem->get() !== null) {
            return $cacheItem->get();
        } else {
            return $default;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool
     */
    public function set($key, $value, $timeout = null)
    {
        
        $cacheItem = $this->internalCacheInstance->getItem($key)->set($value);

        if (is_int($timeout) && $timeout <= 0) {
          $cacheItem->expiresAt((new \DateTime('@0')));
        } elseif (is_int($timeout) || $timeout instanceof \DateInterval) {
          $cacheItem->expiresAfter($timeout);
        }

        return $this->internalCacheInstance->save($cacheItem);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->internalCacheInstance->deleteItem($key);
    }

    /**
     * @return bool
     */
    public function clear()
    {
        return $this->internalCacheInstance->clear();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key) 
    {
        $cacheItem = $this->internalCacheInstance->getItem($key);

        return $cacheItem->isHit() && !$cacheItem->isExpired();
    }
}
