<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class EstoqueProdutoInsuficienteException extends CustomException
{
    public function statusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function friendlyMessage(): string
    {
        return 'Estoque do produto insuficiente.';
    }
}
