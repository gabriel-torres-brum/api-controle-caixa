<?php

namespace App\Exceptions\Transacao;

use Symfony\Component\HttpKernel\Exception\HttpException;

class StatusTransacaoInvalidoParaAdicionarProdutosHttpException extends HttpException
{
    protected const STATUS_CODE = 400;
    protected const MESSAGE = 'O status da transação é inválido para adicionar produtos.';

    public function __construct(\Throwable $previous = null, array $headers = [])
    {
        parent::__construct(self::STATUS_CODE, self::MESSAGE, $previous, $headers);
    }
}
