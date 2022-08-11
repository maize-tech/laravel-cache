<?php

use Maize\Cache\Cache;
use Maize\Cache\Tests\Support\TestCase;

uses(TestCase::class)->in(__DIR__);

function hashedKeyFor(Cache $cache, string $key): string
{
    return invade($cache)->hasher->getHashedKeyFor($key);
}

function cacheHas(Cache $cache, string $key): bool
{
    return cache()->has(hashedKeyFor($cache, $key));
}

function assertCacheHasKey(Cache $cache, string $key, bool $enabled = true): void
{
    expect(
        $enabled
        ? cacheHas($cache, 'test')
        : true
    )->toBeTrue();
}

function assertCacheMissingKey(Cache $cache, string $key, bool $enabled = true): void
{
    expect(
        $enabled
        ? cacheHas($cache, 'test')
        : false
    )->toBeFalse();
}
