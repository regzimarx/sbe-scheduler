<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\RoomsLivewire;
use App\Http\Livewire\SubjectsLivewire;
use App\Http\Livewire\SectionsLivewire;
use App\Http\Livewire\StudentsLivewire;
use App\Http\Livewire\TeachersLivewire;
use App\Http\Livewire\SchedulesLivewire;
use App\Http\Livewire\DashboardLivewire;
use App\Http\Livewire\UsersLivewire;

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

Route::get("/", function () {
    return redirect()->route("dashboard");
});

Route::group(
    ["prefix" => "dashboard", "middleware" => ["auth:sanctum", "verified"]],
    function () {
        Route::get("", DashboardLivewire::class)->name("dashboard");
        Route::get("/rooms", RoomsLivewire::class)->name("rooms");
        Route::get("/sections", SectionsLivewire::class)->name("sections");
        Route::get("/sections/schedule/preview/{section_id}", [
            PDFController::class,
            "index",
        ])->name("section-preview");
        Route::get("/teachers/schedule/preview/{teacher_id}", [
            PDFController::class,
            "teacher",
        ])->name("teacher-preview");
        Route::get("/students", StudentsLivewire::class)->name("students");
        Route::get("/subjects", SubjectsLivewire::class)->name("subjects");
        Route::get("/teachers", TeachersLivewire::class)->name("teachers");
        Route::get("/schedules", SchedulesLivewire::class)->name("schedules");
        Route::get("/schedules", SchedulesLivewire::class)->name("schedules");
        Route::get("/users", UsersLivewire::class)->name("users");
    }
);
