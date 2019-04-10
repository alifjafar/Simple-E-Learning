<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController')->name('dashboard');

    Route::get('classroom', 'ClassroomController@index')->name('classroom.index');
    Route::resource('classroom', 'ClassroomController')->except(['index']);
    Route::post('classroom/course/add', 'CourseController@store')->name('course.store');
    Route::get('student/classroom', 'StudentController@ajaxSearch')->name('students.ajax');
    Route::post('classroom/student/invite', 'ClassroomController@invite')->name('students.invite');

    Route::get('classroom/course/download/{id}', 'FileController@download')->name('file.download');
});
Route::get('/home', 'HomeController@index')->name('home');
