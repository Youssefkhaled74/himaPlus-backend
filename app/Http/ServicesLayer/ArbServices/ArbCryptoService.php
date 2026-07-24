<?php

namespace App\Http\ServicesLayer\ArbServices;

class ArbCryptoService
{
    private const IV = 'PGKEYENCDECIVSPC';

    public function encrypt(string $plainText, string $resourceKey): string
    {
        $key = $this->decodeKey($resourceKey);
        $cipher = $this->resolveCipher($key);
        $encrypted = openssl_encrypt($plainText, $cipher, $key, OPENSSL_RAW_DATA, self::IV);

        if ($encrypted === false) {
            throw new \RuntimeException('Failed to encrypt ARB trandata.');
        }

        return bin2hex($encrypted);
    }

    public function decrypt(string $encryptedText, string $resourceKey): string
    {
        $key = $this->decodeKey($resourceKey);
        $cipher = $this->resolveCipher($key);

        $normalized = urldecode(trim($encryptedText));
        if (ctype_xdigit($normalized) && strlen($normalized) % 2 === 0) {
            $decoded = hex2bin($normalized);
        } else {
            $decoded = base64_decode($normalized, true);
        }

        if ($decoded === false) {
            throw new \RuntimeException('Invalid ARB trandata encoding.');
        }

        $decrypted = openssl_decrypt($decoded, $cipher, $key, OPENSSL_RAW_DATA, self::IV);
        if ($decrypted === false) {
            throw new \RuntimeException('Failed to decrypt ARB trandata.');
        }

        return trim($decrypted);
    }

    private function decodeKey(string $resourceKey): string
    {
        $hexDecoded = @hex2bin($resourceKey);
        if ($hexDecoded !== false && strlen($hexDecoded) === 16) {
            return $hexDecoded;
        }

        return $resourceKey;
    }

    private function resolveCipher(string $key): string
    {
        $keyLength = strlen($key);

        return match ($keyLength) {
            16 => 'AES-128-CBC',
            24 => 'AES-192-CBC',
            32 => 'AES-256-CBC',
            default => throw new \InvalidArgumentException('ARB resource key must be 16, 24, or 32 bytes.'),
        };
    }
}
