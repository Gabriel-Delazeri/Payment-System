<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|min:3|max:30',
            'document_id' => 'required|numeric' ,
            'email'       => 'required|email',
            'password'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'min'      => 'O campo :attribute deve ter no mínimo :min caracteres',
            'max'      => 'O campo :attribute deve ter no máximo :max caracteres',
            'numeric'  => 'O campo :attribute deve ser preenchido somente por números',
            'email'    => 'O campo :attribute deve receber um endereço de e-mail válido',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'errors' => $validator->errors(),
        'status' => false
        ], 422));
    }
}
