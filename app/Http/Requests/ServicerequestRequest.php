<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class ServicerequestRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:user,email',
            'hardware_id' => 'required',
            'daterequest'=>'required|date',
            'description' => 'required|string'
       ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errors de validación',
            'data'      => [$validator->errors()]
            ]));
    }

    public function messages()
    {
        return [
            'email.required' => 'Es necesario indicar el solicitante',
            'hardware.required' => 'Es necesario indicar el equipo de la falla',
            'daterequest.required' => 'Es necesario indicar la fecha de elaboración',
            'description.required' => 'Es necesario indicar la falla o el servicio'
        ];
    }

}