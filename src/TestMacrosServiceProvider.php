<?php

namespace pschocke\TestMacros;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class TestMacrosServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        Collection::make(glob(__DIR__.'/macros/*.php'))
            ->mapWithKeys(function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            })
            ->reject(function ($macro) {
//                return Collection::hasMacro($macro);
                return false;
            })
            ->each(function ($macro, $path) {
                $class = app('pschocke\\TestMacros\\Macros\\'.$macro);
                ($class::$class)::macro(Str::camel($macro), $class());
            });
    }
}
