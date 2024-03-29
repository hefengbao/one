<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::get('pages/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('tweets', [\App\Http\Controllers\TweetController::class, 'index'])->name('tweets.index');
Route::get('tweets/{slug}', [\App\Http\Controllers\TweetController::class, 'show'])->name('tweets.show');
Route::get('search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('search/categories/{slug}', [\App\Http\Controllers\SearchController::class, 'categories'])->name('search.categories');
Route::get('search/tags/{slug}', [\App\Http\Controllers\SearchController::class, 'tags'])->name('search.tags');
Route::post('post/{slug}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::get('users/{id}/articles', [\App\Http\Controllers\UserController::class, 'articles'])->name('users.articles');
Route::get('users/{id}/tweets', [\App\Http\Controllers\UserController::class, 'tweets'])->name('users.tweets');

/*Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified'], 'as' => 'admin.'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

    Route::put('articles/{id}/pin', [\App\Http\Controllers\Admin\ArticleController::class, 'pin'])->name('articles.pin');
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class)->except(['show']);
    Route::resource('tweets', \App\Http\Controllers\Admin\TweetController::class)->except(['show']);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show']);;
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

    Route::resource('options', \App\Http\Controllers\Admin\OptionController::class)->except(['show']);

    Route::patch('comments/{id}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{id}/pending', [\App\Http\Controllers\Admin\CommentController::class, 'pending'])->name('comments.pending');
    Route::patch('comments/{id}/spam', [\App\Http\Controllers\Admin\CommentController::class, 'spam'])->name('comments.spam');
    Route::patch('comments/{id}/trash', [\App\Http\Controllers\Admin\CommentController::class, 'trash'])->name('comments.trash');
    Route::patch('comments/{id}/restore', [\App\Http\Controllers\Admin\CommentController::class, 'restore'])->name('comments.restore');
    Route::get('comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');

    Route::get('users/{id}/profile', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show', 'edit']);
    Route::patch('users/{id}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');
    Route::get('user/settings', [\App\Http\Controllers\Admin\UserSettingsController::class, 'index'])->name('user.settings.index');
    Route::put('user/settings', [\App\Http\Controllers\Admin\UserSettingsController::class, 'update'])->name('user.settings.update');

    Route::get('tools/backup', [\App\Http\Controllers\Admin\ToolController::class, 'backup_index'])->name('tools.backup_index');
    Route::get('tools/backup_download/{file}', [\App\Http\Controllers\Admin\ToolController::class, 'backup_download'])->name('tools.backup_download');
    Route::delete('tools/backup_delete', [\App\Http\Controllers\Admin\ToolController::class, 'backup_delete'])->name('tools.backup_delete');
    Route::post('tools/backup_run', [\App\Http\Controllers\Admin\ToolController::class, 'backup_run'])->name('tools.backup_run');

    Route::get('editorjs/fetch_url', [\App\Http\Controllers\Admin\EditorjsController::class, 'fetch_url'])->name('editorjs.fetchurl');
    Route::post('editorjs/upload_image', [\App\Http\Controllers\Admin\EditorjsController::class, 'upload_image'])->name('editorjs.uploadimage');
    Route::post('markdown/upload_image', [\App\Http\Controllers\Admin\MarkdownController::class, 'upload_image'])->name('markdown.uploadimage');
});*/

Route::feeds();
