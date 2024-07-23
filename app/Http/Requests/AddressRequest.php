<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AddressRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return true;
    // }


    public $id_request;
 
	public function authorize()
	{
		return true;
	}
 
	public function rules()
	{
        $this->id_request = $this->route('id');
		return match ($this->method()) {
			'POST' => $this->store(),
			'PUT', 'PATCH' => $this->update(),
			default => $this->view()
		};
	}
 
	public function store()
	{
        return [
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'token' => 'required|string|min:32|max:32',
        ];
    }
 
	public function update()
	{
		return [];
    }
 
	public function view()
	{
		return [];
	}
 
	public function messages()
	{
		return [];
	}
 
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message' => 'Erro de validação de atributo','error' => $validator->errors()], Response::HTTP_NOT_ACCEPTABLE));
	}
}

