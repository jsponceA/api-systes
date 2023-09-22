<?php

namespace App\Providers;

use App\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UsuarioRepositoryInterface::class,UsuarioRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
