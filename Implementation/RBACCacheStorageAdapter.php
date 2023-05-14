<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Implementation;

use Psr\Cache\CacheItemPoolInterface;
use Takeoto\RBAC\Contract\RBACStorageInterface;
use Takeoto\RBAC\Role\RoleDict;
use Takeoto\RBAC\Solver\ArraySolver;
use Takeoto\RBAC\Utility\Ensure;

class RBACCacheStorageAdapter implements RBACStorageInterface
{
    public const ROLES_KEY = 'rbac.roles';
    public const PERMISSIONS_KEY = 'rbac.permissions';

    private ?\DateTime $expiresAt;

    public function __construct(
        private readonly CacheItemPoolInterface $cache,
        private readonly RBACStorageInterface $storage,
        ?string $expiresAt = null,
    ) {
        $this->setExpiresAt($expiresAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getRole(string $roleKey): array
    {
        return ArraySolver::search($this->getRoles(), fn(array $item): bool => $item[RoleDict::KEY] === $roleKey, []);
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(array $keys = null): array
    {
        $roles = $this->getOrRefresh(self::ROLES_KEY, [$this->storage, 'getRoles']);

        if ($keys === null) {
            return $roles;
        }

        $keys = array_flip($keys);

        return array_filter($roles, fn(array $item): bool => isset($keys[$item[RoleDict::KEY]]));
    }

    /**
     * {@inheritDoc}
     */
    public function getPermission(string $permissionKey): array
    {
        return ArraySolver::search(
            $this->getPermissions(),
            fn(array $item): bool => $item[RoleDict::KEY] === $permissionKey,
            []
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getPermissions(): array
    {
        return $this->getOrRefresh(self::PERMISSIONS_KEY, [$this->storage, 'getPermissions']);
    }

    /**
     * {@inheritDoc}
     */
    public function getRolePermissions(string $roleKey): array
    {
        $roles = $this->getRoles();

        foreach ($roles as &$role) {
            if ($role[RoleDict::KEY] !== $roleKey) {
                continue;
            }

            if (isset($role[RoleDict::PERMISSIONS])) {
                return $role[RoleDict::PERMISSIONS];
            }

            $role[RoleDict::PERMISSIONS] = $this->storage->getRolePermissions($roleKey);
            $this->refreshCache(self::ROLES_KEY, $roles);

            return $role[RoleDict::PERMISSIONS];
        }

        return [];
    }

    /**
     * @param string|null $expiresAt
     * @return void
     * @throws \Exception
     */
    private function setExpiresAt(?string $expiresAt): void
    {
        if ($expiresAt !== null) {
            Ensure::dateTime($expiresAt);
            $expiresAt = new \DateTime($expiresAt);
        }

        $this->expiresAt = $expiresAt;
    }

    /**
     * Gets a value from the cache, or updates otherwise.
     *
     * @param string $key
     * @param callable $refresh
     * @return mixed[]
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function getOrRefresh(string $key, callable $refresh): array
    {
        $items = $this->getFromCache($key);

        if ($items === null) {
            $this->refreshCache($key, $items = $refresh());
        }

        return $items;
    }

    /**
     * Gets a value from the cache.
     *
     * @param string $key
     * @return mixed[]|null
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function getFromCache(string $key): ?array
    {
        $cacheItem = $this->cache->getItem($key);

        return $cacheItem->isHit() ? $cacheItem->get() : null;
    }

    /**
     * Refreshes a value of cache.
     *
     * @param string $key
     * @param mixed[] $data
     * @return void
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function refreshCache(string $key, array $data): void
    {
        $cacheItem = $this->cache->getItem($key);
        $cacheItem->set($data);

        if (!$cacheItem->isHit()) {
            $cacheItem->expiresAt($this->expiresAt);
        }

        $this->cache->save($cacheItem);
    }
}
