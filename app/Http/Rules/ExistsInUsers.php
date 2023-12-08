<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class ExistsInUsers implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if email exists in the users table
        return User::where('email', $value)->exists();
    }

    public function message()
    {
        return 'Wrong email or password';
    }
}
