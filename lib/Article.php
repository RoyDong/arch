<?php
/**
 * article 
 * @author Roy
 */

class Article
{


    protected static $pool = array();

    protected $data = array();

    protected $writable = array( 'title' , 'content' , 'description' );

    public function __construct( $id = 0 )
    {
        if( $id > 0 )
        {
            $this->data = Model::getInstance( 'Article' )->fetch( "`id`='$id'" );
        }
    }

    public function __get( $name )
    {
        if( isset( $this->data[ $name ] ) )
        {
            return $this->data[ $name ];
        }
    }

    public function __set( $name , $value )
    {
        if( in_array( $name , $this->writable ) )
        {
            $this->data[ $name ] = addslashes( $value );
        }
    }

    public static function find()
    {
        return Model::getInstance( 'Article' )->fetchAll( '1=1' , 'order by updated_at desc' , 'limit 0,10' );

    }

    public function save()
    {
        $this->data['created_at'] = $this->data['updated_at'] = $_SERVER['REQUEST_TIME'];

        if( empty( $this->data['title'] ) )
        {
            throw new ArticleException( t( 'title is missing' ) , 51 );
        }

        if( empty( $this->data['content'] ) )
        {
            throw new ArticleException( t( 'content is missing' ) , 52 );
        }

        $article = Model::getInstance( 'Article' );

        if( empty( $this->data['id'] ) )
        {
            $this->data['user_id'] = Session::getInstance()->user['userId'];
            $result = $article->insert( $this->data );
            $this->data['id'] = $result;
        }
        else
        {
            $result = $article->update( $this->data , "`id`='{$this->data['id']}'" );
        }

        if( $result < 1 )
        {
            throw new ArticleException( t( 'save to sql failuer' ) , 53 );
        }
    }
}

class ArticleException extends Exception
{
	
}