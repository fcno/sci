<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * @link https://laravel.com/docs/8.x/eloquent
 */
class Lotacao extends Model
{
    use HasFactory;

    protected $table = 'lotacoes';

    protected $fillable = ['id', 'lotacao_pai', 'nome', 'sigla'];

    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lotacaoPai(): BelongsTo
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_pai', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lotacoesFilha(): HasMany
    {
        return $this->hasMany(Lotacao::class, 'lotacao_pai', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'lotacao_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function impressoes(): HasMany
    {
        return $this->hasMany(Impressao::class, 'lotacao_id', 'id');
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
