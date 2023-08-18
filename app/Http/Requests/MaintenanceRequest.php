<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class MaintenanceRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schoolcycle' => 'required|unique:maintenanceschedule|string|max:50',
            'year' => 'required|digits:4',
            'whoelaborated' => 'required|string|email|max:50|exists:user,email',
            'dateofpreparation' => 'required'
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
            'schoolcycle.required' => 'Es necesario indicar el ciclo escolar',
            'schoolcycle.unique' => 'El ciclo escolar :input  ya está registrada',
            'year.required' => 'Es necesario indicar el año de 4 digitos',
            'year.digits' => 'El año debe ser de :digits digitos',
            'whoelaborated.required' => 'Es necesario indicar quien elabora el documento',
            'whoelaborated.email' => 'No tiene formato de correo electrónico'
        ];
    }

}