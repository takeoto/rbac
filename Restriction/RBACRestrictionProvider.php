<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Restriction;

use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionBuilderInterface;
use Takeoto\RBAC\Contract\RBACRestrictionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionProviderInterface;

class RBACRestrictionProvider implements RBACRestrictionProviderInterface
{
    public const INVENTORY_FIFO = 'fifo';
    public const INVENTORY_LIFO = 'lifo';

    /**
     * @var RBACRestrictionBuilderInterface[]
     */
    private array $builders;

    public function __construct(
        /** @todo ADVANCED [v2] */
        # private readonly bool $cacheable = true,
        # private readonly string $inventory = self::INVENTORY_LIFO,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function for(RBACPermissionInterface $permission): RBACRestrictionInterface
    {
        $builder = $this->getBuilder($permission);

        if ($builder === null) {
            throw new \RuntimeException(
                sprintf(
                    'Restriction builder for "%s" permission is not defined!',
                    $permission->getKey()
                )
            );
        }

        return $builder->build($permission);
    }

    /**
     * Adds the builder to the provider.
     *
     * @param RBACRestrictionBuilderInterface $builder
     * @return void
     */
    public function register(RBACRestrictionBuilderInterface $builder): void
    {
        $this->builders[] = $builder;
    }

    /**
     * Gets the builder by the permission.
     *
     * @param RBACPermissionInterface $permission
     * @return RBACRestrictionBuilderInterface|null
     */
    private function getBuilder(RBACPermissionInterface $permission): ?RBACRestrictionBuilderInterface
    {
        foreach ($this->builders as $builder) {
            if ($builder->support($permission)) {
                return $builder;
            }
        }

        return null;
    }
}
