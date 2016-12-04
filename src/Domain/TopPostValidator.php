<?php

namespace PostSorter\Domain;

class TopPostValidator {

    private $privacy;
    private $minComments;
    private $minViews;
    private $maxTitleLength;

    /**
     * TopPostValidator constructor.
     *
     * @param string $privacy
     * @param int $minComments
     * @param int $minViews
     * @param int $maxTitleLength
     */
    public function __construct( string $privacy, int $minComments, int $minViews, int $maxTitleLength )
    {
        // Validate integer fields
        if ( !is_string( $privacy ) ) {
            throw new \InvalidArgumentException( 'Invalid privacy setting' );
        }

        // Validate int fields
        foreach ( [ $minComments, $minViews, $maxTitleLength ] as $intParam ) {
            if ( filter_var( $intParam, FILTER_VALIDATE_INT, [ 'options' => [ 'min_range' => 0 ] ] ) === false ) {
                throw new \InvalidArgumentException( 'Invalid count setting' );
            }
        }

        $this->privacy = $privacy;
        $this->minComments = $minComments;
        $this->minViews = $minViews;
        $this->maxTitleLength = $maxTitleLength;
    }


    /**
     * @param \PostSorter\Domain\Post $post
     * @return bool
     */
    public function isTopPost( Post $post )
    {
        if ( $post->getPrivacy() != $this->privacy ) {
            return false;
        }

        if ( $post->getComments() < $this->minComments ) {
            return false;
        }

        if ( $post->getViews() < $this->minViews ) {
            return false;
        }

        if ( strlen( $post->getTitle() ) > $this->maxTitleLength ) {
            return false;
        }

        return true;
    }

}
