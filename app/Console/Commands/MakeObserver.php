<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class MakeObserver extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:observer {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成 observer';


    protected function getStub()
    {
        return __DIR__.'/stubs/observer.stub';
    }


    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Observer.php';
    }


    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceClass($this->replaceInstance($stub, $name), $name);
    }


    protected function replaceInstance($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('dummyInstance', lcfirst($class), $stub);
    }


    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Observers';
    }
}
