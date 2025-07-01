<?php

namespace App\Http\Requests\V1\Person;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'name_opcional' => 'sometimes|string|min:0|max:255',
            'documento' => 'required|string|min:11|max:14',
            'documento_complementar' => 'sometimes|string|min:0|max:255',
            'email' => 'sometimes|string|email|max:255',
            'nascimento_fundacao' => 'sometimes|date_format:Y-m-d|before_or_equal:' . now()->format('Y-m-d'),
            'sexo' => 'sometimes|in:m,f',
            'tipo' => 'sometimes|in:fisica,juridica',
            'active' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
            'grupo_id' => 'required|exists:App\Grupo,id',
            'endereco' => 'sometimes|array',
            'endereco.logradouro' => 'sometimes|string|min:1|max:255',
            'endereco.numero' => 'sometimes|string|min:1|max:20',
            'endereco.complemento' => 'sometimes|string|min:0|max:255',
            'endereco.bairro' => 'sometimes|string|min:1|max:255',
            'endereco.cidade' => 'sometimes|string|min:1|max:255',
            'endereco.estado_id' => 'sometimes|exists:App\Estado,id',
            'endereco.cep' => 'sometimes|string|min:8|max:9',
            'endereco.pais_id' => 'sometimes|exists:App\Pais,id',
            'endereco.importancia' => 'sometimes|in:principal,secundario',
            'endereco.bloco' => 'sometimes|string|min:0|max:255',
            'endereco.active' => 'sometimes|in:yes,no',
            'endereco.tipo' => 'sometimes|in:casa,apartamento',
            'contatos' => 'sometimes|array',
            'contatos.*.tipo' => 'sometimes|string|in:telefone,fixo',
            'contatos.*.valor' => 'sometimes|string|min:1|max:255',
            'contatos.*.active' => 'sometimes|in:yes,no',
        ];
    }

    protected function prepareForValidation(): void
    {
        $contatos = $this->input('contatos', []);

        $this->merge([
            'documento' => preg_replace('/\D/', '', $this->input('documento')),
            'documento_complementar' => preg_replace('/\D/', '', $this->input('documento_complementar')),
            'endereco.cep' => preg_replace('/\D/', '', $this->input('endereco.cep')),

        ]);

        foreach ($contatos as $index => $contato) {
            if (isset($contato['tipo']) && in_array($contato['tipo'], ['telefone', 'fixo'])) {
                if (isset($contato['valor'])) {
                    $contatos[$index]['valor'] = preg_replace('/\D/', '', $contato['valor']);
                }
            }
        }

        $this->merge([
            'contatos' => $contatos,
        ]);
    }
}
