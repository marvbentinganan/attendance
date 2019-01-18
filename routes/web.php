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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::prefix('events')->group(function () {
        Route::view('index', 'events.index')->name('events');
        Route::post('add', 'EventController@store')->name('event.add');
        Route::get('list', 'EventController@list')->name('events.list');
        Route::get('show/{event}', 'EventController@show')->name('event.show');
        Route::get('edit/{event}', 'EventController@edit')->name('event.edit');
        Route::post('update/{event}', 'EventController@update')->name('event.update');
        Route::get('delete/{event}', 'EventController@destroy')->name('event.delete');
    });

    Route::prefix('students')->group(function () {
        Route::view('index', 'students.index')->name('students');
        Route::post('upload', 'UserController@uploadStudents')->name('students.upload');
        Route::post('add', 'UserController@store')->name('student.add');
        Route::get('list', 'UserController@list')->name('students.list');
    });

    Route::prefix('attendance')->group(function () {
        Route::post('record/{event}', 'AttendanceController@store')->name('attendance.record');
        Route::get('attendees/{event}', 'AttendanceController@attendees')->name('attendance.attendees');
        Route::get('recent/{event}', 'AttendanceController@recent')->name('attendance.recent');
    });

    Route::prefix('reports')->group(function () {
        Route::get('index', 'ReportController@index')->name('reports');
        Route::get('{event}', 'ReportController@attendance')->name('event.attendance');
        Route::get('{event}/attendees', 'ReportController@attendees')->name('event.attendees');
        Route::get('{event}/{student}', 'ReportController@record')->name('event.record');
    });
});
