<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('produto', 200);
            $table->integer('quantidade');
            $table->float('preco', 10, 2);
            $table->string('imagem', 180);
            $table->string('descricao', 600);
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('categoria_id');
            $table->timestamps();

            //foreign key (constraints)
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
