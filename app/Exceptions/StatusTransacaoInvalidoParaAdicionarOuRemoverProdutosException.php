<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class StatusTransacaoInvalidoParaAdicionarOuRemoverProdutosException extends CustomException
{
    public function statusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function friendlyMessage(): string
    {
        return 'Não é possível adicionar produtos à transação com o status atual.';
    }
}
