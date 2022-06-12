<?php

namespace App\Console\Commands;

use App\Http\Stub;
use Illuminate\Console\Command;

class MakeContractCommand extends Command
{
    protected $signature = 'make:contract {model}';

    protected $description = 'Make Contract Command';

    public function handle()
    {
        $model = $this->argument('model');

        $namespace_interface = 'App\\Repository\\Contracts';

        $namespace_imp = 'App\\Repository\\Eloquent';

        $name = ucwords($model . 'Repository');

        $path1 = base_path($namespace_interface) . '\\I' . $name . '.php';

        $path2 = base_path($namespace_imp) . '\\' . $name . '.php';

        Stub::of('interface.stub',$model,$namespace_interface, $path1);

        Stub::of('repository.stub',$model,$namespace_imp, $path2);

        $this->info('Contract Created Successfully');
    }
}
