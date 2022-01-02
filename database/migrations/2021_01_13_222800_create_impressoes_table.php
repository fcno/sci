<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://laravel.com/docs/8.x/migrations
 * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 * @see https://docs.microsoft.com/en-us/windows/win32/fileio/maximum-file-path-limitation
 */
class CreateImpressoesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('impressoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('lotacao_id')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('impressora_id');
            $table->unsignedBigInteger('servidor_id');
            $table->date('data');
            $table->time('hora');
            $table->string('nome_arquivo', 260)->nullable();
            $table->unsignedBigInteger('tamanho_arquivo')->nullable();
            $table->unsignedBigInteger('qtd_pagina');
            $table->unsignedBigInteger('qtd_copia');
            $table->timestamps();

            $table->unique(['data', 'hora', 'usuario_id', 'impressora_id']);

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lotacao_id')->references('id')->on('lotacoes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('impressora_id')->references('id')->on('impressoras')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('servidor_id')->references('id')->on('servidores')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impressoes');
    }
}
