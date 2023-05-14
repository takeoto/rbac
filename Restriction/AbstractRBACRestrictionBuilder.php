<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Restriction;

use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionBuilderInterface;
use Takeoto\RBAC\Contract\RBACRestrictionInterface;
use Takeoto\RBAC\Restriction\Contract\NeedPermissionInterface;
use Takeoto\RBAC\Utility\Ensure;

abstract class AbstractRBACRestrictionBuilder implements RBACRestrictionBuilderInterface
{
    /**
     * @var array<string,class-string|RBACRestrictionInterface>
     */
    protected array $builders = [];

    /**
     * Adds the restriction by the attribute.
     *
     * @param string $attribute
     * @param class-string|RBACRestrictionInterface $item
     * @return void
     */
    public function register(string $attribute, string|RBACRestrictionInterface $item): void
    {
        $this->builders[$attribute] = $item;
    }

    /**
     * Gets the restriction by the permission and the attribute.
     *
     * @param string $key
     * @param RBACPermissionInterface $permission
     * @return RBACRestrictionInterface
     * @throws \Exception
     */
    protected function getRestriction(string $key, RBACPermissionInterface $permission): RBACRestrictionInterface
    {
        Ensure::keyExists($this->builders, $key);
        $item = $this->builders[$key];

        if (is_string($item)) {
            $item = $this->makeRestriction($item, $permission);
        }

        return $this->prepareRestriction($item, $permission);
    }

    /**
     * Makes the permission restriction by its class name.
     *
     * @param class-string $className
     * @param RBACPermissionInterface $permission
     * @return RBACRestrictionInterface
     * @throws \Exception
     */
    protected function makeRestriction(string $className, RBACPermissionInterface $permission): RBACRestrictionInterface
    {
        Ensure::classExists($className);
        $object = new $className($permission);
        Ensure::isInstanceOf($object, RBACRestrictionInterface::class);

        /** @var RBACRestrictionInterface $object */
        return $object;
    }

    /**
     * Prepares the restriction before use.
     *
     * @param RBACRestrictionInterface $item
     * @param RBACPermissionInterface $permission
     * @return RBACRestrictionInterface
     */
    protected function prepareRestriction(
        RBACRestrictionInterface $item,
        RBACPermissionInterface $permission
    ): RBACRestrictionInterface {
        if ($item instanceof NeedPermissionInterface) {
            $item->setPermission($permission);
        }

        return $item;
    }
}
