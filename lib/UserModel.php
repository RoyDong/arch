<?php

class UserModel extends Model
{
	protected function __construct()
	{
		$this->namespace = 'user';
	}

	public function add( $data )
	{
		$userId = $this->insert( $data );

		return $userId;
	}


	public function getById( $userId )
	{
        $data = $this->select( '`id`=' . $userId );
        $this->cache()->hMset( $this->cacheKey( $data['id'] ) , $data );
		return $data;
	}

	public function getByEmail( $email )
	{
		return $this->select( "`email`='{$email}'" );
	}
}
