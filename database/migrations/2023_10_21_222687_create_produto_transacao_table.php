<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produto_transacao', function (Blueprint $table) {
            $table->foreignUuid('transacao_id')->constrained('transacoes');
            $table->foreignUuid('produto_id')->constrained('produtos');
            $table->string('quantidade');
            $table->string('valor_unidade_final')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto_transacao');
    }
};
