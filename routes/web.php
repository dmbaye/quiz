<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\QuizCompletedController;
use App\Http\Controllers\Admin\QuizzesController;
use App\Http\Controllers\Admin\AnswersController;
use App\Http\Controllers\Admin\SegmentsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ParticipationsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Admin\UserStatusController;
use App\Http\Controllers\Admin\ImportUsersController;
use App\Http\Controllers\Admin\QuizExportsController;
use App\Http\Controllers\Admin\AssignmentsController;
use App\Http\Controllers\Admin\ArchiveQuizController;
use App\Http\Controllers\Admin\PublishQuizController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\DuplicateQuizzesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);

Route::post('/login', [CustomLoginController::class, 'login']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/quizzes', [\App\Http\Controllers\QuizzesController::class, 'index'])->name('quizzes.list');
Route::get('/quizzes/{quiz}/results', [\App\Http\Controllers\QuizzesController::class, 'show'])->name('quizzes.view');

Route::get('/quizzes/{quiz}/participate', [ParticipationsController::class, 'create'])->name('participations.create');
Route::post('/quizzes/{quiz}/participate', [ParticipationsController::class, 'store'])->name('participations.store');
Route::put('/quizzes/{quiz}/participate', [ParticipationsController::class, 'update'])->name('participations.update');

Route::put('/quizzes/{quiz}/completed', [QuizCompletedController::class, 'update'])->name('quiz.completed');

route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.delete');

    Route::post('/users/import', [ImportUsersController::class, 'import'])->name('users.import');

    Route::put('/users/{user}/activate', [UserStatusController::class, 'update'])->name('users.activate');
    Route::delete('/users/{user}/deactivate', [UserStatusController::class, 'destroy'])->name('users.deactivate');

    Route::get('/users/{user}/quizzes/{quiz}', [\App\Http\Controllers\QuizzesController::class, 'show'])->name('quizzes.view');

    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.delete');

    Route::post('/roles/{role}/permissions', [PermissionsController::class, 'store'])->name('permissions.store');
    Route::put('/roles/{role}/permissions/{permission}', [RolesController::class, 'update'])->name('permissions.update');
    Route::delete('/roles/{role}/permissions/{permissions}', [RolesController::class, 'destroy'])->name('permissions.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [PasswordsController::class, 'update'])->name('password.update');

    Route::get('/segments', [SegmentsController::class, 'index'])->name('segments.index');
    Route::get('/segments/{segment}', [SegmentsController::class, 'show'])->name('segments.show');
    Route::post('/segments', [SegmentsController::class, 'store'])->name('segments.store');
    Route::put('/segments/{segment}', [SegmentsController::class, 'update'])->name('segments.update');
    Route::delete('/segments/{segment}', [SegmentsController::class, 'destroy'])->name('segments.delete');

    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.delete');

    Route::get('/quizzes', [QuizzesController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizzesController::class, 'create'])->name('quizzes.create');
    Route::get('/quizzes/{quiz}', [QuizzesController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes', [QuizzesController::class, 'store'])->name('quizzes.store');
    Route::put('/quizzes/{quiz}', [QuizzesController::class, 'update'])->name('quizzes.update');
    Route::put('/quizzes/{quiz}/publish', [PublishQuizController::class, 'update'])->name('quizzes.publish');
    Route::put('/quizzes/{quiz}/archive', [ArchiveQuizController::class, 'update'])->name('quizzes.archive');
    Route::delete('/quizzes/{quiz}', [QuizzesController::class, 'destroy'])->name('quizzes.delete');
    Route::delete('/quizzes/{quiz}/unarchive', [ArchiveQuizController::class, 'destroy'])->name('quizzes.unarchive');

    Route::post('/quizzes/{quiz}/duplicate', [DuplicateQuizzesController::class, 'store'])->name('quizzes.duplicate');

    route::get('/quizzes/{quiz}/{user}', [AssignmentsController::class, 'single'])->name('assignments.single');
    route::post('/quizzes/{quiz}/assign', [AssignmentsController::class, 'store'])->name('assignments.store');
    route::put('/quizzes/{quiz}/assign/{user}', [AssignmentsController::class, 'update'])->name('assignments.update');
    route::delete('/quizzes/{quiz}/assign/{user}', [AssignmentsController::class, 'destroy'])->name('assignments.delete');

    Route::get('/questions/{question}', [QuestionsController::class, 'show'])->name('questions.show');
    Route::post('/quizzes/{quiz}/questions', [QuestionsController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [QuestionsController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionsController::class, 'destroy'])->name('questions.delete');

    Route::post('/questions/{question}/answers', [AnswersController::class, 'store'])->name('answers.store');
    Route::put('/questions/{question}/answers/{answer}', [AnswersController::class, 'update'])->name('answers.update');
    Route::delete('/questions/{question}/answers/{answer}', [AnswersController::class, 'destroy'])->name('answers.delete');

    Route::get('/exports/{quiz}', [QuizExportsController::class, 'index'])->name('quizzes.export');
});
