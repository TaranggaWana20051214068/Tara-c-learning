<?php

use App\Http\Controllers\PresensiController;
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

// Route::get('/', function () {
//     return auth()->check() ? redirect()->route('home') : redirect()->route('login');
// });
Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'HomeController@index')->name('home');


    Route::prefix('students')->group(function () {
        Route::get('/', 'HomeController@student_index')->name('student.index');
        Route::get('/{id}', 'HomeController@student_show')->name('student.show');
    });
    Route::get('jadwal-pelajaran', 'HomeController@jadwal_pelajaran')->name('jadwal.pelajaran');
    Route::get('profile', 'HomeController@profile')->name('user.profile');
    Route::get('panduan', 'HomeController@panduan')->name('user.panduan');
    Route::get('/panduan/unduh-panduan', function () {
        $filePath = storage_path('app/public/pdf/buku_panduan.pdf');
        return response()->download($filePath, 'buku_panduan.pdf');
    })->name('unduh-panduan');
    Route::get('/profile/edit', 'HomeController@profile_edit')->name('user.profileEdit');
    Route::put('/profile/edit', 'HomeController@profile_update')->name('user.profileUpdate');
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
        Route::post('/join/{id}', 'ProjectController@joinProject')->name('project.join');
        Route::get('/{id}', 'ProjectController@projects_show')->name('project.show');
        Route::post('/{id}', 'ProjectController@projects_tugas')->name('project.tugas');
        Route::post('/{id}/jadwal', 'ProjectController@projects_jadwal')->name('project.jadwal');
        Route::post('/{id}/role', 'ProjectController@role')->name('project.role');
        Route::delete('/{logbooks}', 'ProjectController@jadwal_destroy')->name('project.jadwal_destroy');
    });
    Route::prefix('/quizs')->group(function () {
        Route::get('/', 'QuizController@index')->name('quiz.index');
        Route::get('/{category}', 'QuizController@show')->name('quiz.show');
        Route::get('/jawaban/{category}', 'QuizController@showJawaban')->name('quiz.showJawaban');
        Route::post('/{category}', 'QuizController@add')->name('quiz.add');
    });
    Route::post('/articles', [ArticleController::class, 'url'])->name('admin.articles.url');
    Route::prefix('/presensi')->group(function () {
        Route::get('/', [PresensiController::class, 'index'])->name('presensi');
        Route::post('/camera-snap', [PresensiController::class, 'store'])->name('camera-snap');
        # history
        Route::post('/get-history', [PresensiController::class, 'getHistory'])->name('get-history');

        # izin
        Route::get('/presensi-izin', [PresensiController::class, 'getIzin']);
        Route::post('/presensi-izin/store', [PresensiController::class, 'storeizin'])->name('store-izin');
    });
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
        Route::resource('/presensis', 'PresensiController');
        Route::post('/presensis/history', 'PresensiController@getHistory')->name('presensis.history');
        Route::get('/presensis/izin', 'PresensiController@geIzin')->name('presensis.detail');
        Route::post('/presensis/izin/approved', 'PresensiController@storeIzin');
        Route::post('/quizs/create', 'QuizController@addQuiz')->name('quizs.addQuiz');
        Route::get('/quizs/detail/{category}', 'QuizController@show')->name('quizs.detail');
        Route::get('/quizs/siswa/{category}', 'QuizController@siswa')->name('quizs.siswa');
        Route::delete('/quizs/siswa/{user_id}/{category}', 'QuizController@destroy_siswa')->name('quizs.destroy_siswa');
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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route::get('/admin', 'admin\HomeController@index')->middleware('role:admin,guru')->name('admin.dashboard');
// Route::post('/articles', 'admin\ArticleController@url')->name('admin.articles.edit');

