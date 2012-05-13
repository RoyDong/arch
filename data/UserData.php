<?php
/**
 * @author Roy 
 */

class UserData extends Data{

	protected function __construct(){
		$this->tableName = 'user';
	}

    public function readWeiboList( $userId ){
        $sql = 'select a.updated_at bind_at , b.* from '.
                $this->tableName( 'user_oauth_token' ) . ' as a inner join '.
                $this->tableName( 'oauth_token' ) . ' as b on a.`oauth_token_id`='.
                'b.`id` where a.`user_id`="' . $userId . '" order by '.
                'a.created_at desc limit 50';

        return $this->exec( $sql );
    }
}