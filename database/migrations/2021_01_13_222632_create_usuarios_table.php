<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @link https://laravel.com/docs/8.x/migrations
 * @link https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 * @link https://docs.microsoft.com/pt-br/windows/win32/adschema/a-samaccountname?redirectedfrom=MSDN
 */
class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lotacao_id')->nullable();
            $table->unsignedBigInteger('cargo_id')->nullable();
            $table->unsignedBigInteger('funcao_id')->nullable();
            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->string('nome', 255)->nullable();
            $table->string('sigla', 20)->unique();
            $table->timestamps();

            $table->foreign('lotacao_id')->references('id')->on('lotacoes')->onUpdate('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onUpdate('cascade');
            $table->foreign('funcao_id')->references('id')->on('funcoes')->onUpdate('cascade');
            $table->foreign('perfil_id')->references('id')->on('perfis')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
}
