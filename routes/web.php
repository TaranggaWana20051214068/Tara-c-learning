<?php

use App\Http\Controllers\SoalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\Admin\ArticleController;

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
Route::prefix('/questions')->group(function () {
    Route::get('/', 'HomeController@questions_index')->name('soal.index');
    Route::get('/{id}', 'SoalController@questions_show')->name('soal.show');
    Route::post('/{id}', 'SoalController@questions_code')->name('soal.questions_code');
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
        Route::resource('/questions', 'SoalController');
        Route::resource('/projects', 'ProjectController');
        Route::post('/projects/{id}', 'ProjectController@tugas')->name('projects.tugas');
        Route::get('/projects/{id}/editTugas', 'ProjectController@editTugas')->name('projects.editTugas');
        Route::post('/questions/{id}/nilai', 'SoalController@nilai')->name('questions.nilai');
        Route::post('/questions/{id}', 'SoalController@editNilai')->name('questions.editNilai');
        Route::get('/settings', 'SettingController@index')->name('settings.index');
        Route::put('/settings', 'SettingController@update')->name('settings.update');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => Authenticate::class], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/articles', 'HomeController@article_index')->name('article.index');
    Route::get('/questions', 'HomeController@questions_index')->name('soal.index');
});
Auth::routes();

Route::get('/admin', 'admin\HomeController@index')->middleware('role:admin,guru')->name('admin.dashboard');
// Route::post('/articles', 'admin\ArticleController@url')->name('admin.articles.edit');
Route::post('/articles', [ArticleController::class, 'url'])->name('admin.articles.url');
