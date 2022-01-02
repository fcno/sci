<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @link https://laravel.com/docs/8.x/migrations
 * @link https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 */
class CreatePerfisPermanentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('perfis_permanentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cargo_id')->nullable();
            $table->unsignedBigInteger('funcao_id')->nullable();
            $table->unsignedBigInteger('lotacao_id')->nullable();
            $table->unsignedBigInteger('perfil_id');

            $table->timestamps();

            $table->unique(['cargo_id', 'funcao_id', 'lotacao_id']);

            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('funcao_id')->references('id')->on('funcoes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lotacao_id')->references('id')->on('lotacoes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('perfis_permanentes');
    }
}
