<?php

namespace Desino\Boilerplate\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class MakeBoilerplateCommand extends Command
{
    protected $signature   = 'make:desino-boilerplate';
    protected $description = 'Command to pull desino boilerplate to your laravel application.';

    /**
     * Executes the command.
     *
     * Publishes the boilerplate files to the application directories.
     *
     * @return void
     */
    public function handle()
    {
        $this->publishMiddleware();
        $this->publishServices();
        $this->publishProviders();
        $this->publishControllers();
        $this->publishModels();
        $this->publishMailable();
        $this->publishMigrations();
        $this->publishViews();
        $this->publishRoutes();
        $this->publishTranslations();

        /*composer require laravel/ui
        composer require league/csv
        composer require league/flysystem-sftp-v3

        .env database connection

        config/database
        'charset' => env('DB_CHARSET', 'utf8'),
        'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),

        php artisan config:cache
        php artisan migrate

        to bootstrap/providers.php
        App\Providers\BladeDefaultVariablesServiceProvider::class,
        */
        $this->info('Desino boilerplate is copied to your application!');
    }

    /**
     * Copies the AppMiscService to the app/Services directory.
     *
     * @return void
     */
    protected function publishServices()
    {
        if (!is_dir(app_path("Services/"))) {
            mkdir(app_path("Services/"), 0755, true);
        }
        file_put_contents(app_path("Services/AppMiscService.php"), file_get_contents(__DIR__."/../stubs/app/Services/AppMiscService.stub"));
    }

    /**
     * Publish the providers file to the app/Providers directory of the application.
     *
     * @return void
     */
    protected function publishProviders()
    {
        if (!is_dir(app_path("Providers/"))) {
            mkdir(app_path("Providers/"), 0755, true);
        }
        file_put_contents(app_path("Providers/BladeDefaultVariablesServiceProvider.php"), file_get_contents(__DIR__."/../stubs/app/Providers/BladeDefaultVariablesServiceProvider.stub"));
    }

    /**
     * Publish the controller files to the app/Http/Controllers directory of the application.
     *
     * @return void
     */
    protected function publishControllers()
    {
        if (! is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/app/Http/Controllers/Auth/'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/Auth/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });

        file_put_contents(app_path("Http/Controllers/Controller.php"), file_get_contents(__DIR__."/../stubs/app/Http/Controllers/Controller.stub"));
        file_put_contents(app_path("Http/Controllers/HomeController.php"), file_get_contents(__DIR__."/../stubs/app/Http/Controllers/HomeController.stub"));
        file_put_contents(app_path("Http/Controllers/UserController.php"), file_get_contents(__DIR__."/../stubs/app/Http/Controllers/UserController.stub"));
        file_put_contents(app_path("Http/Controllers/AppConfigController.php"), file_get_contents(__DIR__."/../stubs/app/Http/Controllers/AppConfigController.stub"));
    }

    /**
     * Publish the User and AppConfig stub files to the app/Models directory of the application.
     *
     * The User model is used to store user data. The AppConfig model is used to store the configuration of the application.
     *
     * @return void
     */
    protected function publishModels()
    {
        if (!is_dir(app_path("Models/"))) {
            mkdir(app_path("Models/"), 0755, true);
        }
        file_put_contents(app_path("Models/User.php"), file_get_contents(__DIR__."/../stubs/app/Models/User.stub"));
        file_put_contents(app_path("Models/AppConfig.php"), file_get_contents(__DIR__."/../stubs/app/Models/AppConfig.stub"));
    }

    /**
     * Publish the migration stub files to the database/migrations directory of the application.
     *
     * The migration files are used to create the tables in the database.
     *
     * @return void
     */
    private function publishMigrations()
    {
        file_put_contents(database_path("migrations/".date('Y_m_d_His')."_adjust_users_table.php"), file_get_contents(__DIR__."/../stubs/database/migrations/adjust_users_table.stub"));
        file_put_contents(database_path("migrations/".date('Y_m_d_His')."_create_app_configs_table.php"), file_get_contents(__DIR__."/../stubs/database/migrations/create_app_configs_table.stub"));
    }

    protected function publishViews()
    {
        if (!is_dir(resource_path("views/layouts/"))) {
            mkdir(resource_path("views/layouts/"), 0755, true);
        }
        if (!is_dir(resource_path("views/auth/"))) {
            mkdir(resource_path("views/auth/"), 0755, true);
        }
        if (!is_dir(resource_path("views/users/"))) {
            mkdir(resource_path("views/users/"), 0755, true);
        }
        if (!is_dir(resource_path("views/auth/passwords/"))) {
            mkdir(resource_path("views/auth/passwords/"), 0755, true);
        }
        if (!is_dir(resource_path("views/emails/"))) {
            mkdir(resource_path("views/emails/"), 0755, true);
        }
        file_put_contents(resource_path("views/layouts/app.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/layouts/app.blade.stub"));
        file_put_contents(resource_path("views/home.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/home.blade.stub"));
        file_put_contents(resource_path("views/config.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/config.blade.stub"));
        file_put_contents(resource_path("views/users/index.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/users/index.blade.stub"));
        file_put_contents(resource_path("views/users/create.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/users/create.blade.stub"));
        file_put_contents(resource_path("views/users/edit.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/users/edit.blade.stub"));
        file_put_contents(resource_path("views/auth/login.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/login.blade.stub"));
        file_put_contents(resource_path("views/auth/register.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/register.blade.stub"));
        file_put_contents(resource_path("views/auth/passwords/reset.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/passwords/reset.blade.stub"));
        file_put_contents(resource_path("views/auth/passwords/email.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/passwords/email.blade.stub"));
        file_put_contents(resource_path("views/auth/passwords/reset.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/passwords/reset.blade.stub"));
        file_put_contents(resource_path("views/emails/master.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/emails/master.blade.stub"));
        file_put_contents(resource_path("views/emails/reset_password.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/emails/reset_password.blade.stub"));
    }

    protected function publishMailable()
    {
        if (!is_dir(app_path("Mail/"))) {
            mkdir(app_path("Mail/"), 0755, true);
        }
        file_put_contents(app_path("Mail/ResetPasswordMail.php"), file_get_contents(__DIR__."/../stubs/app/Mail/ResetPasswordMail.stub"));
    }

    protected function publishMiddleware()
    {
        if (!is_dir(app_path("Http/Middleware/"))) {
            mkdir(app_path("Http/Middleware/"), 0755, true);
        }
        file_put_contents(app_path("Http/Middleware/CheckUserIsActive.php"), file_get_contents(__DIR__."/../stubs/app/Http/Middleware/CheckUserIsActive.stub"));
    }

    protected function publishRoutes()
    {
        file_put_contents(base_path("routes/web.php"), file_get_contents(__DIR__."/../stubs/routes/web.stub"));
    }

    /**
     * Publish the translations stub file to the lang/en/messages.php of the application.
     *
     */
    protected function publishTranslations()
    {
        if (!is_dir(app_path("lang/"))) {
            mkdir(app_path("lang/"), 0755, true);
        }
        if (!is_dir(app_path("lang/en/"))) {
            mkdir(app_path("lang/en/"), 0755, true);
        }
        file_put_contents(app_path("lang/en/messages.php"), file_get_contents(__DIR__."/../stubs/lang/en/messages.stub"));
    }

    /**
     * Return the stub file contents for the given type
     *
     * @param  string  $type
     * @return string
     */
    protected function getStub($type)
    {
        return file_get_contents(__DIR__."/../stubs/$type.stub");
    }
}
