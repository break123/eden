<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/session/error.php';

/**
 * General available methods for common 
 * server session procedures.
 *
 * @package    Eden
 * @subpackage session
 * @category   tool
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: session.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Session extends Eden_Class implements ArrayAccess, Iterator {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_session = false;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __toString() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
		return '<pre>'.print_r($_SESSION, true).'</pre>';
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Starts a session
	 *
	 * @return bool
	 */
	public function start() {
		//start the session
		self::$_session = session_start();
		
		return self::$_session;
	}
	
	/**
	 * Starts a session
	 *
	 * @return Eden_SessionServer
	 */
	public function stop() {
		self::$_session = false;
		session_write_close();
		return $this;
	}
	
	/**
	 * Sets data
	 *
	 * @param array|string
	 * @param mixed
	 * @return this
	 */
	public function setData($data, $value = NULL) {
		Eden_Error_Validate::get()->argument(0, 'array', 'string');
		
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
		if(is_array($data)) {
			$_SESSION = $data;
			return $this;
		}
		
		$_SESSION[$data] = $value;
		
		return $this;
	}
	
	/**
	 * Returns data
	 *
	 * @param string|null
	 * @return mixed
	 */
	public function getData($key = NULL) {
		Eden_Error_Validate::get()->argument(0, 'string', 'null');
		
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
		if(is_null($key)) {
			return $_SESSION;
		}
		
		return $_SESSION[$key];
	}
	
	/**
	 * Returns session id
	 * 
	 * @return int
	 */
	public function getId() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
		return session_id();
	}
	
	/**
	 * Sets the session ID
	 *
	 * @param *int
	 * @return int
	 */
	public function setId($sid) {
		Eden_Error_Validate::get()->argument(0, 'number');
		
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
		return session_id((int) $sid);
	}
	
	/**
	 * Removes all session data
	 *
	 * @return bool
	 */
	public function clear() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
		$_SESSION = array();
		
		return $this;
	}
	
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        reset($_SESSION);
    }

	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        return current($_SESSION);
    }

	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        return key($_SESSION);
    }

	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        next($_SESSION);
    }

	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        return isset($_SESSION[$this->key()]);
   }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        if (is_null($offset)) {
            $_SESSION[] = $value;
        } else {
            $_SESSION[$offset] = $value;
        }
    }
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        return isset($_SESSION[$offset]);
    }
    
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        unset($_SESSION[$offset]);
    }
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
		if(!self::$_session) {
			throw new Eden_Session_Error(self::NOT_STARTED);
		}
		
        return isset($_SESSION[$offset]) ? $_SESSION[$offset] : NULL;
    }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}