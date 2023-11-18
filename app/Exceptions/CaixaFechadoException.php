<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class CaixaFechadoException extends CustomException
{
    public function statusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function friendlyMessage(): string
    {
        return 'Este caixa já está fechado.';
    }
}
