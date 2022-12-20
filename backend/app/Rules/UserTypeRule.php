<?php

namespace App\Rules;

use App\Enums\UserType;
use Illuminate\Contracts\Validation\InvokableRule;

class UserTypeRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!UserType::matches(intval($value))) {
            $fail('Invalid user type.');
        }
    }
}
