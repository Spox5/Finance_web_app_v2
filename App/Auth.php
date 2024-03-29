<?php

namespace App;

use App\Models\User;
use App\Models\RememberedLogin;

class Auth
{
	public static function login($user, $remember_me)
	{
		session_regenerate_id(true);
			
		$_SESSION['user_id'] = $user->id;
		
		if ($remember_me) {
			
			if ($user->rememberLogin()) {
				
				setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');
			}
		}
	}
	
	public static function logout()
	{
		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			
			setcookie(
				session_name(), 
				'', 
				time() - 42000,
				$params["path"], 
				$params["domain"],
				$params["secure"], 
				$params["httponly"]
			);
		}

		// Finally, destroy the session.
		session_destroy();
		
		static::forgetLogin();
	}
	
	//remember the page that user want to go if not login - is it necessary?
	public static function rememberRequestedPage()
	{
		$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
	}
	
	//next step upper function
	public static function getReturnPage()
	{
		return $_SESSION['return_to'] ?? '/';
	}
	
	//get the current logged in user from session (to f. ex. display name or get his data form db) - do same function as previous isLoggedIn function
	public static function getUser()
	{
		if (isset($_SESSION['user_id'])) {
			
			return User::findByID($_SESSION['user_id']);
			
		} else {
		
			return static::loginFromRememberCookie();
		
		}
	}
	
	protected static function loginFromRememberCookie()
	{
		$cookie = $_COOKIE['remember_me'] ?? false;
		
		if ($cookie) {
				
			$remembered_login = RememberedLogin::findByToken($cookie);
			
			if ($remembered_login && !$remembered_login->hasExpired()) {
				
					$user = $remembered_login->getUser();
					
					static::login($user, false);
					
					return $user;
				
			}
		}
	}
	
	protected static function forgetLogin()
	{
		$cookie = $_COOKIE['remember_me'] ?? false;
		
		if ($cookie) {
			
			$remembered_login = RememberedLogin::findByToken($cookie);
			
			if ($remembered_login) {
				
				$remembered_login->delete();
			}
			
			setcookie('remember_me', '', time() - 3600);//set  to expire in the past
		}
	}
		
}