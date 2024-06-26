<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->comment('用户ID');
            $table->string('title', 100)->nullable()->comment('标题');
            $table->string('slug');
            $table->string('excerpt')->nullable()->comment('文章摘要');
            $table->longText('body')->comment('内容');
            $table->enum('type', ['page', 'article', 'tweet'])->default('article')->comment('类型');
            $table->enum('status', ['published', 'draft', 'rejected'])->default('draft')->comment('状态');
            $table->enum('commentable', ['open', 'closed'])->default('open')->comment('是否允许评论');
            $table->timestamp('pinned_at')->nullable()->comment('置顶时间');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
