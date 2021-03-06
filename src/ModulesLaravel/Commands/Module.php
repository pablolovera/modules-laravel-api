<?php

namespace PabloLovera\ModulesLaravel\Commands;

use Illuminate\Console\Command;
use PabloLovera\ModulesLaravel\Traits\CommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Module extends Command
{
    use CommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {nome}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module structure basic with Controller, Entity, Service, Provider, Request, Repository... All extending of Core module';

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
        $moduleDirectory    = 'app/Modules/';
        $nome               = $this->argument('nome');
        $migration          = 'create_' . strtolower($nome) . '_table';


        $this->doDirectory($moduleDirectory . $nome);

        $this->call('module:make-controller'            , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-entity'                , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-entity-contract'       , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-repository'            , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-repository-contract'   , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-service'               , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-service-contract'      , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-request'               , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-transformer'           , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-service-provider'      , ['name' => $nome, 'module' => $nome]);
        $this->call('module:make-router'                , ['module' => $nome]);
        $this->call('module:make-migration'             , ['name' => $migration, 'module' => $nome]);
        $this->call('module:make-seeder'                , ['name' => $nome.'TableSeeder', 'module' => $nome]);

        $this->info('The module ' . $nome . ' has been generated. Enjoy!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the Crud.'],
        ];
    }

    /*
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['fields', null, InputOption::VALUE_OPTIONAL, 'Fields of form & model.', null],
        ];
    }
}