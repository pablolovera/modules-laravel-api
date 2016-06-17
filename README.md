## Modulos para API's em laravel 5.*

### Install

`composer require pablolovera/modules-laravel-api`

#### Add ServiceProvider on config/app.php

`PabloLovera\ModulesLaravel\Providers\ModulesServiceProvider::class,`

#### Publish config

`php artisan vendor:publish --provider="PabloLovera\ModulesLaravel\Providers\ModulesServiceProvider"`

### Licence

[MIT Licence](https://github.com/pablolovera/modules-laravel-api/blob/master/LICENSE)
