<?php

namespace PostSorter\Infrastructure;

abstract class AbstractFileHandler {

    protected $filepath;

    /**
     * CSVHandler constructor.
     *
     * @param string $filepath
     * @throws \InvalidArgumentException
     */
    public function __construct( $filepath )
    {
        if ( !file_exists( $filepath ) ) {
            throw new \InvalidArgumentException( sprintf( 'File %s does not exist!', $filepath ) );
        }

        $this->filepath = $filepath;
    }


    /**
     * Loads an array of data from a file.
     *
     * @return array
     */
    abstract public function loadData(): array;


    /**
     * Writes an array of data to a file.  The file will be overwritten if it is not empty.

     *
     * @param array $data
     */
    abstract public function writeData( array $data );

}
