<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
|
| Hier definiëren we de routes voor de Contact package.
|
*/

Route::middleware(['web', 'auth:staff'])->prefix(config('manta-contact.route_prefix'))
    ->name('contact.')
    ->group(function () {
        Route::get("/", \Darvis\MantaContact\Livewire\ContactList::class)->name('list');
        Route::get("/toevoegen", \Darvis\MantaContact\Livewire\ContactCreate::class)->name('create');
        Route::get("/aanpassen/{contact}", \Darvis\MantaContact\Livewire\ContactUpdate::class)->name('update');
        Route::get("/lezen/{contact}", \Darvis\MantaContact\Livewire\ContactRead::class)->name('read');
        Route::get("/bestanden/{contact}", \Darvis\MantaContact\Livewire\ContactUpload::class)->name('upload');
        Route::get("/instellingen", \Darvis\MantaContact\Livewire\ContactSettings::class)->name('settings');
    });
