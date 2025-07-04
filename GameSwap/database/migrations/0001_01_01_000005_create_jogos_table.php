<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('produtos')) {
            Schema::create('produtos', function (Blueprint $table) {
                $table->id(); // ID do jogo
                $table->string('nome'); // Nome do jogo
                $table->text('descricao')->nullable(); // Descrição do jogo
                $table->decimal('preco', 10, 2); // Preço do jogo
                $table->unsignedBigInteger('id_categoria'); // Categoria do jogo
                $table->string('estado'); // Estado do jogo (novo/usado)
                $table->boolean('moderado')->default(false); // Produto moderado
                $table->unsignedBigInteger('id_anunciante'); // ID do anunciante
                $table->unsignedBigInteger('id_comprador')->nullable(); // ID do comprador
                $table->string('desenvolvedor')->nullable(); // Desenvolvedor do jogo
                $table->string('publicador')->nullable(); // Publicador do jogo
                $table->year('ano_lancamento')->nullable(); // Ano de lançamento
                $table->string('console_id')->nullable();
                $table->string('idiomas')->nullable(); // Idiomas disponíveis
                $table->string('classificacao')->nullable(); // Classificação etária
                $table->string('regiao')->nullable(); // Região do jogo
                $table->string('tipo_produto'); // Tipo do jogo (jogo/console)
                $table->string('morada')->nullable(); // Morada do jogo
                $table->timestamps(); // Campos created_at e updated_at

                // Relacionamentos
                $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
                $table->foreign('id_anunciante')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('id_comprador')->references('id')->on('users')->onDelete('set null');
                $table->foreign('console_id')->references('nome')->on('modelo_consoles')->ondelete('set null')->nullable(); // Tipo de console (se aplicável)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
