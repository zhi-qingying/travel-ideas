<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelIdeaController; // 引入你的控制器
use App\Http\Controllers\CommentController;    // 引入评论控制器

// 首页：直接重定向到旅游想法大厅会更符合我们的项目逻辑
Route::get('/', function () {
    return redirect()->route('ideas.index');
});

// 认证路由（登录、注册、退出）
Auth::routes();

// 需要登录才能访问的路由
Route::middleware(['auth'])->group(function () {
    
    // 首页/仪表盘 (Laravel 默认保留)
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // ========== 资料管理 (Zhi Qingying 的部分) ==========
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');    

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ========== 旅行点子相关路由 (Yu Yinran 的部分) ==========
    // 这一行代码等同于 Zhi 截图中写的四行代码，且包含了 edit/update/destroy
    Route::resource('ideas', TravelIdeaController::class);
    
    // ========== 评论与交互相关路由 (Zhao Tiening 的部分) ==========
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    
});