<?php
/**
 * @author Roy 
 */

class OAuthTokenData extends Data{

	protected function __construct(){
		$this->tableName = 'oauth_token';
	}

}