<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

abstract class CustomException extends Exception
{
    abstract public function statusCode(): int;

    abstract public function friendlyMessage(): string;

    public function render(): Response
    {
        return response(['message' => $this->friendlyMessage()], $this->statusCode());
    }
}
