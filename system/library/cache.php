<?php
final class Cache { 	
	private $expire 		= 7200;
	private $memcache 		= null;
	private $redis 			= null;		
	private $ismemcache 	= false;
	private $isxcache 		= false;
	private $isredis 		= false;
	private $prefix 		= '';		
	
	public function __construct() {   		
		
		$this->expire 	= DB_CACHED_EXPIRE;
		$this->prefix 	= CACHE_NAMESPACE;
		
		if (CACHE_DRIVER == 'memcached') {
			$mc = new Memcache;
			if (@$mc->connect(MEMCACHE_HOSTNAME, MEMCACHE_PORT))
			{
				$this->memcache = $mc;
				$this->ismemcache = true;
			};
		} elseif (CACHE_DRIVER == 'xcache') {
			$this->isxcache = extension_loaded('xcache');	
		} elseif (CACHE_DRIVER == 'redis') {
			$this->redis = new Redis();
			if (@$this->redis->pconnect(REDIS_SOCKET)){
				$this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
				$this->redis->select(REDIS_DATABASE);
				$this->isredis = true;					
			} elseif(@$this->redis->pconnect(REDIS_HOST, REDIS_PORT)) {					
				$this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
				$this->redis->select(REDIS_DATABASE);
				$this->isredis = true;
			}				
		};
		
		if (!($this->ismemcache || $this->isxcache || $this->isredis))
		{
			$files = glob(DIR_CACHE . 'cache.*');
			
			if ($files) {
				foreach ($files as $file) {
					$time = substr(strrchr($file, '.'), 1);
					
					if ($time < time()) { 
						if (file_exists($file)) { 
							@unlink($file); 
						} 				
					} 			    
				} 		    
			} 		
		}   	
	} 	
	
	
	public function get($key, $explicit = false) {
		if (defined('IS_DEBUG') && IS_DEBUG && !$explicit){
			return false;
		}
		
		if ((CACHE_DRIVER == 'memcached') && $this->ismemcache){
			return($this->memcache->get($this->prefix . $key, 0));					
		} elseif ((CACHE_DRIVER == 'xcache') && $this->isxcache) {				
			return unserialize(xcache_get($this->prefix . $key));			
		} elseif ((CACHE_DRIVER == 'redis') && $this->isredis) {				
			return $this->redis->get($key);
		} else {
			$files = glob(DIR_CACHE . 'cache.' . $key . '.*');
			if ($files) {
				foreach ($files as $file) {
					$cache = '';
					$handle = fopen($file, 'r');
					if ($handle) {
						$cache = fread($handle, filesize($file));
						fclose($handle);
					}
					return unserialize($cache);
				}
			}
		}
	}
	
	public function set($key, $value, $ttl = DB_CACHED_EXPIRE, $redis_explicit = false) {
		if ((CACHE_DRIVER == 'memcached') && $this->ismemcache){
			$this->memcache->set($this->prefix . $key, $value, 0, $ttl);
		} elseif ((CACHE_DRIVER == 'xcache') && $this->isxcache) {							
			xcache_set($this->prefix . $key, serialize($value), $ttl);
		} elseif ((CACHE_DRIVER == 'redis') && $this->isredis) {
			if ($redis_explicit){
				$this->redis->set($key, $value);
			} else {
				$this->redis->set($key, $value, Array('nx'));
			}
		} else { 
			$this->delete($key);
			$file = DIR_CACHE . 'cache.' . $key . '.' . (time() + $ttl); 
			$handle = fopen($file, 'w');
			fwrite($handle, serialize($value));
			fclose($handle);
		};
	}

	public function addtolist($list, $value, $ttl = DB_CACHED_EXPIRE ){
		
		if ((CACHE_DRIVER == 'redis') && $this->isredis) {
			if (!$this->redis->lPushx($list, $value)){
				$this->redis->lPush($list, $value);
				$this->redis->expire($list, $ttl);
			}
			return true;
		} else {
			return false;
		}		
	}
	
	public function rpoplist($list){
		
		if ((CACHE_DRIVER == 'redis') && $this->isredis) {
			return $this->redis->rPop($list);
		} else {
			return false;
		}
	}		
	
	
	public function delete($key) {
		if ((CACHE_DRIVER == 'memcached') && $this->ismemcache) {
			$this->memcache->delete($this->prefix . $key);
		} elseif ((CACHE_DRIVER == 'xcache') && $this->isxcache) {	
			xcache_unset($this->prefix . $key);
		} elseif ((CACHE_DRIVER == 'redis') && $this->isredis) {	
			//$this->redis->delete($key);
		} else {
			$files = glob(DIR_CACHE . 'cache.' . $key . '.*');
			if ($files) {
				foreach ($files as $file) {
					if (file_exists($file)) {
						@unlink($file);
						clearstatcache();
					}
				}
			}
		}
	}
	
	public function flush() {
		if ((CACHE_DRIVER == 'memcached') && $this->ismemcache) {
			return	$this->memcache->flush();
		} elseif ((CACHE_DRIVER == 'xcache') && $this->isxcache) {
			if (function_exists('xcache_unset_by_prefix')) {
				xcache_unset_by_prefix($this->prefix);				
				return true;
			} else {
				xcache_clear_cache(XC_TYPE_VAR, -1);
				return true;
			}
		} elseif ((CACHE_DRIVER == 'redis') && $this->isredis) {
			$this->redis->select(REDIS_DATABASE);
			return $this->redis->flushDb();
		}
	}
	
}