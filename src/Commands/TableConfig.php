<?php

namespace Kluverp\Pcmn\Commands;

use Illuminate\Console\Command;
use DB;

class TableConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pcmn:table {table?} {--force : overwrite config file when it already exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genereate a table config file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // first get table name, either from command line, or let user choose from list
        if (!$table = $this->argument('table')) {
            $table = $this->promptForTable();
        }

        $filename = $table . '.php';

        // check if file already exists, and abort if so and forced option is false
        if (is_file($this->filePath($filename)) && !$this->option('force')) {
            $this->warn('File already exists, aborting!');
            return false;
        }

        // generate the file
        $content = $this->generateFile($table);

        // write file
        file_put_contents($this->filePath($filename), $content);

        $this->info('File "' . $this->filePath($filename) . '"" written!');
    }

    /**
     * Generates the config file PHP code.
     *
     * @param $table
     * @return string
     */
    private function generateFile($table)
    {
        $str = sprintf("
<?php

return [
    'title' => [
        'plural'   => '%s',
        'singular' => '%s'
    ],
    'description' => '%s',
    'permissions' => [
        'create' => false,
        'read'   => false,
        'update' => false,
        'delete' => false,
    ],
    'index' => [],
    'fields' => [%s
    ]
];
", $table, $table, $table, self::getFieldsStr($table));

        return $str;
    }

    /**
     * Returns the fields array as a string of PHP code.
     *
     * @param $table
     * @return string
     */
    private static function getFieldsStr($table)
    {
        $fields = '';

        foreach (self::getAllColumns($table) as $column) {
            $fields .= sprintf("    
        '%s' => [
            'type'  => 'input',
            'label' => '%s'
        ],", $column, $column);

        }

        return $fields;
    }

    /**
     * Returns the path to the config file.
     *
     * @param $filename
     * @return string
     */
    private function filePath($filename)
    {
        return config_path('pcmn/tables/' . $filename);
    }


    /**
     * Prompt the user for a table by listing all available tables in database.
     *
     * @return mixed
     */
    private function promptForTable()
    {
        $i = 1;
        $tables = $this->getAllTables();
        foreach ($tables as $table) {
            $this->info($i . ') ' . $table);
            $i++;
        }

        // get table from user input
        $table = $this->ask('Choose table you wish to generate config file for');

        return $tables[$table - 1];
    }

    /**
     * Returns array with all table names.
     *
     * @return array
     */
    private function getAllTables()
    {
        $tables = [];

        foreach (DB::select('SHOW TABLES') as $table) {
            $tables[] = $table->{'Tables_in_' . DB::getDatabaseName()};
        }

        return $tables;
    }

    /**
     * Returns all columns for given table name.
     *
     * @param $table
     * @return array
     */
    private static function getAllColumns($table)
    {
        $cols = [];

        foreach (DB::select('SHOW COLUMNS FROM ' . $table) as $col) {
            $cols[] = $col->{'Field'};
        }

        return $cols;
    }
}
