<?php

namespace PostSorter\Domain;

/**
 * Post value-object class
 */
class Post {

    const ID = 'id';
    const TITLE = 'title';
    const PRIVACY = 'privacy';
    const LIKES = 'likes';
    const VIEWS = 'views';
    const COMMENTS = 'comments';
    const TIMESTAMP = 'timestamp';

    private static $requiredParams = [
        self::ID, self::TITLE, self::PRIVACY, self::LIKES, self::VIEWS, self::COMMENTS, self::TIMESTAMP
    ];

    private static $intParams = [
        self::LIKES, self::VIEWS, self::COMMENTS
    ];

    private static $stringParams = [
        self::TIMESTAMP
    ];

    private $postData;
    private $timestamp;

    /**
     * Post constructor.
     * @param array $postData
     */
    public function __construct( array $postData )
    {
        if ( !self::isValidPostData( $postData ) ) {
            throw new \InvalidArgumentException( 'Invalid post data' );
        }

        $this->postData = $postData;

        $this->timestamp = new \DateTime( $this->postData[ self::TIMESTAMP ] );
    }


    /**
     * @param array $postData
     * @return bool
     */
    private static function isValidPostData( array $postData ): bool
    {
        // Ensure required fields are present
        foreach ( self::$requiredParams as $requiredParam ) {
            if ( !isset( $postData[ $requiredParam ] ) ) {
                return false;
            }
        }

        // Validate integer fields
        foreach ( self::$intParams as $intParam ) {
            if ( filter_var( $postData[ $intParam ], FILTER_VALIDATE_INT, [ 'options' => [ 'min_range' => 0 ] ] ) === false ) {
                return false;
            }
        }

        // Validate string fields
        foreach ( self::$stringParams as $stringParam ) {
            if ( !is_string( $postData[ $stringParam ] ) ) {
                return false;
            }
        }

        // Validate the timestamp
        try {
            $date = new \DateTime( $postData[ self::TIMESTAMP ] );
        } catch ( \Exception $e ) {
            return false;
        }

        return true;
    }


    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->postData[ self::ID ];
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->postData[ self::TITLE ];
    }


    /**
     * @return mixed
     */
    public function getPrivacy()
    {
        return $this->postData[ self::PRIVACY ];
    }


    /**
     * @return int
     */
    public function getLikes(): int
    {
        return (int)$this->postData[ self::LIKES ];
    }


    /**
     * @return int
     */
    public function getViews(): int
    {
        return (int)$this->postData[ self::VIEWS ];
    }


    /**
     * @return int
     */
    public function getComments(): int
    {
        return (int)$this->postData[ self::COMMENTS ];
    }


    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }


    /**
     * @return array
     */
    public function allParams(): array
    {
        return $this->postData;
    }

}
