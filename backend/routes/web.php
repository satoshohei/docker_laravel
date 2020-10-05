<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionChoiceController;


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


Route::resource('posts',PostController::class);



//Route::resource('questions',QuestionController::class);

// 一覧
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');

Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');

Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');

Route::patch('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');


//***回答***
//Route::resource('question_choices', QuestionChoiceController::class);

Route::get('/question_choices/create/{question_id}', [QuestionChoiceController::class, 'create'])->name('question_choices.create');

Route::delete('/question_choices/{question_choice}', [QuestionChoiceController::class, 'destroy'])->name('question_choices.destroy');

Route::get('/question_choices/{question_choice}/edit', [QuestionChoiceController::class, 'edit'])->name('question_choices.edit');

Route::post('/question_choices/{question_id}', [QuestionChoiceController::class, 'store'])->name('question_choices.store');

Route::put('/question_choices/{question_choice}', [QuestionChoiceController::class, 'update'])->name('question_choices.update');

Route::patch('/question_choices/{question_choice}', [QuestionChoiceController::class, 'update'])->name('question_choices.update');



