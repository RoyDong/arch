<?php
/**
 * @author Roy
 * 
 */

class Applicant
{
    
    private $data = array();

    private $applicantModel;

    public function __construct()
    {
        $this->applicantModel = Model::getInstance( 'Applicant' );
    }

    public function setEmail( $email )
    {
        if( $this->applicantModel->isExist( 'email' , $email ) )
        {
            throw new ApplicantException( t( 'email exists' ) , 30 );
        }

        $this->data['email'] = $email;
    }

    public function setPassword( $password )
    {
        $salt = uniqid( '' , true );
        $this->data['password'] = $this->hashPassword( $password , $salt );
        $this->data['salt'] = $salt;
    }

    public function save()
    {
        $this->data['created_at'] = $_SERVER['REQUEST_TIME'];
        $id = $this->applicantModel->insert( $this->data );

        if( $id < 1 )
        {
            throw new ApplicantException( t( 'save to sql failuer' ) , 31 );
        }

        $this->data['id'] = $id;
    }

    private function hashPassword( $password , $salt )
    {
        return sha1( $salt . $password );
    }
}

class ApplicantException extends Exception
{

}
