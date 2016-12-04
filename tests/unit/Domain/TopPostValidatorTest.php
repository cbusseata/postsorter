<?php

namespace PostSorter\Test\Domain;

use PostSorter\Domain\TopPostValidator;

class TopPostValidatorTest extends \PHPUnit_Framework_TestCase {

    private $validator;

    public function setUp()
    {
        $this->validator = new TopPostValidator( 'public', 11, 9001, 39 );
    }


    /**
     * @param string $privacy       Privacy for mocked Post
     * @param int $comments         Number of comments for mocked Post
     * @param int $views            Number of views for mocked Post
     * @param string $title         Title of mocked Post
     * @dataProvider testTopPostValidationDataProvider
     */
    public function testTopPostValidation( string $privacy, int $comments, int $views, string $title, bool $expectedIsTopPost )
    {
        $post = $this->createMock( '\PostSorter\Domain\Post' );
        $post->method( 'getPrivacy' )->willReturn( $privacy );
        $post->method( 'getComments' )->willReturn( $comments );
        $post->method( 'getViews' )->willReturn( $views );
        $post->method( 'getTitle' )->willReturn( $title );

        $this->assertEquals(
            $expectedIsTopPost,
            $this->validator->isTopPost( $post )
        );
    }

    // --------------------------------------------------------------------------------------

    public function testTopPostValidationDataProvider(): array
    {
        return [
            // Case satisfies all conditions of a top post
            [ 'public',  12, 10000, 'post title', true ],

            // Private post means not a top post
            [ 'private', 12, 10000, 'post title', false ],

            // Too few comments to be a top post
            [ 'public',   5, 10000, 'post title', false ],

            // Not enough views to be a top post
            [ 'public',  12,  9000, 'post title', false ],

            // Post title being too long means not a top post
            [ 'public',  10,   100, 'post title is far to long to ever be a top post title', false ],
        ];
    }
}
