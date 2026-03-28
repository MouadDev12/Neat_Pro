<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->isAdmin(); }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $userId],
            'role'     => ['required', 'in:admin,manager,user'],
            'password' => [$userId ? 'nullable' : 'required', 'min:8', 'confirmed'],
        ];
    }
}
