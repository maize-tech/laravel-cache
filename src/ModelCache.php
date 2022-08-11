<?php

namespace Maize\Cache;

use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Maize\Cache\Hasher\ModelHasher;
use Maize\Cache\Serializer\CacheSerializer;

class ModelCache extends Cache
{
    public function __construct(
        Model $model,
        bool $enabled = true,
        ?string $store = null,
        ?string $prefix = null,
        Closure|DateTimeInterface|DateInterval|int|null $ttl = self::TTL_DEFAULT_IN_SECONDS,
        ?ModelHasher $hasher = null,
        ?CacheSerializer $serializer = null
    ) {
        $hasher ??= new ModelHasher(
            model: $model,
            prefix: $prefix
        );

        parent::__construct(
            enabled: $enabled,
            store: $store,
            ttl: $ttl,
            hasher: $hasher,
            serializer: $serializer
        );
    }
}
