<?php

namespace App\Http\Requests\Api\V1\Update;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() == 'PUT') {

            return [
                'name'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Solo letras y espacios
                'date_birth'  => ['required', 'date'], // Validación para una fecha
                'phone' => ['required', 'string', 'regex:/^\d{10,15}$/'], // Solo números, entre 10 y 15 dígitos
                'email'  => ['required', 'string', 'email', 'max:255'], // Debe ser un correo válido y único
                'password'  => ['required', 'string', 'min:8', 'confirmed'], // Mínimo 8 caracteres y debe ser confirmado
                'role'  => ['required', 'integer', 'exists:roles,id'], // Ejemplo de roles válidos: admin, user, guest
                'state'  => ['required', 'integer'], // Ejemplo de roles válidos: admin, user, guest
            ];
        } else {
            return [
                'name'  => ['sometimes', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Solo letras y espacios
                'date_birth'  => ['sometimes', 'date'], // Validación para una fecha
                'phone' => ['sometimes', 'string', 'regex:/^\d{10,15}$/'], // Solo números, entre 10 y 15 dígitos
                'email'  => ['sometimes', 'string', 'email', 'max:255'], // Debe ser un correo válido y único
                'password'  => ['sometimes', 'string', 'min:8', 'confirmed'], // Mínimo 8 caracteres y debe ser confirmado
                'role'  => ['sometimes', 'integer', 'exists:roles,id'], // Ejemplo de roles válidos: admin, user, guest
                'state'  => ['sometimes', 'integer'], // Ejemplo de roles válidos: admin, user, guest
            ];
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',

            'date_birth.required' => 'La fecha de nacimiento es obligatoria.',
            'date_birth.date' => 'La fecha de nacimiento debe ser una fecha válida.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.string' => 'El número de teléfono debe ser una cadena de texto.',
            'phone.regex' => 'El número de teléfono debe contener solo dígitos y tener entre 10 y 15 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.max' => 'El correo electrónico no debe exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',

            'role.required' => 'El rol es obligatorio.',
            'role.integer' => 'El rol debe ser Numero',
            'role.exists' => 'El rol seleccionado no es válido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
