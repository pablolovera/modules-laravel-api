<?php
namespace PabloLovera\ModulesLaravel\Commands;

use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class MyMigrator
{
    protected $module;

    /**
     * @var Filesystem
     */
    protected $files;
    /**
     * @var DatabaseMigrationRepository
     */
    protected $repository;
    /**
     * @var App
     */
    protected $app;

    /**
     * MyMigrator constructor.
     * @param $module
     * @param Filesystem $files
     * @param DatabaseMigrationRepository $repository
     * @param App $app
     * @internal param MigrationRepositoryInterface $migretionRepo
     */
    public function __construct($module, DatabaseMigrationRepository $repository)
    {
        $this->module = $module;
        $this->files = new Filesystem();
        $this->repository = $repository;
        $this->app = new App();
    }

    /**
     * Get migration path.
     *
     * @return string
     */
    public function getPath($module)
    {
        return config('module.modules_directory') . $module . '/Database/seeds/';
    }

    /**
     * Get migration files
     *
     * @param $module
     * @param bool $reverse
     * @return array|bool
     */
    private function getMigrations($module, $reverse = false)
    {
        $files   = $this->files->glob($this->getPath($module).'/*_*.php');

        if ($files === false)
            return [];

        $files = array_map(function ($file) {
            return str_replace('.php', '', basename($file));

        }, $files);

        sort($files);

        if ( $reverse )
            return array_reverse($files);

        return $files;
    }

    /**
     * Rollback migration.
     *
     * @return array
     */
    public function rollback()
    {
        $migrations = $this->getLast($this->getMigrations(true));

        $this->requireFiles($migrations->toArray());

        $migrated = [];

        foreach ($migrations as $migration) {
            $data = $this->find($migration);

            if ($data->count()) {
                $migrated[] = $migration;

                $this->down($migration);

                $data->delete();
            }
        }

        return $migrated;
    }

    /**
     * Reset migration.
     *
     * @return array
     */
    public function reset()
    {
        $migrations = $this->getMigrations($this->module, true);

        $migrated = [];

        foreach ( $migrations as $migration ) :

            $data = $this->find($migration);

            if ( $data->count() ) :

                $migrated[] = $migration;

                $this->down($migration);

                $data->delete();

            endif;

        endforeach;

        return $migrated;
    }

    /**
     * Run down schema from the given migration name.
     *
     * @param string $migration
     */
    public function down($migration)
    {
        $this->resolve($migration)->down();
    }

    /**
     * Run up schema from the given migration name.
     *
     * @param string $migration
     */
    public function up($migration)
    {
        $this->resolve($migration)->up();
    }

    /**
     * Resolve a migration instance from a file.
     *
     * @param string $file
     *
     * @return object
     */
    public function resolve($file)
    {
        $file = implode('_', array_slice(explode('_', $file), 4));

        $class = studly_case($file);

        return new $class();
    }

    /**
     * Require in all the migration files in a given path.
     *
     * @param array  $files
     */
    public function requireFiles(array $files)
    {
        $path = $this->getPath($this->module);

        foreach ($files as $file) {
            $this->app['files']->requireOnce($path.'/'.$file.'.php');
        }
    }

    /**
     * Get table instance.
     *
     * @return string
     */
    public function table()
    {
        return $this->app['db']->table('migrations');
    }

    /**
     * Find migration data from database by given migration name.
     *
     * @param string $migration
     *
     * @return object
     */
    public function find($migration)
    {
        return $this->table()->whereMigration($migration);
    }

    /**
     * Save new migration to database.
     *
     * @param string $migration
     *
     * @return mixed
     */
    public function log($migration)
    {
        return $this->table()->insert([
            'migration' => $migration,
            'batch' => $this->getNextBatchNumber(),
        ]);
    }

    /**
     * Get the next migration batch number.
     *
     * @return int
     */
    public function getNextBatchNumber()
    {
        return $this->getLastBatchNumber() + 1;
    }

    /**
     * Get the last migration batch number.
     *
     * @param array $migrations
     * @return int
     */
    public function getLastBatchNumber($migrations)
    {
        return $this->table()
            ->whereIn('migration', $migrations)
            ->max('batch');
    }

    /**
     * Get the last migration batch.
     *
     * @param array $migrations
     *
     * @return array
     */
    public function getLast($migrations)
    {
        $query = $this->table()
            ->where('batch', $this->getLastBatchNumber($migrations))
            ->whereIn('migration', $migrations)
        ;

        $result = $query->orderBy('migration', 'desc')->get();

        return collect($result)->map(function ($item) {
            return (array) $item;
        })->lists('migration');
    }

    /**
     * Get the ran migrations.
     *
     * @return array
     */
    public function getRan()
    {
        return $this->table()->lists('migration');
    }
}