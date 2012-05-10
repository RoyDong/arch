<?php

class RegisterAction extends Action
{


    public function filter()
    {


    }

    public function execute()
    {
        $applicant = new Applicant;
        $applicant->setEmail( $this->get( 0 ) );
        $applicant->setPassword( $this->get( 1 ) );
        $applicant->save();
    }
}
