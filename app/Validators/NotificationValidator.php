<?php

namespace App\Validators;

use \App\Exceptions\NotificationException;
use Illuminate\Support\Facades\Validator;

class NotificationValidator
{


    public static function validationCreate(array $dados = [])
    {

        $validator = Validator::make($dados, [
            'message' => 'required',
        ], [
            'message.required' => 'O campo "message" é obrigatório.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
            foreach ($errors->all() as $mensagem) {
                $msg .= $mensagem . '<br/>';
            }

            throw new NotificationException($msg);
        }

        return true;
    }
}
