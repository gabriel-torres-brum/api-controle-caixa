<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Produto;
use App\Models\User;
use App\Models\UnidadeMedida;
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

        $kilos = UnidadeMedida::create([
            'nome' => 'kilos',
            'label' => 'KG',
            'decimais' => 3,
        ]);

        $unidades = UnidadeMedida::create([
            'nome' => 'unidades',
            'label' => 'Unidades',
            'decimais' => 0,
        ]);

        $litros = UnidadeMedida::create([
            'nome' => 'litros',
            'label' => 'Litros',
            'decimais' => 2,
        ]);

        // Criando produtos
        $tenisNike = Produto::create([
            'codigo' => 'TN001',
            'nome' => 'Tênis Nike',
            'unidade_medida_id' => $unidades->id,
            'valor_unidade' => 200,
            'qtd_estoque' => 100,
        ]);

        $paoFrances = Produto::create([
            'codigo' => 'PF001',
            'nome' => 'Pão francês',
            'unidade_medida_id' => $kilos->id,
            'valor_unidade' => 0.5,
            'qtd_estoque' => 200,
        ]);

        $acai = Produto::create([
            'codigo' => 'AC001',
            'nome' => 'Açaí',
            'valor_unidade' => 10,
            'unidade_medida_id' => $litros->id,
            'qtd_estoque' => 50,
        ]);

        $cacauEmPo = Produto::create([
            'codigo' => 'CP001',
            'nome' => 'Cacau em pó',
            'valor_unidade' => 154.98,
            'unidade_medida_id' => $kilos->id,
            'qtd_estoque' => 752,
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
