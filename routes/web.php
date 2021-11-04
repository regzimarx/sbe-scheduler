<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\SubjectsLivewire;
use App\Http\Livewire\SectionsLivewire;
use App\Http\Livewire\StudentsLivewire;
use App\Http\Livewire\TeachersLivewire;
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

Route::get("/", function () {
    return view("auth.login");
})->middleware(["auth:sanctum", "verified"]);

Route::group(
    ["prefix" => "dashboard", "middleware" => ["auth:sanctum", "verified"]],
    function () {
        Route::view("", "dashboard")->name("dashboard");
        Route::get("/sections", SectionsLivewire::class)->name("sections");
        Route::get("/students", StudentsLivewire::class)->name("students");
        Route::get("/subjects", SubjectsLivewire::class)->name("subjects");
        Route::get("/teachers", TeachersLivewire::class)->name("teachers");
    }
);
