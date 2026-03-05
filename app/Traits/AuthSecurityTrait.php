<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

trait AuthSecurityTrait
{
    protected function strongPasswordRules(): array
    {
        $commonPasswords = [
            '123456',
            '12345678',
            'password',
            'qwerty',
            '111111',
            '123123',
            'admin123',
            'password123',
        ];

        return [
            'required',
            'confirmed',
            Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
            function (string $attribute, mixed $value, \Closure $fail) use ($commonPasswords): void {
                if (in_array(strtolower((string) $value), $commonPasswords, true)) {
                    $fail('The selected password is too common.');
                }
            },
        ];
    }

    protected function issueVerificationCode(User $user, string $target, string $channel = 'email'): string
    {
        $code = (string) random_int(1000, 9999);
        $user->forceFill([
            'verification_code_hash' => Hash::make($code),
            'verification_code_expires_at' => now()->addMinutes(10),
            'verification_code_target' => $target,
            'verification_code_channel' => $channel,
        ])->save();

        return $code;
    }

    protected function checkVerificationCode(User $user, string $code): bool
    {
        if (
            empty($user->verification_code_hash) ||
            is_null($user->verification_code_expires_at) ||
            now()->greaterThan($user->verification_code_expires_at)
        ) {
            return false;
        }

        return Hash::check($code, $user->verification_code_hash);
    }

    protected function clearVerificationCode(User $user): void
    {
        $user->forceFill([
            'verification_code_hash' => null,
            'verification_code_expires_at' => null,
            'verification_code_target' => null,
            'verification_code_channel' => null,
        ])->save();
    }

    protected function issueResetCode(User $user, string $target, string $channel = 'email'): string
    {
        $code = (string) random_int(1000, 9999);
        $user->forceFill([
            'reset_code_hash' => Hash::make($code),
            'reset_code_expires_at' => now()->addMinutes(10),
            'reset_code_target' => $target,
            'reset_code_channel' => $channel,
        ])->save();

        return $code;
    }

    protected function checkResetCode(User $user, string $code): bool
    {
        if (
            empty($user->reset_code_hash) ||
            is_null($user->reset_code_expires_at) ||
            now()->greaterThan($user->reset_code_expires_at)
        ) {
            return false;
        }

        return Hash::check($code, $user->reset_code_hash);
    }

    protected function clearResetCode(User $user): void
    {
        $user->forceFill([
            'reset_code_hash' => null,
            'reset_code_expires_at' => null,
            'reset_code_target' => null,
            'reset_code_channel' => null,
        ])->save();
    }
}
