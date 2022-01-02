<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Lotacao extends Model
{
    use HasFactory;

    protected $table = 'lotacoes';

    protected $fillable = ['id', 'lotacao_pai', 'nome', 'sigla'];

    public $incrementing = false;

    public function lotacaoPai(): BelongsTo
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_pai', 'id');
    }

    public function lotacoesFilha(): HasMany
    {
        return $this->hasMany(Lotacao::class, 'lotacao_pai', 'id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'lotacao_id', 'id');
    }

    public function impressoes(): HasMany
    {
        return $this->hasMany(Impressao::class, 'lotacao_id', 'id');
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
