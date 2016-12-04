<?php

namespace PostSorter\Infrastructure;

class JSONHandler extends AbstractFileHandler {

    /**
     * Loads an array of data from a file.
     *
     * @return array
     */
    public function loadData(): array
    {
        return json_decode( file_get_contents( $this->filepath ), true );
    }


    /**
     * Writes an array of data to a file.  The file will be overwritten if it is not empty.
     *
     * @param array $data
     */
    public function writeData( array $data )
    {
        file_put_contents( $this->filepath, json_encode( $data, JSON_PRETTY_PRINT ) );
    }

}
