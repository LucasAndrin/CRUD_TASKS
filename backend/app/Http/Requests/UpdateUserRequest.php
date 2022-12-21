<?php

namespace App\Http\Requests;

use App\Rules\UniqueExceptUuidRule;
use App\Rules\UserTypeRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => ['required', 'uuid', 'exists:users,uuid'],
            'name' => ['required', 'min:3', 'max:50'],
            'email' => ['required', 'email', new UniqueExceptUuidRule('users', 'email', $this->uuid)],
            'type' => ['required', new UserTypeRule]
        ];
    }
}
