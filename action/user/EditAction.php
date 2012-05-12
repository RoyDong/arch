<?php
/**
 * @authro Roy
 */


class EditAction extends Action{

    public function execute(){
        $user = new User( $this->get( 'id' ) );
        $this->layout = false;
        $this->render( 'user/edit'  , array( 'user' => $user ) );
    }
}