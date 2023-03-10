<?php

namespace App\Http\Requests;

use App\Rules\CorrectPasswordByEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'email' => trim($this->email),
        ]);
    }

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['bail', 'required', 'email', 'exists:users,email'],
            'password' => ['bail', 'required', new CorrectPasswordByEmailRule($this->email)]
        ];
    }
}
