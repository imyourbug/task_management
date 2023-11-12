<?php

namespace App\Http\Requests\Admin\Accounts;

use App\Http\Requests\BaseRequest;

class CreateAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'email' => 'required|email:dns,rfc',
            'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'role' => 'required|integer|in:0,1',
            'gender' => 'required|integer|in:0,1,2',
            'birthdate' => 'required',
        ];
    }
}
