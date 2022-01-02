<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @link https://laravel.com/docs/8.x/migrations
 * @link https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 */
class CreatePerfisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('perfis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->string('descricao', 400)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('perfis');
    }
}
