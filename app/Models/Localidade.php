<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Localidade extends Model
{
    use HasFactory;

    protected $table = 'localidades';

    public function servidores(): BelongsToMany
    {
        return $this->belongsToMany(Servidor::class, 'localidade_servidor', 'localidade_id', 'servidor_id')->withTimestamps();
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
