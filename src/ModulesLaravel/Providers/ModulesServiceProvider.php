<?php

namespace PabloLovera\ModulesLaravel\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Parent command namespace.
     *
     * @var string
     */
    protected $namespace = 'PabloLovera\\ModulesLaravel\\Commands\\';

    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        'Module',
        'ModuleCore',
        'ModuleController',
        'ModuleEntity',
        'ModuleEntityContract',
        'ModuleRepository',
        'ModuleRepositoryContract',
        'ModuleRequest',
        'ModuleRoutes',
        'ModuleService',
        'ModuleServiceContract',
        'ModuleServiceProvider',
        'ModuleTransformer',
        'ModuleMigration',
        'ModuleMigrate',
        'ModuleSeeder',
        'ModuleSeed'
    ];

    public function boot()
    {
        $this->publishes([__DIR__.'/../../resources/config/module.php' => config_path('module.php')], 'config');
        $this->publishes([__DIR__.'/../../resources/config/oauth2.php' => config_path('oauth2.php')], 'config');
        $this->publishes([__DIR__.'/../../resources/config/fractal.php' => config_path('fractal.php')], 'config');
    }

    /**
     * Register the commands.
     */
    public function register()
    {
        foreach ($this->commands as $command) {
            $this->commands($this->namespace.$command);
        }
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = [];

        foreach ($this->commands as $command) {
            $provides[] = $this->namespace.$command;
        }

        return $provides;
    }
}