<?php

namespace PostSorter\Test\Infrastructure;

use PostSorter\Infrastructure\JSONHandler;

class JSONHandlerTest extends \PHPUnit_Framework_TestCase {

    private $test_read_filepath = __DIR__ . '/test_read.json';
    private $test_write_filepath = __DIR__ . '/test_write.json';

    private $test_write_data = [
        [
            'name' => 'Bruce Wayne',
            'occupation' => 'Batman'
        ],
        [
            'name' => 'Jens Kidman',
            'occupation' => 'Vocalist'
        ],
    ];


    /**
     * Not strictly necessary for every test, but a bit cleaner than explicitly calling it
     *  from most of the test methods.
     */
    protected function setUp()
    {
        if ( file_exists( $this->test_write_filepath ) ) {
            unlink( $this->test_write_filepath );
        }

        $fh = fopen( $this->test_write_filepath, 'w' ) or die( "Can't create file" );
    }


    /**
     * Also not strictly necessary for every test, but a bit cleaner than explicitly calling it
     *  from most of the test methods.
     */
    protected function tearDown()
    {
        unlink( $this->test_write_filepath );
    }

    // --------------------------------------------------------------------------------------------
    // Tests

    /**
     * Test that data is properly loaded from a file to an array structure.
     */
    public function testLoadingCSVData()
    {
        $handler = new JSONHandler( $this->test_read_filepath );

        $this->assertEquals(
            [
                [
                    'id' => '1',
                    'name' => 'busse, colin',
                    'favorite food' => 'sushi'
                ],
                [
                    'id' => '2',
                    'name' => 'bob',
                    'favorite food' => 'pumpkin pie'
                ],
                [
                    'id' => '3',
                    'name' => 'maggie',
                    'favorite food' => '"fine" cuisine'
                ]
            ],
            $handler->loadData()
        );
    }


    /**
     * Test that an array structure will be written with headers when
     *  saving to an empty file.
     */
    public function testSaveDataToEmptyFile()
    {
        $handler = new JSONHandler( $this->test_write_filepath );

        $handler->writeData( $this->test_write_data );

        $expectedContents = <<<TEXT
[
    {
        "name": "Bruce Wayne",
        "occupation": "Batman"
    },
    {
        "name": "Jens Kidman",
        "occupation": "Vocalist"
    }
]
TEXT;

        $this->assertEquals( $expectedContents, file_get_contents( $this->test_write_filepath ) );
    }

}
