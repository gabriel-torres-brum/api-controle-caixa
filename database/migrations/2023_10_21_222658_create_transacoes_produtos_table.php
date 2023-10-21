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
        Schema::create('transacoes_produtos', function (Blueprint $table) {
            $table->foreignUuid('produto_id')->constrained('produtos');
            $table->foreignUuid('transacao_id')->constrained('transacoes');
            $table->string('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes_produtos');
    }
};
