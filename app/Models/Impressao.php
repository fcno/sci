<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Impressao extends Model
{
    use HasFactory;

    protected $table = 'impressoes';

    protected $fillable = [
        'data',
        'hora',
        'nome_arquivo',
        'tamanho_arquivo',
        'qtd_pagina',
        'qtd_copia',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function impressora(): BelongsTo
    {
        return $this->belongsTo(Impressora::class, 'impressora_id', 'id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function servidor(): BelongsTo
    {
        return $this->belongsTo(Servidor::class, 'servidor_id', 'id');
    }

    public function lotacao(): BelongsTo
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_id', 'id');
    }
}
