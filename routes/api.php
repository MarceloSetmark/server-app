<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecoverPassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAccountStatus;
use App\Http\Middleware\CheckUserPrivileges;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SummaryCalendarController;
use App\Http\Controllers\ProductController;  
use App\Http\Controllers\RegistrationController; 
use App\Http\Controllers\EnrollmentController; 

//Rotas para Iniciar Sessão
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/login/verify', [LoginController::class, 'verifyEmail']);
Route::post('/login/resend-code', [LoginController::class, 'resendEmailCode']);
Route::resource('courses', CourseController::class);
// Rotas para recuperar Palavra-Passe
Route::get('/reset-pass/{email}', [RecoverPassController::class, 'recoverPassword'])->where('email', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}');
Route::get('/reset-pass/resend-code/{email}', [RecoverPassController::class, 'resendEmailCode']);
Route::get('/reset-pass/verify/{email}/{codigo}', [RecoverPassController::class, 'verifyEmail'])->where('email', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}')->where('codigo', '[0-9]+');

//Rotas Protegidas por Token
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/login/update-pass', [LoginController::class, 'newPassword']);
    Route::post('/reset-pass/update', [RecoverPassController::class, 'updatePassword']);

    //Rota para Pegar Dados do Usuário Autenticado
    Route::get('authenticated', [UserController::class, 'authenticated']);
    //Rotas de Profile
    Route::resource('profiles', ProfileController::class);
    Route::post('profile/update-password', [ProfileController::class, 'updateUserPassword']);
    Route::post('profile/update-photo', [ProfileController::class, 'updateUserPhoto']);
    Route::post('profile/update-settings', [UserSettingsController::class, 'updateUserSettings']);

    // Aplicar middleware check.status
    Route::middleware(['check.privileges'])->group(function () {
        Route::resource('users', UserController::class);
        
        Route::resource('course-contents', CourseContentController::class);
        Route::resource('shifts', ShiftController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('products', ProductController::class);
        Route::resource('summary-calendar', SummaryCalendarController::class);
        Route::resource('registrations', RegistrationController::class);
        Route::resource('enrollments', EnrollmentController::class);
    });
    Route::resource('students', StudentController::class);
});


//
Route::get('students/get-data/{user_id}', [StudentController::class, 'showStudentData']);
Route::post('students/store-data', [StudentController::class, 'storeDataStudent']);
Route::put('students/update/{user_id}', [StudentController::class, 'updateStudent']);
//Rota para ver Cursos Disponíveis
Route::get('classes-available ', [ClassController::class, 'classesAvailable']);
//Rota para ver Cursos Disponíveis
//Route::resource('registrations', RegistrationController::class)->only(['store','delete']);

