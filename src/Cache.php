<?php

namespace Maize\Cache;

use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache as BaseCache;
use Maize\Cache\Hasher\DefaultHasher;
use Maize\Cache\Serializer\CacheSerializer;
use Maize\Cache\Serializer\CryptSerializer;

abstract class Cache
{
    public const FOREVER = null;

    public const TTL_DEFAULT_IN_SECONDS = 3600;

    protected const FORGET = -5;

    public function __construct(
        protected bool $enabled = true,
        protected ?string $store = null,
        protected Closure|DateTimeInterface|DateInterval|int|null $ttl = self::TTL_DEFAULT_IN_SECONDS,
        protected ?DefaultHasher $hasher = null,
        protected ?CacheSerializer $serializer = null
    ) {
        $this->hasher ??= new DefaultHasher();
        $this->serializer ??= new CryptSerializer();
    }

    public function get(string $key, Closure $callback): mixed
    {
        if (! $this->isEnabled()) {
            return ($callback)();
        }

        return BaseCache::store($this->getStore())->remember(
            $this->getHashedKeyFor($key),
            $this->getTtl(),
            $callback
        );
    }

    public function put(string $key, Closure $callback): mixed
    {
        if (! $this->isEnabled()) {
            return ($callback)();
        }

        BaseCache::store($this->getStore())->put(
            $this->getHashedKeyFor($key),
            $value = ($callback)(),
            $this->getTtl()
        );

        return $value;
    }

    public function forget(string $key, Closure $callback): bool
    {
        if (! $this->isEnabled()) {
            ($callback)();

            return true;
        }

        return BaseCache::store($this->getStore())->put(
            $this->getHashedKeyFor($key),
            ($callback)(),
            self::FORGET
        );
    }

    protected function isEnabled(): bool
    {
        return $this->enabled;
    }

    protected function getStore(): ?string
    {
        return $this->store;
    }

    protected function getHashedKeyFor(string $key): string
    {
        return $this->hasher->getHashedKeyFor($key);
    }

    protected function getTtl(): Closure|DateTimeInterface|DateInterval|int|null
    {
        return $this->ttl;
    }
}
