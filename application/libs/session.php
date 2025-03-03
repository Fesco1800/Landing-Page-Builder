<?php

class Session
{
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public static function get($key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	public static function hasSet($key) {
		return isset($_SESSION[$key]);
	}

	public static function destroy($keys = []) {
		if ($keys) {
			foreach ($keys as $k) {
				unset($_SESSION[$k]);
			}
		} else {
			$_SESSION = []; # unset all of the session variables
			session_destroy();
		}
	}
}