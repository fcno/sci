<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * @link https://laravel.com/docs/8.x/eloquent
 */
class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = ['sigla', 'nome', 'lotacao_id', 'cargo_id', 'funcao_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lotacao(): BelongsTo
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcao(): BelongsTo
    {
        return $this->belongsTo(Funcao::class, 'funcao_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class, 'perfil_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function impressoes(): HasMany
    {
        return $this->hasMany(Impressao::class, 'usuario_id', 'id');
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
