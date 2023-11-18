<?php

namespace App\Exceptions;

use App\Exceptions\CustomException;
use Illuminate\Http\Response;

class CaixaAindaTemTransacoesAbertasException extends CustomException
{
    public function statusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function friendlyMessage(): string
    {
        return 'Ainda existem transações abertas para o caixa.';
    }
}
