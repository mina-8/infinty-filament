# deploy on server
composer2 install --no-dev --optimize-autoloader

# optional
chmod -R 775 storage bootstrap/cache 

php artisan key:generate

php artisan migrate --force

# env file on production

APP_ENV=production
APP_DEBUG=false

LOG_CHANNEL=stack
LOG_LEVEL=error

# packeg use with filament

pixelpeter/filament-language-tabs
spatie/ 
tomatophp/filament-language-switcher

## stroage link 
# php artisan stroge:link or cd public
unlink storage
ln -s ../storage/app/public storage

## only want to roll back that specific migration file

# php artisan migrate:rollback --path=/database/migrations/2025_05_13_155620_create_about_us_table.php

## to can upload file more than 50mb

# edit config AppServiceProdider file in boot function and edit file php.ini 
<p>
upload_max_filesize = 50M
post_max_size = 60M
</p>

# Config::set('livewire.temporary_file_upload.rules', ['file', 'max:51200']);


## php artisan make:migration add_column_name_to_table_name_table

 $table->foreignId('solve_brands_id')
      ->nullable()
      ->after('id') // 👈 Adds the column after 'id'
      ->constrained('solve_brands')
      ->cascadeOnDelete()
      ->cascadeOnUpdate();

## create admin 

# first setp create model Admin

php artisan make:model Admin -m

# second step like this : 
config/auth.php
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

# third step edit in database and model Admin

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Admin extends Authenticatable
{
    use Notifiable;
    use \TomatoPHP\FilamentLanguageSwitcher\Traits\InteractsWithLanguages; // if use filament
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

# four optional step if not use filament

create in route/Admin.php 
implement in bootsrtap/app.php


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php' ,
        admin : __DIR__ . '/../routes/admin.php'
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

create auth_admin.php

# five step create trait to can handel guards

trait GuardUsers.php

<?php

namespace App\Traits;
trait GuardUsers
{
    protected $lang;

    public function __construct()
    {
        $this->lang  = request()->segment(1);
    }

    private function isAgent()
    {
        return request()->is("{$this->lang}/agent/*");
    }

    public function Guardusers()
    {
        if ($this->isAgent()) {
            return "agent";
        }

        return "web";
    }

    
}


# six step use Guardusers function in this files
AuthenticatedSessionController.php

in function create inertia:render 
guardusers => $this->Guardusers()

in function store 

in function destroy

RegisteredUserController.php


## make middleware lang and group prefix

Route::group(
    [
        'prefix' => '{lang?}',
        'where' => [
            // Exclude 'livewire' and 'admin' from being matched as language
            'lang' => '(?!livewire|admin)[a-zA-Z]{2}(-[a-zA-Z]{2})?'
        ],
        'middleware' => 'lang'
    ],
    function () {
  
  all routes

    }
);

# add middleware lang in app.php

->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\Lang::class,
    
$middleware->alias(
            [
                'lang' => \App\Http\Middleware\Lang::class,
            ]
        );

        
