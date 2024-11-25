<?php

use App\Livewire\Welcome;
use App\Livewire\Articles\View;
use App\Livewire\Articles\Articles;
use App\Livewire\Dashboard\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Module\Articles\Category as ArticleCategory;
use App\Livewire\Module\Articles\Posts as ArticlePosts;
use App\Livewire\Module\Articles\SubCategory as ArticleSubCategory;

Route::get('/', Welcome::class);
Route::get('/articles', Articles::class);
Route::get('/articles/{sub_category?}', Articles::class);
Route::get('/article/{slug}', View::class);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::post('/summernote/file/upload', [UploadController::class, 'uploadImageSummernote']);
    Route::post('/summernote/file/delete', [UploadController::class, 'deleteImageSummernote']);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/module/articles/category', ArticleCategory::class);
    Route::get('/module/articles/sub-category', ArticleSubCategory::class);
    Route::get('/module/articles/posts', ArticlePosts::class);
});

Route::group(['middleware' => ['auth', 'role:user']], function () {});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
