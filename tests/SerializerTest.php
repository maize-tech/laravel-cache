<?php

use Illuminate\Support\Facades\Crypt;
use Maize\Cache\Serializer\CacheSerializer;
use Maize\Cache\Serializer\CryptSerializer;
use Maize\Cache\Serializer\DefaultSerializer;
use Maize\Cache\Tests\Support\Models\Article;
use Maize\Cache\Tests\Support\Models\User;

test('default serializer', function (mixed $value) {
    $serializer = new DefaultSerializer();

    expect($serializer)->toBeInstanceOf(CacheSerializer::class);

    expect($serializer->serialize($value))->toBe(serialize($value));

    expect($serializer->unserialize(serialize($value)))->toEqual($value);
})->with([
    fn () => User::factory()->create(),
    fn () => Article::factory()->create(),
    fn () => now(),
    'abcdefg',
    1234,
    3.14,
    null,
]);

test('crypt serializer', function (mixed $value) {
    $serializer = new CryptSerializer();

    expect($serializer)->toBeInstanceOf(CacheSerializer::class);

    expect($serializer->unserialize(Crypt::encrypt($value)))->toEqual($value);

    expect($serializer->unserialize($serializer->serialize($value)))->toEqual($value);
})->with([
    fn () => User::factory()->create(),
    fn () => Article::factory()->create(),
    fn () => now(),
    'abcdefg',
    1234,
    3.14,
    null,
]);
