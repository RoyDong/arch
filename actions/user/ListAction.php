<?php

class ListAction extends Action
{

    public function execute()
    {

        $user = Model::getInstance( 'user' );

        var_dump( $user->fetchAll( '1=1') );

    }

}
