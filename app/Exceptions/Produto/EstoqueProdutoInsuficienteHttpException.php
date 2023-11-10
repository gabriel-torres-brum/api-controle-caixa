<?php

namespace App\Exceptions\Produto;

use Symfony\Component\HttpKernel\Exception\HttpException;

class EstoqueProdutoInsuficienteHttpException extends HttpException
{
    protected const STATUS_CODE = 400;
    protected const MESSAGE = 'Estoque do produto insuficiente.';

    public function __construct(\Throwable $previous = null, array $headers = [])
    {
        parent::__construct(self::STATUS_CODE, self::MESSAGE, $previous, $headers);
    }
}
