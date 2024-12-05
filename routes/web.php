<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckIsNotLogged::class])->group(function(){
    // se usuario não tiver logado
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('loginSubmit', [AuthController::class, 'loginSubmit']);
});

Route::middleware([CheckIsLogged::class])->group(function(){
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');
    Route::get('editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('editNoteSubmit', [MainController::class, 'editNoteSubmit'])->name('editNoteSubmit');
    Route::get('deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');
    Route::get('/deleNoteConfirm/{id}', [MainController::class, 'deleteNoteConfirm'])->name('deleteConfirm');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});