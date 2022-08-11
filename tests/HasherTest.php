<?php

use Illuminate\Database\Eloquent\Model;
use Maize\Cache\Exceptions\ModelMustExistsException;
use Maize\Cache\Hasher\DefaultHasher;
use Maize\Cache\Hasher\ModelHasher;
use Maize\Cache\Tests\Support\Models\Article;
use Maize\Cache\Tests\Support\Models\User;

test('default hasher: get hashed key', function (?string $prefix, string $key) {
    $hasher = new DefaultHasher($prefix);

    $hash = $hasher->getHashedKeyFor($key);

    expect($hash)->toBe(
        ($prefix ?? 'cache').'-'.md5($key)
    );
})->with([
    ['prefix' => null, 'key' => 'test'],
    ['prefix' => null, 'key' => 'maize'],
    ['prefix' => 'test', 'key' => 'test'],
    ['prefix' => 'test', 'key' => 'maize'],
    ['prefix' => 'maize', 'key' => 'test'],
    ['prefix' => 'maize', 'key' => 'maize'],
]);

test('model hasher: get hashed key', function (?string $prefix, string $key, Model $model) {
    $hasher = new ModelHasher(
        model: $model,
        prefix: $prefix
    );

    $hash = $hasher->getHashedKeyFor($key);

    expect($hash)->toStartWith(($prefix ?? 'cache').'-');
})->with([
    ['prefix' => null, 'key' => 'test', 'model' => fn () => User::factory()->create()],
    ['prefix' => null, 'key' => 'maize', 'model' => fn () => User::factory()->create()],
    ['prefix' => null, 'key' => 'test', 'model' => fn () => Article::factory()->create()],
    ['prefix' => null, 'key' => 'maize', 'model' => fn () => Article::factory()->create()],
    ['prefix' => 'test', 'key' => 'test', 'model' => fn () => User::factory()->create()],
    ['prefix' => 'test', 'key' => 'maize', 'model' => fn () => User::factory()->create()],
    ['prefix' => 'test', 'key' => 'test', 'model' => fn () => Article::factory()->create()],
    ['prefix' => 'test', 'key' => 'maize', 'model' => fn () => Article::factory()->create()],
    ['prefix' => 'maize', 'key' => 'test', 'model' => fn () => User::factory()->create()],
    ['prefix' => 'maize', 'key' => 'maize', 'model' => fn () => User::factory()->create()],
    ['prefix' => 'maize', 'key' => 'test', 'model' => fn () => Article::factory()->create()],
    ['prefix' => 'maize', 'key' => 'maize', 'model' => fn () => Article::factory()->create()],
]);

test('model hasher: model must exists', function (?string $prefix, string $key, Model $model) {
    expect(fn () => $hasher = new ModelHasher(
        model: $model,
        prefix: $prefix
    ))->toThrow(ModelMustExistsException::class);
})->with([
    ['prefix' => null, 'key' => 'test', 'model' => new User()],
    ['prefix' => null, 'key' => 'maize', 'model' => new User()],
    ['prefix' => null, 'key' => 'test', 'model' => new Article()],
    ['prefix' => null, 'key' => 'maize', 'model' => new Article()],
    ['prefix' => 'test', 'key' => 'test', 'model' => new User()],
    ['prefix' => 'test', 'key' => 'maize', 'model' => new User()],
    ['prefix' => 'test', 'key' => 'test', 'model' => new Article()],
    ['prefix' => 'test', 'key' => 'maize', 'model' => new Article()],
    ['prefix' => 'maize', 'key' => 'test', 'model' => new User()],
    ['prefix' => 'maize', 'key' => 'maize', 'model' => new User()],
    ['prefix' => 'maize', 'key' => 'test', 'model' => new Article()],
    ['prefix' => 'maize', 'key' => 'maize', 'model' => new Article()],
]);
