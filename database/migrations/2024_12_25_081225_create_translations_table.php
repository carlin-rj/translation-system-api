<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('translations', function (Blueprint $table) {
			$table->id();
			$table->string('project_key', 50)->comment('项目标识');
			$table->string('key', 100)->comment('翻译键名');
			$table->text('source_text')->comment('源文本');
			$table->text('target_text')->nullable()->comment('译文');
			$table->string('language', 20)->comment('目标语言');
			$table->string('language_name', 50)->comment('语言名称');
			$table->tinyInteger('status')->default(0)->comment('状态：0待翻译，1已翻译');
			$table->timestamps();

			// 索引
			$table->index('project_key');
			$table->index('language');
			$table->index('status');
			// 确保同一项目下的 key 和 language 组合唯一
			$table->unique(['project_key', 'key', 'language'], 'unique_translation');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('translations');
	}
};
