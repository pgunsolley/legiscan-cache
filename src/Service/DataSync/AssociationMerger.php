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
     * @param string $associationName
     * @param array<int,mixed> $data
     * @param null|callable(array<int,mixed> $data): array<int,mixed> $transform
     * @return \Cake\Datasource\EntityInterface
     */
    public function mergeOneToOne(string $associationName, array $data, ?callable $transform = null): EntityInterface
    {
        $association = $this->table->getAssociation($associationName);
        $property = $association->getProperty();
        if ($association->type() !== Association::ONE_TO_ONE) {
            throw new InvalidAssociationTypeException(sprintf('Expected association of type %s', Association::ONE_TO_ONE));
        }

        /** @var \Cake\Datasource\EntityInterface $associated */
        $associated = $this->entity->get($property) ?? $association->newEmptyEntity();
        if ($transform !== null) {
            $data = $transform($data);
        }

        $association->patchEntity($associated, $data);
        if ($associated->isNew()) {
            $this->entity->set($property, $associated);
        }

        return $associated;
    }

    /**
     * @param string $associationName
     * @param array<array> $data
     * @param callable(\Cake\Collection\CollectionInterface $associated, array $item): null|\Cake\Datasource\EntityInterface $matcher
     * @param null|callable(array $item): array $transform
     * @return \Cake\Collection\CollectionInterface
     */
    public function mergeOneToMany(string $associationName, array $data, callable $matcher, ?callable $transform = null): CollectionInterface
    {
        $association = $this->table->getAssociation($associationName);
        $property = $association->getProperty();
        if ($association->type() !== Association::ONE_TO_MANY) {
            throw new InvalidAssociationTypeException(sprintf('Expected association of type %s', Association::ONE_TO_MANY));
        }

        $associatedEntities = $this->entity->get($property);
        if (!is_array($associatedEntities)) {
            throw new AssociationNotLoadedException(sprintf('Association %s is not initialized as an array on Entity', $associationName));
        }

        $associated = new Collection($associatedEntities);
        return new Collection(array_map(static function ($item) use ($matcher, $transform, $association, $associated, &$associatedEntities) {
            if (!is_array($item)) {
                throw new InvalidAssociationDataException('Associated data item must be an array');
            }

            $matched = $matcher($associated, $item, $association);
            if (!($matched instanceof EntityInterface) && $matched !== null) {
                throw new InvalidMatchException('Matcher must return an instance of EntityInterface or null');
            }

            if ($matched === null) {
                /** @var \Cake\Datasource\EntityInterface $matched */
                $matched = $association->newEmptyEntity();
            }

            if ($transform !== null) {
                $item = $transform($item);
            }

            $association->patchEntity($matched, $item);
            if ($matched->isNew()) {
                $associatedEntities[] = $matched;
            }

            return $matched;
        }, $data));
    }
}