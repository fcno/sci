<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @link https://laravel.com/docs/8.x/eloquent
 */
class Funcao extends Model
{
    use HasFactory;

    protected $table = 'funcoes';

    protected $fillable = ['id', 'nome'];

    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'funcao_id', 'id');
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
