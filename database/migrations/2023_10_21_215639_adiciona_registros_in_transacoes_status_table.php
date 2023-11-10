<?php

use App\Models\TransacoesStatus;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->registros() as $registro) {
            TransacoesStatus::query()->create([
                'nome' => $registro['nome'],
                'label' => $registro['label'],
                'descricao' => $registro['descricao'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->registros() as $registro) {
            TransacoesStatus::query()
                ->where('nome', $registro['nome'])
                ->delete();
        }
    }

    protected function registros(): array
    {
        return [
            [
                'nome' => 'no_carrinho',
                'label' => 'No carrinho',
                'descricao' => 'Transação no carrinho.',
            ],
            [
                'nome' => 'cancelada',
                'label' => 'Cancelada',
                'descricao' => 'Transação cancelada.',
            ],
            [
                'nome' => 'aguardando_pagamento',
                'label' => 'Aguardando pagamento',
                'descricao' => 'Transação aguardando pagamento.',
            ],
            [
                'nome' => 'processando_pagamento',
                'label' => 'Processando pagamento',
                'descricao' => 'Processando pagamento da transação.',
            ],
            [
                'nome' => 'erro_pagamento',
                'label' => 'Erro no pagamento',
                'descricao' => 'Erro ao processar o pagamento da transação.',
            ],
            [
                'nome' => 'finalizada',
                'label' => 'Finalizada',
                'descricao' => 'Transação finalizada.',
            ]
        ];
    }
};
