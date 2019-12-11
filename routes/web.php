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
    Route::get('classroom/students/{classroom}', 'ClassroomController@showStudents')->name('classroom.student');
    Route::delete('classroom/students/destroy/{classroomId}/{studentId}', 'ClassroomController@deleteStudent')->name('classroom.student.destroy');
    Route::get('student/classroom', 'StudentController@ajaxSearch')->name('students.ajax');
    Route::post('classroom/student/invite', 'ClassroomController@invite')->name('students.invite');
    Route::post('classroom/course/add', 'CourseController@store')->name('course.store');
    Route::delete('classroom/course/destroy/{course}', 'CourseController@destroy')->name('course.destroy');
    Route::get('classroom/course/download/{id}', 'FileController@download')->name('file.download');

    Route::group(['middleware' => ['can:admin']], function () {
        Route::resource('users', 'UserController');
    });


    Route::group(['prefix' => 'user/profile'], function () {
        Route::get('/{username}', 'ProfileController@index')->name('profile');
        Route::get('/{username}/change_password', 'ProfileController@editPassword')->name('edit-password');
        Route::put('/edit/{user}', 'ProfileController@updateProfile')->name('update.profile');
        Route::put('/change_password/{user}', 'ProfileController@updatePassword')->name('update.password');
        Route::put('/{user}/update_foto', 'ProfileController@updateFoto')->name('update.foto');
    });
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/google', 'Auth\GoogleController@redirectToProvider')->name('register.google');
Route::get('auth/google/callback', 'Auth\GoogleController@handleProviderCallback');
