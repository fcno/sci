<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @link https://laravel.com/docs/8.x/eloquent
 */
class Permissao extends Model
{
    use HasFactory;

    protected $table = 'permissoes';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfis(): BelongsToMany
    {
        return $this->belongsToMany(Perfil::class, 'perfil_permissao', 'permissao_id', 'perfil_id')->withTimestamps();
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
