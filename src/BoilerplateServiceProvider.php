<?php

namespace Desino\Boilerplate;

use Illuminate\Support\ServiceProvider;
use Desino\Boilerplate\Commands\MakeBoilerplateCommand;

class BoilerplateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeBoilerplateCommand::class,
        ]);
    }

    public function boot()
    {
        // Boot package-specific resources if needed.
    }
}
