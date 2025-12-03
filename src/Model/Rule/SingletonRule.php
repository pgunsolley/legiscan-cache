<?php

declare(strict_types=1);

namespace App\Model\Rule;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Exception\MissingEntityException;

// Use this rule to add additional checks to ensure uniqueness that cannot be satisfied with cakephp built-in isUnique rule.
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
                        fn($key) => $entity->get($key),
                        array_keys($entity->toArray()),
                    ),
                ),
            )
            ->count();

        return $existingCount === 0;
    }
}