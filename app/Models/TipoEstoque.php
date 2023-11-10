<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEstoque extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tipos_estoques';
    protected $guarded = [];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
