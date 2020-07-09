<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('client');

        $rules =
        [
            'activity_id'  => 'required',
            'client_id' => 'required|max:20|unique:clients,client_id,'. $id,
            'razao_social' => 'required|max:255',
            'nome_fantasia' => 'required|max:255',
            'type' => 'required',
            'adress' => 'required|max:255',
            'adress_number' => 'required|max:255',
            'adress_district' => 'required|max:255',
            'adress_city' => 'required|max:255',
            'adress_cep' => 'required|max:9',
            'adress_state' => 'required',
            'logo' => 'image'
        ];

        foreach($this->request->get('contacts') as $key => $val)
        {
            $rules['contacts.'.$key.'.contact_type_id'] = 'required';
            $rules['contacts.'.$key.'.email'] = 'nullable|email|max:255';
            $rules['contacts.'.$key.'.contact'] = 'max:255';
            $rules['contacts.'.$key.'.department'] = 'max:255';
            $rules['contacts.'.$key.'.phone'] = 'max:255';
            $rules['contacts.'.$key.'.mobile_phone'] = 'max:255';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $menssages = [];

        foreach($this->request->get('contacts') as $key => $val)
        {
            $menssages['contacts.'.$key.'.contact_type_id'] = 'Tipo de contato é obrigatório';
            $rules['contacts.'.$key.'.email'] = 'Deve informar um email válido';
        }

        return $menssages;
    }
}
