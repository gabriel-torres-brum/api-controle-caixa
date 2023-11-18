<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoFornecimentoProduto extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'historicos_fornecimentos_produtos';
    protected $guarded = [];

    public function produto()
    {
        return $this->hasMany(Produto::class);
    }
}
