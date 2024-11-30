<?php

use App\Livewire\Welcome;
use App\Livewire\Articles\View as AriclesView;
use App\Livewire\Articles\Articles;
use App\Livewire\Dashboard\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Module\Articles\Category as ArticleCategory;
use App\Livewire\Module\Articles\Posts as ArticlePosts;
use App\Livewire\Module\Articles\SubCategory as ArticleSubCategory;
use App\Livewire\Module\Projects\Category as ProjectCategory;
use App\Livewire\Module\Projects\Project;
use App\Livewire\Module\Projects\SubCategory as ProjectSubCategory;
use App\Livewire\Module\Projects\Tag as ProjectTag;
use App\Livewire\Projects\Projects;
use App\Livewire\Projects\View as ProjectsView;

Route::get('/', Welcome::class);
Route::get('/articles', Articles::class);
Route::get('/articles/{sub_category?}', Articles::class);
Route::get('/article/{slug}', AriclesView::class);

Route::get('/projects', Projects::class);
Route::get('/project/{slug}', ProjectsView::class);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::post('/summernote/file/upload', [UploadController::class, 'uploadImageSummernote']);
    Route::post('/summernote/file/delete', [UploadController::class, 'deleteImageSummernote']);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/module/articles/category', ArticleCategory::class);
    Route::get('/module/articles/sub-category', ArticleSubCategory::class);
    Route::get('/module/articles/posts', ArticlePosts::class);

    Route::get('/module/projects/category', ProjectCategory::class);
    Route::get('/module/projects/sub-category', ProjectSubCategory::class);
    Route::get('/module/projects/tag', ProjectTag::class);
    Route::get('/module/projects/project', Project::class);
});

Route::group(['middleware' => ['auth', 'role:user']], function () {});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
