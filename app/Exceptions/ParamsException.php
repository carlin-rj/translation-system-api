<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use App\Tools\Http\HttpCode;
use Illuminate\Validation\ValidationException;

class ParamsException extends BaseException
{

    public function __construct($message, $code = ApiCodeEnum::HTTP_UNPROCESSABLE_ENTITY, mixed $data = null, int $httpCode = HttpCode::HTTP_OK)
    {
        $errorMessage = '';
        if ($message instanceof ValidationException) {
            $errorMessage =  $this->renderErrorMessage($message->errors());
            $data = $message->errors();
            $data = [
                'filed_errors'=>$data
            ];
        }
        parent::__construct($errorMessage, $code, $data, $httpCode);
    }


    private function renderErrorMessage($errors):string
    {
        $message = '';
        $uniqueErrors = [];
        foreach ($errors as $error) {
            $uniqueErrors [] = $error[0];
        }
        $uniqueErrors = array_unique($uniqueErrors);
        foreach ($uniqueErrors as $uniqueError) {
            $message .= $uniqueError.'| ';
        }
        return trim($message, '| ');
    }
}
