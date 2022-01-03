<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Localidade;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar localidades em duplicidade, isto é, com nomes iguais', function () {
    expect(
        fn () => Localidade::factory()
                            ->count(2)
                            ->create(['nome' => 'Prédio Principal'])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar localidade com campo inválido', function ($field, $value, $msg) {
    expect(
        fn () => Localidade::factory()
                            ->create([$field => $value])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['nome', Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['nome', null,             'cannot be null'],           //campo obrigatório
]);
