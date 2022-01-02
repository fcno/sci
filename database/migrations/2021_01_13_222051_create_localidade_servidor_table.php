<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://laravel.com/docs/8.x/migrations
 * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 */
class CreateLocalidadeServidorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('localidade_servidor', function (Blueprint $table) {
            $table->unsignedBigInteger('localidade_id');
            $table->unsignedBigInteger('servidor_id');
            $table->timestamps();

            $table->unique(['localidade_id', 'servidor_id']);

            $table->foreign('localidade_id')->references('id')->on('localidades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('servidor_id')->references('id')->on('servidores')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidade_servidor');
    }
}
