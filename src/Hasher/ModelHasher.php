<?php

namespace Maize\Cache\Hasher;

use Illuminate\Database\Eloquent\Model;
use Maize\Cache\Exceptions\ModelMustExistsException;

class ModelHasher extends DefaultHasher
{
    public function __construct(
        protected Model $model,
        ?string $prefix = null
    ) {
        if ($model instanceof Model) {
            throw_unless(
                $model->getKey(),
                ModelMustExistsException::class
            );
        }

        parent::__construct($prefix);
    }

    public function getHashedKeyFor(string $key): string
    {
        return parent::getHashedKeyFor(
            collect()
                ->push($this->model->getMorphClass())
                ->push($this->model->getkey())
                ->push($key)
                ->filter()
                ->implode('.')
        );
    }
}
