<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Restriction;

use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionInterface;
use Takeoto\RBAC\Utility\Ensure;

class RBACByRegexpKeyRestrictionBuilder extends AbstractRBACRestrictionBuilder
{
    /**
     * @var array<string,string>
     */
    private array $cachedKeyToRgx = [];

    /**
     * {@inheritDoc}
     */
    public function support(RBACPermissionInterface $permission): bool
    {
        return $this->getBuilderKeyFor($permission) !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function build(RBACPermissionInterface $permission): RBACRestrictionInterface
    {
        $key = $this->getBuilderKeyFor($permission);
        Ensure::notNull($key);

        /** @var string $key */
        return $this->getRestriction($key, $permission);
    }

    /**
     * Gets the builder key which applies to the regexp.
     *
     * @param RBACPermissionInterface $permission
     * @return string|null
     */
    private function getBuilderKeyFor(RBACPermissionInterface $permission): ?string
    {
        $permissionKey = $permission->getKey();

        if (isset($this->cachedKeyToRgx[$permissionKey])) {
            return $this->cachedKeyToRgx[$permissionKey];
        }

        foreach ($this->builders as $key => $builder) {
            if (preg_match($key, $permissionKey)) {
                return $this->cachedKeyToRgx[$permissionKey] = $key;
            }
        }

        return null;
    }
}
