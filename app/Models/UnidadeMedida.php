<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadeMedida extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'unidades_medida';
    protected $guarded = [];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
