<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

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


Auth::routes(['register' => false]);

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});
Route::prefix('students')->group(function () {
    Route::get('/', 'HomeController@student_index')->name('student.index');
    Route::get('/{id}', 'HomeController@student_show')->name('student.show');
});
Route::get('jadwal-pelajaran', 'HomeController@jadwal_pelajaran')->name('jadwal.pelajaran');
Route::get('profile', 'HomeController@profile')->name('profile');
Route::get('jadwal-piket', 'HomeController@jadwal_piket')->name('jadwal.piket');
Route::prefix('/articles')->group(function () {
    Route::get('/', 'HomeController@article_index')->name('article.index');
    Route::get('/{id}', 'HomeController@article_show')->name('article.show');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::name('admin.')->group(function () {
        Route::get('/', 'HomeController@index')->name('dashboard');
        Route::resource('/users', 'UserController');
        Route::resource('/students', 'StudentController');
        Route::resource('/subjects', 'SubjectController');
        Route::resource('/schedules', 'ScheduleController');
        Route::resource('/pickets', 'PicketController');
        Route::resource('/articles', 'ArticleController');
        Route::get('/settings', 'SettingController@index')->name('settings.index');
        Route::put('/settings', 'SettingController@update')->name('settings.update');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => Authenticate::class], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/articles', 'HomeController@article_index')->name('article.index');
});
Auth::routes();

Route::get('/admin', 'admin\HomeController@index')->middleware('role:admin,guru')->name('admin.dashboard');
