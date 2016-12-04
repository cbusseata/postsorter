<?php

namespace PostSorter\Domain;

/**
 * Sorts posts into 3 categories:
 *  1. Top Posts - according to the validator configuration
 *  2. Other Posts - any posts that are not a top post
 *  3. Daily Top Posts - the single highest scoring top post of each day, based on likes
 */
class PostSorter {

    private $topPostValidator;

    private $topPosts = [];
    private $otherPosts = [];
    private $dailyTopPosts = [];

    /**
     * PostSorter constructor.
     * @param TopPostValidator $topPostValidator
     */
    public function __construct( TopPostValidator $topPostValidator )
    {
        $this->topPostValidator = $topPostValidator;
    }


    /**
     * @param array $posts
     */
    public function sortPosts( array $posts )
    {
        $dailyTopPosts = [];
        for ( $cv = 0; $cv < count( $posts ); $cv++ ) {
            if ( $this->topPostValidator->isTopPost( $posts[ $cv ] ) ) {
                $this->topPosts[] = $posts[ $cv ];

                $postDateStr = $posts[ $cv ]->getTimestamp()->format( 'Y-m-d' );
                if (
                    !array_key_exists( $postDateStr, $dailyTopPosts ) ||
                    $posts[ $cv ]->getLikes() > $dailyTopPosts[ $postDateStr ]->getLikes()
                ) {
                    $dailyTopPosts[ $postDateStr ] = $posts[ $cv ];
                }
            } else {
                $this->otherPosts[] = $posts[ $cv ];
            }
        }

        $this->dailyTopPosts = array_values( $dailyTopPosts );
    }


    /**
     * @return array
     */
    public function getTopPosts(): array
    {
        return $this->topPosts;
    }


    /**
     * @return array
     */
    public function getOtherPosts(): array
    {
        return $this->otherPosts;
    }


    /**
     * @return array
     */
    public function getDailyTopPosts(): array
    {
        return $this->dailyTopPosts;
    }

}
