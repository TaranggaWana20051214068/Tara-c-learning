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
    return auth()->check() ? redirect()->route('home') : redirect()->route('login');
});


Route::prefix('students')->group(function () {
    Route::get('/', 'HomeController@student_index')->name('student.index');
    Route::get('/{id}', 'HomeController@student_show')->name('student.show');
});
Route::get('jadwal-pelajaran', 'HomeController@jadwal_pelajaran')->name('jadwal.pelajaran');
Route::get('profile', 'HomeController@profile')->name('user.profile');
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
Route::prefix('/projects')->group(function () {
    Route::get('/', 'HomeController@projects_index')->name('project.index');
    Route::post('/', 'ProjectController@joinProject')->name('project.join');
    Route::get('/{id}', 'ProjectController@projects_show')->name('project.show');
    Route::post('/{id}', 'ProjectController@projects_tugas')->name('project.tugas');
});
Route::prefix('/quizs')->group(function () {
    Route::get('/', 'QuizController@index')->name('quiz.index');
    Route::get('/{category}', 'QuizController@show')->name('quiz.show');
    Route::post('/{category}', 'QuizController@add')->name('quiz.add');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'role:admin,guru']], function () {
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
        Route::resource('/quizs', 'QuizController');
        Route::post('/quizs/create', 'QuizController@addQuiz')->name('quizs.addQuiz');
        Route::get('/quizs/detail/{category}', 'QuizController@show')->name('quizs.detail');
        Route::get('/quizs/siswa/{category}', 'QuizController@siswa')->name('quizs.siswa');
        Route::post('/projects/{id}', 'ProjectController@tugas')->name('projects.tugas');
        Route::post('/projects/siswa/{id}', 'ProjectController@siswa')->name('projects.siswa');
        Route::get('/projects/siswa/{id}', 'ProjectController@siswaShow')->name('projects.tampilSiswa');
        Route::get('/projects/{id}/editTugas', 'ProjectController@editTugas')->name('projects.editTugas');
        Route::post('/questions/{id}/nilai', 'SoalController@nilai')->name('questions.nilai');
        Route::post('/questions/{id}', 'SoalController@editNilai')->name('questions.editNilai');
        Route::get('/settings', 'SettingController@index')->name('settings.index');
        Route::put('/settings', 'SettingController@update')->name('settings.update');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/home', 'HomeController@index')->name('home');
//     Route::get('/articles', 'HomeController@article_index')->name('article.index');
//     Route::get('/questions', 'HomeController@questions_index')->name('soal.index');
//     Route::prefix('/projects');
// });

Auth::routes();

// Route::get('/admin', 'admin\HomeController@index')->middleware('role:admin,guru')->name('admin.dashboard');
// Route::post('/articles', 'admin\ArticleController@url')->name('admin.articles.edit');
Route::post('/articles', [ArticleController::class, 'url'])->name('admin.articles.url');
