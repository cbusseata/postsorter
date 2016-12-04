<?php

namespace PostSorter\Test\Infrastructure;

use PostSorter\Infrastructure\CSVHandler;
use PostSorter\Infrastructure\JSONHandler;
use PostSorter\Infrastructure\FileHandlerFactory;

class FileHandlerFactoryTest extends \PHPUnit_Framework_TestCase {

    private $factory;


    protected function setUp()
    {
        $this->factory = new FileHandlerFactory();
    }


    public function testInstantiatingCSVHandler()
    {
        $this->assertInstanceOf(
            CSVHandler::class,
            $this->factory->getFileHandler( __DIR__ . '/test_read.csv' )
        );
    }


    public function testInstantiatingJSONHandler()
    {
        $this->assertInstanceOf(
            JSONHandler::class,
            $this->factory->getFileHandler( __DIR__ . '/test_read.json' )
        );
    }


    public function testAnExceptionIsThrownWhenCannotFindAHandler()
    {
        $this->setExpectedException( 'RuntimeException' );

        $this->factory->getFileHandler( __DIR__ . '/test_invalid.txt' );
    }

}