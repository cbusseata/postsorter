<?php

namespace PostSorter\Infrastructure;

class FileHandlerFactory {

    public function __construct()
    {
    }


    /**
     * @param $filepath
     * @return AbstractFileHandler
     */
    public function getFileHandler( $filepath )
    {
        switch( pathinfo( $filepath, PATHINFO_EXTENSION ) ) {
            case 'csv':
                return new CSVHandler( $filepath, new \parseCSV() );

            case 'json':
                return new JSONHandler( $filepath );
        }

        throw new \RuntimeException( 'Cannot instantiate file handler for this file type' );
    }

}
