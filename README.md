# Post Sorter

Clone the repo, then install dependencies:

````bash
composer install
````
Or, if you intend to run the tests
````bash
composer install --dev
````

Example usage:
````bash
bin/postsorter --inputFile="posts.csv" --outputFormat="json" --detailed
````

Output files will be written to the 'output' directory: top_posts.csv, daily_top_posts.csv, other_posts.csv (or .json, depending on the --outputFormat CLI option).

NOTE: you may need to grant execute permissions to the bin/postsorter script.

The --inputFile option will accept any absolute or relative filepath.  This option is required.

The --outputFormat option will accept 'json' or 'csv' (the default value is 'csv').

Without --detailed, only ids will be written to the output files.

To run tests:
````bash
vendor/bin/phpunit -c tests/phpunit.xml
````
