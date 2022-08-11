<?php

namespace Maize\Cache\Serializer;

class DefaultSerializer implements CacheSerializer
{
    public function serialize(mixed $value): string
    {
        return serialize($value);
    }

    public function unserialize(string $payload): mixed
    {
        return unserialize($payload);
    }
}
