<?php

namespace PostSorter\Test\Infrastructure;

use PostSorter\Infrastructure\CSVHandler;

class CSVHandlerTest extends \PHPUnit_Framework_TestCase {

    private $test_read_filepath = __DIR__ . '/test_read.csv';
    private $test_write_filepath = __DIR__ . '/test_write.csv';

    private $test_write_data = [
        [
            'name' => 'Oliver Queen',
            'occupation' => 'Green Arrow'
        ],
        [
            'name' => 'Stephen Rogers',
            'occupation' => 'Captain America, and associate at "The Avengers"'
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
        $handler = new CSVHandler( $this->test_read_filepath, new \parseCSV() );

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
        $handler = new CSVHandler( $this->test_write_filepath, new \parseCSV() );

        $handler->writeData( $this->test_write_data );

        $expectedContents = <<<TEXT
name,occupation
Oliver Queen,Green Arrow
Stephen Rogers,"Captain America, and associate at ""The Avengers"""

TEXT;

        $this->assertEquals( $expectedContents, file_get_contents( $this->test_write_filepath ) );
    }


    /**
     * Test that an array structure will be written with headers when
     *  saving, overwriting the file when not empty.
     */
    public function testSaveDataToNotEmptyFile()
    {
        $writeContents = <<<TEXT
name,occupation
Louis CK,Comedian

TEXT;
        file_put_contents( $this->test_write_filepath, $writeContents );


        $handler = new CSVHandler( $this->test_write_filepath, new \parseCSV() );

        $handler->writeData( $this->test_write_data );

        $expectedContents = <<<TEXT
name,occupation
Oliver Queen,Green Arrow
Stephen Rogers,"Captain America, and associate at ""The Avengers"""

TEXT;

        $this->assertEquals( $expectedContents, file_get_contents( $this->test_write_filepath ) );
    }

}
