<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Impressora extends Model
{
    use HasFactory;

    protected $table = 'impressoras';

    protected $fillable = ['nome'];

    public function impressoes(): HasMany
    {
        return $this->hasMany(Impressao::class, 'impressora_id', 'id');
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
