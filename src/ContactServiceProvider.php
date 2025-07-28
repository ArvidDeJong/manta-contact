<?php

namespace Darvis\MantaContact;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register package services
        $this->mergeConfigFrom(
            __DIR__ . '/../config/manta-contact.php',
            'manta-contact'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publiceer configuratie
        $this->publishes([
            __DIR__ . '/../config/manta-contact.php' => config_path('manta-contact.php'),
        ], 'manta-contact-config');

        // Publiceer migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'manta-contact-migrations');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'manta-contact');

        // Register Livewire components
        Livewire::component('contact-list', \Darvis\MantaContact\Livewire\ContactList::class);
        Livewire::component('contact-create', \Darvis\MantaContact\Livewire\ContactCreate::class);
        Livewire::component('contact-read', \Darvis\MantaContact\Livewire\ContactRead::class);
        Livewire::component('contact-update', \Darvis\MantaContact\Livewire\ContactUpdate::class);
        Livewire::component('contact-upload', \Darvis\MantaContact\Livewire\ContactUpload::class);
        Livewire::component('contact-settings', \Darvis\MantaContact\Livewire\ContactSettings::class);
        Livewire::component('contact-button-email', \Darvis\MantaContact\Livewire\ContactButtonEmail::class);

        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Darvis\MantaContact\Console\Commands\InstallCommand::class,
            ]);
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
