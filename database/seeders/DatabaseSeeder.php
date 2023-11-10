<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Produto;
use App\Models\TipoEstoque;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Criando tipos de estoque
        $unidade = TipoEstoque::create([
            'nome' => 'Unidade',
            'descricao' => 'Unidade',
            'quantidade_decimal_unidade' => 1,
        ]);

        $litros = TipoEstoque::create([
            'nome' => 'Litros',
            'descricao' => 'Litros',
            'quantidade_decimal_unidade' => 1,
        ]);

        $kilos = TipoEstoque::create([
            'nome' => 'Kilos',
            'descricao' => 'Kilos',
            'quantidade_decimal_unidade' => 1,
        ]);

        // Criando produtos
        $tenisNike = Produto::create([
            'codigo' => 'TN001',
            'nome' => 'Tênis Nike',
            'valor_unidade' => 200,
            'porcentagem_lucro_unidade' => 20,
            'tipo_estoque_id' => $unidade->id,
            'quantidade_estoque' => 100,
        ]);

        $paoFrances = Produto::create([
            'codigo' => 'PF001',
            'nome' => 'Pão francês',
            'valor_unidade' => 0.5,
            'porcentagem_lucro_unidade' => 10,
            'tipo_estoque_id' => $kilos->id,
            'quantidade_estoque' => 200,
        ]);

        $acai = Produto::create([
            'codigo' => 'AC001',
            'nome' => 'Açaí',
            'valor_unidade' => 10,
            'porcentagem_lucro_unidade' => 15,
            'tipo_estoque_id' => $litros->id,
            'quantidade_estoque' => 50,
        ]);

        $cacauEmPo = Produto::create([
            'codigo' => 'CP001',
            'nome' => 'Cacau em pó',
            'valor_unidade' => 15,
            'porcentagem_lucro_unidade' => 20,
            'tipo_estoque_id' => $kilos->id,
            'quantidade_estoque' => 75,
        ]);

        // Criando usuários
        $gabriel = User::create([
            'name' => 'Gabriel',
            'email' => 'gabriel@example.com',
            'password' => Hash::make('password'), // substitua 'password' pela senha real
        ]);

        $miguel = User::create([
            'name' => 'Miguel',
            'email' => 'miguel@example.com',
            'password' => Hash::make('password'), // substitua 'password' pela senha real
        ]);
    }
}
