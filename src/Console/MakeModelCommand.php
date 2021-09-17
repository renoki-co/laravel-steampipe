<?php

namespace RenokiCo\LaravelSteampipe\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'steampipe:make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model for a given table.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Steampipe Model';

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName) || parent::alreadyExists($rawName);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/model.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $studlyProvider = Str::studly($this->getProvider());

        return $rootNamespace.'\Steampipe\\'.$studlyProvider;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $studlyClass = Str::of($name)
            ->replace($this->getNamespace($name).'\\', '')
            ->studly()
            ->prepend($this->getNamespace($name).'\\')
            ->__toString();

        return $this->laravel['path'].'/'.str_replace('\\', '/', $studlyClass).'.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $studlyClass = Str::of($name)
            ->replace($this->getNamespace($name).'\\', '')
            ->studly()
            ->__toString();

        return $this->replaceNamespace($stub, $name)
            ->replaceTable($stub, $name)
            ->replaceClass($stub, $studlyClass);
    }

    /**
     * Replace the table for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceTable(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyTable', '{{ table }}', '{{table}}'],
            $this->argument('name'),
            $stub
        );

        return $this;
    }

    /**
     * Get the provider name for the table.
     *
     * @return string
     */
    protected function getProvider(): string
    {
        return explode('_', $this->argument('name'))[0];
    }
}
