<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://laravel.com/docs/8.x/migrations
 * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 */
class CreateLogsFuncionamentoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs_funcionamento', function (Blueprint $table) {
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
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_funcionamento');
    }
}
