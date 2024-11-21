<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PackageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'saida.cidade' => 'required|string|max:255',
            'saida.estado' => 'required|string|max:2',
            'saida.endereco' => 'required|string|max:255',
            'saida.latitude' => 'required|numeric',
            'saida.longitude' => 'required|numeric',
            'chegada.cidade' => 'required|string|max:255',
            'chegada.estado' => 'required|string|max:2',
            'chegada.endereco' => 'required|string|max:255',
            'chegada.latitude' => 'required|numeric',
            'chegada.longitude' => 'required|numeric',
            'pacote.largura' => 'required|numeric|min:0',
            'pacote.altura' => 'required|numeric|min:0',
            'pacote.peso' => 'required|numeric|min:0',
            'pacote.fragilidade' => 'required|string|max:255',
            'pacote.descricao' => 'nullable|string|max:1000',
            'pacote.metrica_largura' => 'required|string|max:50',
            'pacote.metrica_altura' => 'required|string|max:50',
            'pacote.metrica_peso' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'saida.cidade.required' => 'A cidade de saída é obrigatória.',
            'saida.estado.required' => 'O estado de saída é obrigatório.',
            'saida.endereco.required' => 'O endereço de saída é obrigatório.',
            'saida.latitude.required' => 'A latitude de saída é obrigatória.',
            'saida.longitude.required' => 'A longitude de saída é obrigatória.',
            'chegada.cidade.required' => 'A cidade de chegada é obrigatória.',
            'chegada.estado.required' => 'O estado de chegada é obrigatório.',
            'chegada.endereco.required' => 'O endereço de chegada é obrigatório.',
            'chegada.latitude.required' => 'A latitude de chegada é obrigatória.',
            'chegada.longitude.required' => 'A longitude de chegada é obrigatória.',
            'pacote.largura.required' => 'A largura do pacote é obrigatória.',
            'pacote.altura.required' => 'A altura do pacote é obrigatória.',
            'pacote.peso.required' => 'O peso do pacote é obrigatório.',
            'pacote.fragilidade.required' => 'A fragilidade do pacote é obrigatória.',
            'pacote.metrica_largura.required' => 'A métrica da largura é obrigatória.',
            'pacote.metrica_altura.required' => 'A métrica da altura é obrigatória.',
            'pacote.metrica_peso.required' => 'A métrica do peso é obrigatória.',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
