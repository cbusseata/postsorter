<?php

namespace PostSorter\Infrastructure;

use KzykHys\CsvParser\CsvParser;

/**
 * Class CSVHandler
 *
 * @TODO: Note that this class assumes a header in the csv, this should be a configuration option if needed later
 */
class CSVHandler extends AbstractFileHandler {

    private $parser;

    /**
     * CSVHandler constructor.
     *
     * @param string $filepath
     * @param \parseCSV $parser             Parser object for writing csv data to file
     * @throws \InvalidArgumentException
     */
    public function __construct( $filepath, \parseCSV $parser )
    {
        parent::__construct( $filepath );

        $this->parser = $parser;
    }


    /**
     * Loads an array of data from a file.
     *
     * @return array
     */
    public function loadData(): array
    {
        /**
         * This is a violation of dependency injection, but it seems preferable to accepting
         *  a filepath as a constructor argument as well as a CsvParser object configured to
         *  read from the same file.
         */
        $parser = CsvParser::fromFile( $this->filepath, [ 'encoding' => 'UTF-8' ] );
        $parsedRows = $parser->parse();

        $ret = [];
        for ( $i = 1; $i < count( $parsedRows ); $i++ ) {
            $ret[] = array_combine( $parsedRows[ 0 ], $parsedRows[ $i ] );
        }

        return $ret;
    }


    /**
     * Writes an array of data to a file.  The file will be overwritten if it is not empty.
     *
     * @param array $data
     */
    public function writeData( array $data )
    {
        $this->parser->linefeed = "\n";

        $this->parser->save( $this->filepath, $data, false, array_keys( $data[ 0 ] ) );
    }

}
