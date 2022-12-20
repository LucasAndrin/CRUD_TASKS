<?php

namespace App\Rules;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CorrectPasswordByEmailRule implements Rule
{
    private string $email;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $userRepository = new UserRepository(new User());

        $user = $userRepository->findUserByEmail(trim($this->email));

        if ($user && Hash::check($value, $user->password)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Icorrect password!';
    }
}
