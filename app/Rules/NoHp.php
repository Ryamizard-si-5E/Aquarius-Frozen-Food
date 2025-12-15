<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class NoHp implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!preg_match('/^08[0-9]{8,12}$/', $value)) {
            $fail("Format nomor HP tidak valid.");
        }
    }
}
