## Modules for API's RESTFul based on laravel 5.*

SOLID principles...


### Install

```
composer require pablolovera/modules-laravel-api
```

#### Add ServiceProvider on config/app.php

```
PabloLovera\ModulesLaravel\Providers\ModulesServiceProvider::class,
```

#### Add the Facade in `aliases` array
For OAuth2
```
'Authorizer' => LucaDegasperi\OAuth2Server\Facades\Authorizer::class,
```

For Fractal
```
'Fractal' => Cyvelnet\Laravel5Fractal\Facades\Fractal::class
```

#### Publish config
```
php artisan vendor:publish --provider="PabloLovera\ModulesLaravel\Providers\ModulesServiceProvider"
```

### How to use...

#### First step (IMPORTANT)
Create the `Core` module. It's very important!
```
php artisan module:make-core
```
Then... see the directory `app/Core/`

#### Create the other modules...

```
php artisan make:module <module-name>
```
Then... see the directory `app/Modules/<module-name>`

When a new module is created, you need add provider in `config/app.php`, like a `App\Modules\<module-name>\Providers\<module-name>ServiceProvider::class,`

### Commands available

`php artisan ...`

##### Create Module
```
make:module <module-name>
```

##### Create Controller for existing module
```
module:make-controller <controller-name> <module-name>
```
So... created in `app/Modules/<module-name>/Http/Controllers/<controller-name>`

##### Create Entity for existing module
```
module:make-entity <entity-name> <module-name>
```
So... created in `app/Modules/<module-name>/Entities/<entity-name>`

##### Create Entity Contract for existing module
```
module:make-entity-contract <entity-contract-name> <module-name>
```
So... created in `app/Modules/<module-name>/Contracts/Entities/<entity-contract-name>`

##### Create Repository for existing module
```
module:make-repository <repository-name> <module-name>
```
So... created in `app/Modules/<module-name>/Repositories/<repository-name>`

##### Create Repository Contract for existing module
```
module:make-repository-contract <repository-contract-name> <module-name>
```
So... created in `app/Modules/<module-name>/Contracts/Repositories/<repository-contract-name>`

##### Create Service for existing module
```
module:make-service <service-name> <module-name>
```
So... created in `app/Modules/<module-name>/Services/<service-name>`

##### Create Service Contract for existing module
```
module:make-service-contract <service-contract-name> <module-name>
```
So... created in `app/Modules/<module-name>/Contracts/Services/<service-contract-name>`

##### Create Request for existing module
```
module:make-request <request-name> <module-name>
```
So... created in `app/Modules/<module-name>/Http/Requests/<request-name>`

##### Create Seeder for existing module
```
module:make-seeder <seeder-name> <module-name>
```
So... created in `app/Modules/<module-name>/Database/seeds/<seeder-name>`

##### Create Migration for existing module
```
module:make-migration <migration-name> <module-name>
```
So... created in `app/Modules/<module-name>/Database/migrations/<migration-name>`

##### Executing Migration for existing module
```
module:migrate <module-name>
```
or
```
module:migrate <module-name> --seed
```

##### Create Service Provider for existing module
```
module:make-service-provider <service-provider-name> <module-name>
```
So... created in `app/Modules/<module-name>/Providers/<service-provider-name>`



##### Create Transformer for existing module
```
module:make-transformer <transformer-name> <module-name>
```
So... created in `app/Modules/<module-name>/Transformers/<transformer-name>`

### The following packages are also used

[lucadegasperi/oauth2-server-laravel](https://github.com/lucadegasperi/oauth2-server-laravel)
[Cyvelnet/laravel5-fractal](https://github.com/Cyvelnet/laravel5-fractal)


### Licence

[MIT Licence](https://github.com/pablolovera/modules-laravel-api/blob/master/LICENSE)
