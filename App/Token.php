<?php

namespace App;

//generate token to hide cookies symbol in db
class Token
{
	protected $token;
	
	//generate random string
	public function __construct($token_value = null)
	{
		if ($token_value) {
		
			$this->token = $token_value;
		} else {
		
			$this->token = bin2hex(random_bytes(16));
		}
	}
	
	public function getValue()
	{
		return $this->token;
	}
	
	public function getHash()
	{
		return hash_hmac('sha256', $this->token, \App\Config::SECRET_KEY); //sha256 = 64 chars
	}
}