<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @link https://laravel.com/docs/8.x/migrations
 * @link https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 */
class CreateLogsFuncionamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('log_funcionamento', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            // data que ocorreu a última importação do log de impressão
            $table->date('ult_import_impressao')->nullable();
            // data que ocorreu a última importação do arquivo corporativo
            $table->date('ult_import_corporativo')->nullable();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('log_funcionamento');
    }
}
