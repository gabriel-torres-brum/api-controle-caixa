<?php

namespace App\Models;

use App\Models\Statuses\Transacao\TransacaoStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\ModelStates\HasStates;

class Transacao extends Model
{
    use HasFactory, HasUuids, HasStates;

    protected $table = 'transacoes';
    protected $guarded = [];
    protected $casts = [
        'status' => TransacaoStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'produto_transacao')
            ->withPivot(['quantidade', 'valor_unidade_final']);
    }

    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }
}
