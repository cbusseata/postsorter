<?php

namespace PostSorter\Test\Domain;

use PostSorter\Domain\PostSorter;

class PostSorterTest extends \PHPUnit_Framework_TestCase {

    /**
     * Mock a validator that will always return true.  Whatever post we give it should end up in
     *  top posts.  Other posts should also be blank.  Since we have supplied only 1 top post, that
     *  post should be in daily top posts as well.
     */
    public function testTopPostSorting()
    {
        $validator = $this->createMock( '\PostSorter\Domain\TopPostValidator' );
        $validator->method( 'isTopPost' )->willReturn( true )->withAnyParameters();

        $post = $this->createMock( '\PostSorter\Domain\Post' );
        $post->method( 'getLikes' )->willReturn( 1 );
        $post->method( 'getTimestamp' )->willReturn( new \DateTime( '2016-12-01 00:00:00' ) );

        $sorter = new PostSorter( $validator );
        $sorter->sortPosts([ $post ]);

        $this->assertEquals( [ $post ], $sorter->getTopPosts() );
        $this->assertEquals( [ $post ], $sorter->getDailyTopPosts() );
        $this->assertEquals( [], $sorter->getOtherPosts() );
    }


    /**
     * Mock a validator that will always return true.  Everything we pass will be a top post.
     *  Here we give it mocked posts with differing numbers of likes and the same date, in order
     *  to ensure that the daily top post sorting functions.
     */
    public function testDailyTopPostSorting()
    {
        $validator = $this->createMock( '\PostSorter\Domain\TopPostValidator' );
        $validator->method( 'isTopPost' )->willReturn( true )->withAnyParameters();

        // Create posts with the same date with different numbers of likes
        $post1 = $this->createMock( '\PostSorter\Domain\Post' );
        $post1->method( 'getLikes' )->willReturn( 1 );
        $post1->method( 'getTimestamp' )->willReturn( new \DateTime( '2016-12-01 00:00:00' ) );

        $post2 = $this->createMock( '\PostSorter\Domain\Post' );
        $post2->method( 'getLikes' )->willReturn( 2 );
        $post2->method( 'getTimestamp' )->willReturn( new \DateTime( '2016-12-01 00:00:00' ) );

        // Create one more with a different date
        $post3 = $this->createMock( '\PostSorter\Domain\Post' );
        $post3->method( 'getLikes' )->willReturn( 1 );
        $post3->method( 'getTimestamp' )->willReturn( new \DateTime( '2016-12-02 00:00:00' ) );

        $sorter = new PostSorter( $validator );
        $sorter->sortPosts([ $post1, $post2, $post3 ]);

        $this->assertEquals( [ $post1, $post2, $post3 ], $sorter->getTopPosts() );
        $this->assertEquals( [ $post2, $post3 ], $sorter->getDailyTopPosts() );
    }


    /**
     * Mock a validator that will always return false.  Whatever post we give it should end up in
     *  other posts.  Top posts and daily top posts should be empty.
     */
    public function testOtherPostSorting()
    {
        $validator = $this->createMock( '\PostSorter\Domain\TopPostValidator' );
        $validator->method( 'isTopPost' )->willReturn( false )->withAnyParameters();

        $post = $this->createMock( '\PostSorter\Domain\Post' );
        $post->method( 'getLikes' )->willReturn( 1 );
        $post->method( 'getTimestamp' )->willReturn( new \DateTime( '2016-12-01 00:00:00' ) );

        $sorter = new PostSorter( $validator );
        $sorter->sortPosts([ $post ]);

        $this->assertEquals( [], $sorter->getTopPosts() );
        $this->assertEquals( [], $sorter->getDailyTopPosts() );
        $this->assertEquals( [ $post ], $sorter->getOtherPosts() );
    }

}
