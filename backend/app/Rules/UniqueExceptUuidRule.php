<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueExceptUuidRule implements Rule
{
    private string $table;
    private string $column;
    private string $uuid;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $column, $uuid)
    {
        $this->table = $table;
        $this->column = $column;
        $this->uuid = $uuid;
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
        if (DB::table($this->table)->where('uuid', '<>', $this->uuid)->where($this->column, $value)->count()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This e-mail has already been taken.';
    }
}
