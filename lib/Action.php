<?php
namespace lib;

class Action extends \core\Action {
    
    protected function auth(){
        if(!isset( $_SESSION['user'] ))
            $this->redirect('');
    }
}