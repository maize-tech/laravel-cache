<?php

namespace Maize\Cache\Hasher;

use Illuminate\Support\Str;

class DefaultHasher
{
    public function __construct(
        protected ?string $prefix = null
    ) {
    }

    public function getHashedKeyFor(string $key): string
    {
        return Str::of($this->prefix ?? 'cache')
            ->slug('')
            ->append('-')
            ->append(md5($key));
    }
}
