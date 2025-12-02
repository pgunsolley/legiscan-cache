<?php

declare(strict_types=1);

namespace App\Model\Rule;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Exception\MissingEntityException;

class SingletonRule
{
    protected array $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function __invoke(EntityInterface $entity, array $options)
    {
        $table = $options['repository'];

        foreach ($this->fields as $field) {
            if (!$entity->has($field)) {
                throw new MissingEntityException("Entity is missing required field '$field' for Singleton check");
            }
        }

        $existingCount = $table
            ->find()
            ->where(
                array_combine(
                    $this->fields,
                    array_map(
                        fn($key) => $entity[$key],
                        array_keys($entity->toArray()),
                    ),
                ),
            )
            ->count();

        return $existingCount === 0;
    }
}