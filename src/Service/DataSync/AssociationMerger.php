<?php
declare(strict_types=1);

namespace App\Service\DataSync;

use App\Service\DataSync\Exception\AssociationNotLoadedException;
use App\Service\DataSync\Exception\InvalidAssociationDataException;
use App\Service\DataSync\Exception\InvalidAssociationTypeException;
use App\Service\DataSync\Exception\InvalidMatchException;
use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use TypeError;

class AssociationMerger
{
    use LocatorAwareTrait;

    protected EntityInterface $entity;

    protected Table $table;

    public function __construct(EntityInterface $entity)
    {
        $this->entity = $entity;
        $this->table = $this->fetchTable($entity->getSource());
    }

    /**
     * Merge a hasOne association with a given data array.
     * @param string $associationName The name of the association
     * @param array<int|string,mixed> $data The data to patch into the entity
     * @param null|callable(AssociationMerger $merger, array $data) $descend 
     *      A callable that allows descending into deeper associations
     * @param null|callable(array<int|string,mixed> $data): array<int|string,mixed> $transform 
     *      A callable that allows modification to $data before it is patched.
     * @return \Cake\Datasource\EntityInterface
     */
    public function mergeOneToOne(
        string $associationName,
        array $data,
        ?callable $descend = null,
        ?callable $transform = null,
    ): EntityInterface {
        $association = $this->table->getAssociation($associationName);
        $property = $association->getProperty();
        $associationType = $association->type();
        if ($associationType !== Association::ONE_TO_ONE) {
            throw new InvalidAssociationTypeException(sprintf(
                'Expected association of %s to be %s',
                $associationType,
                Association::ONE_TO_ONE,
            ));
        }

        /** @var \Cake\Datasource\EntityInterface $associated */
        $associated = $this->entity->get($property) ?? $association->newEmptyEntity();
        if ($descend !== null) {
            $descend(new self($associated), $data);
        }

        if ($transform !== null) {
            $transformedData = $transform($data);
            if (!is_array($transformedData)) {
                throw new TypeError('Transform must return array');
            }

            $data = $transformedData;
        }

        $association->patchEntity($associated, $data);
        if ($associated->isNew()) {
            $this->entity->set($property, $associated);
        }

        return $associated;
    }

    /**
     * @param string $associationName The name of the association
     * @param array<array> $data The data to patch into the entity
     * @param callable(\Cake\Collection\CollectionInterface $associated, array $item): null|\Cake\Datasource\EntityInterface $matcher 
     *          Callable that returns an EntityInterface matching the given $data item on each iteration
     * @param null|callable(array $data): array $prepare A callable that is called with the entire $data array before iteration. 
     *          The returned array will replace the $data array.
     * @param null|callable(AssociationMerger $merger, array $item) $descend 
     *          A callable that allows descending into deeper associations
     * @param null|callable(array $item): array $transform A callable called on each $data item iteration allowing modification 
     *          for each record before it is patched.
     * @return \Cake\Collection\CollectionInterface
     */
    public function mergeOneToMany(
        string $associationName,
        array $data,
        callable $matcher,
        ?callable $prepare = null,
        ?callable $descend = null,
        ?callable $transform = null,
    ): CollectionInterface {
        $association = $this->table->getAssociation($associationName);
        $property = $association->getProperty();
        $associationType = $association->type();
        if ($associationType !== Association::ONE_TO_MANY) {
            throw new InvalidAssociationTypeException(sprintf(
                'Expected association of %s to be %s',
                $associationType,
                Association::ONE_TO_MANY,
            ));
        }

        $associatedEntities = $this->entity->get($property);
        if (!is_array($associatedEntities)) {
            throw new AssociationNotLoadedException(sprintf(
                'Association %s is not initialized as an array on Entity',
                $associationName,
            ));
        }

        if ($prepare !== null) {
            $prepared = $prepare($data);
            if (!is_array($prepared)) {
                throw new TypeError('Data returned from prepare handler must be an array');
            }

            $data = $prepared;
        }

        $associated = new Collection($associatedEntities);
        return new Collection(array_map(function ($item) use (
            $matcher,
            $transform,
            $association,
            $associated,
            &$associatedEntities,
            $descend,
        ) {
            if (!is_array($item)) {
                throw new InvalidAssociationDataException('Associated data item must be an array');
            }

            $matched = $matcher($associated, $item);
            if (!($matched instanceof EntityInterface) && $matched !== null) {
                throw new InvalidMatchException('Matcher must return an instance of EntityInterface or null');
            }

            if ($matched === null) {
                /** @var \Cake\Datasource\EntityInterface $matched */
                $matched = $association->newEmptyEntity();
            }

            if ($descend !== null) {
                $descend(new self($matched), $item);
            }

            if ($transform !== null) {
                $transformedItem = $transform($item);
                if (!is_array($transformedItem)) {
                    throw new TypeError('Transform must return array');
                }

                $item = $transformedItem;
            }

            $association->patchEntity($matched, $item);
            if ($matched->isNew()) {
                $associatedEntities[] = $matched;
            }

            return $matched;
        }, $data));
    }
}