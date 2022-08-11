<?php

namespace Maize\Cache\Serializer;

interface CacheSerializer
{
    public function serialize(mixed $value): string;

    public function unserialize(string $payload): mixed;
}
