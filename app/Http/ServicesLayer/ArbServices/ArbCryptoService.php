<?php

namespace App\Http\ServicesLayer\ArbServices;

class ArbCryptoService
{
    private const IV = 'PGKEYENCDECIVSPC';

    public function encrypt(string $plainText, string $resourceKey): string
    {
        $cipher = $this->resolveCipher($resourceKey);
        $padded = $this->pkcs5Pad($plainText);
        $encrypted = openssl_encrypt($padded, $cipher, $resourceKey, OPENSSL_ZERO_PADDING, self::IV);

        if ($encrypted === false) {
            throw new \RuntimeException('Failed to encrypt ARB trandata.');
        }

        $raw = base64_decode($encrypted, true);
        if ($raw === false) {
            throw new \RuntimeException('Failed to normalize ARB encrypted trandata.');
        }

        return urlencode(bin2hex($raw));
    }

    public function decrypt(string $encryptedText, string $resourceKey): string
    {
        $cipher = $this->resolveCipher($resourceKey);

        $normalized = urldecode(trim($encryptedText));
        if (ctype_xdigit($normalized) && strlen($normalized) % 2 === 0) {
            $decoded = hex2bin($normalized);
        } else {
            $decoded = base64_decode($normalized, true);
        }

        if ($decoded === false) {
            throw new \RuntimeException('Invalid ARB trandata encoding.');
        }

        $decrypted = openssl_decrypt(base64_encode($decoded), $cipher, $resourceKey, OPENSSL_ZERO_PADDING, self::IV);
        if ($decrypted === false) {
            throw new \RuntimeException('Failed to decrypt ARB trandata.');
        }

        return trim($this->pkcs5Unpad($decrypted));
    }

    private function pkcs5Pad(string $text): string
    {
        $pad = 16 - (strlen($text) % 16);

        return $text . str_repeat(chr($pad), $pad);
    }

    private function pkcs5Unpad(string $text): string
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 16) {
            return $text;
        }

        return substr($text, 0, -$pad);
    }

    private function resolveCipher(string $resourceKey): string
    {
        $keyLength = strlen($resourceKey);

        return match ($keyLength) {
            16 => 'AES-128-CBC',
            24 => 'AES-192-CBC',
            32 => 'AES-256-CBC',
            default => throw new \InvalidArgumentException('ARB resource key must be 16, 24, or 32 bytes.'),
        };
    }
}
