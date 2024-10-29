<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        //validacion del rol, si es 1 o 2, si es 1(estudiante) se debe asignar a la variable estado_id el valor 1(activo)
        $estado_id = $input['rol_id'] == 1 ? 1 : 2;

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'fecha_nacimiento' => $input['fecha_nacimiento'],
            'telefono' => $input['telefono'],
            'estado_id' => $estado_id,
            'password' => Hash::make($input['password']),
            'rol_id' => $input['rol_id'],
        ]);
    }
}
