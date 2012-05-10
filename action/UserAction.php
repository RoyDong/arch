<?php
class UserAction extends Action
{
    public function execute()
    {
        $db = c( 'db' );
        var_dump( $db );
        $pdo = new PDO( $db['dsn'] , $db['username'] , $db['password'] );
        var_dump( $pdo );
    }
}
