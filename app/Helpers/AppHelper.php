<?php

namespace App\Helpers;

class AppHelper
{
    public static function getCreateOrUpdateUserErrors($email = null, $documentId = null) : array
    {
        $errors = [];

        if (!is_null($email)) {
            array_push($errors, 'email already in use');
        }

        if (!is_null($documentId)) {
            array_push($errors, 'document already in use');
        }

        return $errors;
    }
}
