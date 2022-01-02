<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @link https://laravel.com/docs/8.x/eloquent
 */
class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = ['nome'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function impressoes(): HasMany
    {
        return $this->hasMany(Impressao::class, 'cliente_id', 'id');
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
