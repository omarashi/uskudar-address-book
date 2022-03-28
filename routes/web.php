<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users\Main as Index;
use App\Http\Livewire\Users\Form as UserForm;
use App\Http\Livewire\Users\Show as UserShow;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', Index::class)->name('dashboard');
    Route::get('/members/show/{id}', UserShow::class)->name('users.show');
    Route::get('/members/{process}/{id?}', UserForm::class)->name('users.form');
});

require __DIR__.'/auth.php';
