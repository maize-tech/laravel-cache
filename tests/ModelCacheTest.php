<?php

// use Maize\Cache\Tests\Support\Models\User;

// use Illuminate\Support\Facades\Cache;
use Maize\Cache\Hasher\ModelHasher;
use Maize\Cache\ModelCache;
use Maize\Cache\Tests\Support\Models\Article;
use Maize\Cache\Tests\Support\Models\User;

it('Model cache: use default model hasher', function () {
    $article = Article::factory()->create();
    $cache = new ModelCache($article);
    expect(invade($cache)->hasher)->toBeInstanceOf(ModelHasher::class);
});

it('Model cache: can store data in cache using get', function () {
    $article = Article::factory()->create();
    $cache = new ModelCache($article);

    assertCacheMissingKey($cache, 'test');

    $data = $cache->get('test', fn () => 'test');

    assertCacheHasKey($cache, 'test');

    expect($data)->toBe('test');
});

it('Model cache: can store data in cache using put', function () {
    $article = Article::factory()->create();
    $cache = new ModelCache($article);

    assertCacheMissingKey($cache, 'test');

    $data = $cache->put('test', fn () => 'test');

    assertCacheHasKey($cache, 'test');

    expect($data)->toBe('test');
});

it('Model cache: can clear data in cache using forget', function () {
    $article = Article::factory()->create();
    $cache = new ModelCache($article);

    assertCacheMissingKey($cache, 'test');

    $cache->get('test', fn () => 'test');

    $data = $cache->forget('test', fn () => 'some other operations');

    assertCacheMissingKey($cache, 'test');

    expect($data)->toBe(true);
});

it('Model cache: can store data in cache', function (bool $enabled) {
    $article = Article::factory()->create();
    $cache = new ModelCache($article, $enabled);

    assertCacheMissingKey($cache, 'test', $enabled);

    $data = $cache->get('test', fn () => 'test');

    assertCacheHasKey($cache, 'test', $enabled);

    expect($data)->toBe('test');

    $data = $cache->put('test', fn () => 'test1');

    assertCacheHasKey($cache, 'test', $enabled);

    expect($data)->toBe('test1');

    $cache->forget('test', fn () => 'some other operations');
    assertCacheMissingKey($cache, 'test', $enabled);
})->with([
    ['enabled' => true],
    ['enabled' => false],
]);

it('Model cache: can store model in cache', function () {
    $article = Article::factory()->create();
    $user = User::factory()->create();

    $cache = new ModelCache($article);
    $data = $cache->get('test', fn () => User::first());

    assertCacheHasKey($cache, 'test');
    expect($data->getKey())->toBe($user->getKey());
});
