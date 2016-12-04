<?php

namespace PostSorter\Test\Domain;

use PostSorter\Domain\Post;

class PostTest extends \PHPUnit_Framework_TestCase {

    private $testParams = [
        Post::ID => 1,
        Post::TITLE => 'test title',
        Post::PRIVACY => 'private',
        Post::LIKES => 1,
        Post::VIEWS => 100,
        Post::COMMENTS => 10,
        Post::TIMESTAMP => '2016-12-03 12:00:00'
    ];

    private $testTimestampStr = '2016-12-03 12:00:00';

    // ------------------------------------------------------------------------

    public function testThatAllRequiredParamsMustBePresent()
    {
        $this->setExpectedException( 'InvalidArgumentException' );

        $post = new Post([
            Post::ID => 1,
            Post::TITLE => 'test title',
            Post::PRIVACY => 'private',
            Post::LIKES => 1,
            Post::VIEWS => 100,
            Post::COMMENTS => 10,
        ]);
    }


    public function testThatLikesMustBeIntegral()
    {
        $this->setExpectedException( 'InvalidArgumentException' );

        $post = new Post([
            Post::ID => 1,
            Post::TITLE => 'test title',
            Post::PRIVACY => 'private',
            Post::LIKES => 'alot',
            Post::VIEWS => 100,
            Post::COMMENTS => 10,
            Post::TIMESTAMP => '2016-12-03 12:00:00'
        ]);
    }


    public function testThatViewsMustBeIntegral()
    {
        $this->setExpectedException( 'InvalidArgumentException' );

        $post = new Post([
            Post::ID => 1,
            Post::TITLE => 'test title',
            Post::PRIVACY => 'public',
            Post::LIKES => 10,
            Post::VIEWS => 'pineapple',
            Post::COMMENTS => 10,
            Post::TIMESTAMP => '2016-12-03 12:00:00'
        ]);
    }


    public function testThatCommentsMustBeIntegral()
    {
        $this->setExpectedException( 'InvalidArgumentException' );

        $post = new Post([
            Post::ID => 1,
            Post::TITLE => 'test title',
            Post::PRIVACY => 'public',
            Post::LIKES => 10,
            Post::VIEWS => 100,
            Post::COMMENTS => 'bacon',
            Post::TIMESTAMP => '2016-12-03 12:00:00'
        ]);
    }


    public function testThatTimestampMustBeValid()
    {
        $this->setExpectedException( 'InvalidArgumentException' );

        $post = new Post([
            Post::ID => 1,
            Post::TITLE => 'test title',
            Post::PRIVACY => 'public',
            Post::LIKES => 10,
            Post::VIEWS => 100,
            Post::COMMENTS => 0,
            Post::TIMESTAMP => 'invalid timestamp'
        ]);
    }


    public function testGetters()
    {
        $post = new Post( $this->testParams );

        $this->assertEquals( $this->testParams[ Post::ID ], $post->getID() );
        $this->assertEquals( $this->testParams[ Post::TITLE ], $post->getTitle() );
        $this->assertEquals( $this->testParams[ Post::PRIVACY ], $post->getPrivacy() );
        $this->assertEquals( $this->testParams[ Post::LIKES ], $post->getLikes() );
        $this->assertEquals( $this->testParams[ Post::VIEWS ], $post->getViews() );
        $this->assertEquals( $this->testParams[ Post::COMMENTS ], $post->getComments() );
        $this->assertEquals( new \DateTime( $this->testTimestampStr ), $post->getTimestamp() );
        $this->assertEquals( $this->testParams, $post->allParams() );
    }

}
