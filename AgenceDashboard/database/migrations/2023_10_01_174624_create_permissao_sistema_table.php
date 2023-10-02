<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao_sistema', function (Blueprint $table) {
            $table->string('co_usuario', 20)->default('');
            $table->bigInteger('co_tipo_usuario')->unsigned()->default(0);
            $table->bigInteger('co_sistema')->unsigned()->default(0);
            $table->char('in_ativo', 1)->default('S');
            $table->string('co_usuario_atualizacao', 20)->charset('utf8')->nullable();
            $table->dateTime('dt_atualizacao')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->primary('co_usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissao_sistema');
    }
};
