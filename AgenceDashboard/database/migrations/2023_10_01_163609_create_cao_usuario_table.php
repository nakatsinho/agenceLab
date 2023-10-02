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
        Schema::create('cao_usuario', function (Blueprint $table) {
            $table->string('co_usuario', 20)->primary();
            $table->string('no_usuario', 50);
            $table->string('ds_senha', 14);
            $table->string('co_usuario_autorizacao', 20)->nullable();
            $table->bigInteger('nu_matricula')->unsigned()->nullable();
            $table->date('dt_nascimento')->nullable();
            $table->date('dt_admissao_empresa')->nullable();
            $table->date('dt_desligamento')->nullable();
            $table->dateTime('dt_inclusao')->default(DB::raw('current_timestamp()'));
            $table->date('dt_expiracao')->default('2000-01-01');
            $table->string('nu_cpf', 14)->nullable();
            $table->string('nu_rg', 20)->nullable();
            $table->string('no_orgao_emissor', 10)->nullable();
            $table->string('uf_orgao_emissor', 2)->nullable();
            $table->string('ds_endereco', 150)->nullable();
            $table->string('no_email', 100)->nullable();
            $table->string('no_email_pessoal', 100)->nullable();
            $table->string('nu_telefone', 64)->nullable();
            $table->dateTime('dt_alteracao')->default(DB::raw('current_timestamp()'));
            $table->string('url_foto', 255)->nullable();
            $table->string('instant_messenger', 80)->nullable();
            $table->bigInteger('icq')->unsigned()->nullable();
            $table->string('msn', 50)->nullable();
            $table->string('yms', 50)->nullable();
            $table->string('ds_comp_end', 50)->nullable();
            $table->string('ds_bairro', 30)->nullable();
            $table->string('nu_cep', 10)->nullable();
            $table->string('no_cidade', 50)->nullable();
            $table->string('uf_cidade', 2)->nullable();
            $table->date('dt_expedicao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cao_usuario');
    }
};
