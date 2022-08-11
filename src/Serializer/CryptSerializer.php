<?php

namespace Maize\Cache\Serializer;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class CryptSerializer implements CacheSerializer
{
    public function serialize(mixed $value): string
    {
        return Crypt::encrypt($value);
    }

    public function unserialize(string $payload): mixed
    {
        try {
            return Crypt::decrypt($payload);
        } catch (DecryptException $e) {
            return $payload;
        }
    }
}
