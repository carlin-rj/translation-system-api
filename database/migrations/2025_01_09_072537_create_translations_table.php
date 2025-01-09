<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_key', 50)->index()->comment('项目标识');
            $table->string('key', 100)->comment('翻译键名');
            $table->text('source_text')->comment('源文本');
            $table->text('target_text')->nullable()->comment('译文');
            $table->string('language', 20)->index()->comment('目标语言');
            $table->tinyInteger('status')->default(0)->index()->comment('状态：0待翻译，1已翻译');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->unique(['project_key', 'key', 'language'], 'unique_translation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
