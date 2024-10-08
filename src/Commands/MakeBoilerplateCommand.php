<?php

namespace Desino\Boilerplate\Commands;

use Illuminate\Console\Command;

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
        $this->publishServices();
        $this->publishProviders();
        $this->publishControllers();
        $this->publishModels();
        $this->publishMigrations();
        $this->publishViews();
        $this->publishMailable();
        $this->publishMiddleware();
        $this->publishTranslations();

        $this->call('config:cache');

        $this->info('Desino boilerplate is copied to your application!');
    }

    /**
     * Copies the AppMiscService to the app/Services directory.
     *
     * @return void
     */
    protected function publishServices()
    {
        file_put_contents(app_path("/app/Services/AppMiscService.php"), file_get_contents(__DIR__."/../stubs/Services/AppMiscService.stub"));
    }

    /**
     * Publish the providers file to the app/Providers directory of the application.
     *
     * @return void
     */
    protected function publishProviders()
    {
        file_put_contents(app_path("/app/Providers/BladeDefaultVariablesServiceProvider.php"), file_get_contents(__DIR__."/../stubs/Providers/BladeDefaultVariablesServiceProvider.stub"));
    }

    /**
     * Publish the controller files to the app/Http/Controllers directory of the application.
     *
     * @return void
     */
    protected function publishControllers()
    {
        file_put_contents(app_path("/app/Http/Controllers/UserController.php"), file_get_contents(__DIR__."/../stubs/Http/Controllers/UserController.stub"));
        file_put_contents(app_path("/app/Http/Controllers/AppConfigController.php"), file_get_contents(__DIR__."/../stubs/Http/Controllers/AppConfigController.stub"));
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
        file_put_contents(app_path("/app/Models/User.php"), file_get_contents(__DIR__."/../stubs/Models/User.stub"));
        file_put_contents(app_path("/app/Models/AppConfig.php"), file_get_contents(__DIR__."/../stubs/Models/AppConfig.stub"));
    }

    private function publishMigrations()
    {
        file_put_contents(app_path("/database/migrations/".date('Y_m_d_His')."_adjust_users_table.php"), file_get_contents(__DIR__."/../stubs/database/migrations/adjust_users_table.stub"));
        file_put_contents(app_path("/database/migrations/".date('Y_m_d_His')."_create_app_configs_table.php"), file_get_contents(__DIR__."/../stubs/database/migrations/create_app_configs_table.stub"));
    }

    protected function publishViews()
    {
        file_put_contents(app_path("/resources/views/welcome.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/welcome.blade.stub"));
        file_put_contents(app_path("/resources/views/auth/login.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/login.blade.stub"));
        file_put_contents(app_path("/resources/views/auth/register.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/register.blade.stub"));
        file_put_contents(app_path("/resources/views/auth/passwords/reset.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/passwords/reset.blade.stub"));
        file_put_contents(app_path("/resources/views/auth/passwords/email.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/passwords/email.blade.stub"));
        file_put_contents(app_path("/resources/views/auth/passwords/reset.blade.php"), file_get_contents(__DIR__."/../stubs/resources/views/auth/passwords/reset.blade.stub"));
    }

    protected function publishMailable()
    {
        file_put_contents(app_path("/app/Mail/ResetPasswordMail.php"), file_get_contents(__DIR__."/../stubs/Mail/ResetPasswordMail.stub"));
    }

    protected function publishMiddleware()
    {
        file_put_contents(app_path("/app/Http/Middleware/CheckUserIsActive.php"), file_get_contents(__DIR__."/../stubs/Http/Middleware/CheckUserIsActive.stub"));
    }

    /**
     * Publish the translations stub file to the lang/en/messages.php of the application.
     *
     */
    protected function publishTranslations()
    {
        file_put_contents(app_path("/lang/en/messages.php"), file_get_contents(__DIR__."/../stubs/lang/en/messages.stub"));
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
