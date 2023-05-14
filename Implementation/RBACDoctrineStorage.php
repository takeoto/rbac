<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Implementation;

use App\Repository\PermissionRepository;
use App\Repository\RoleRepository;
use Takeoto\RBAC\Contract\RBACStorageInterface;
use Takeoto\RBAC\Permission\PermissionDict;
use Takeoto\RBAC\Role\RoleDict;
use Takeoto\RBAC\Solver\ArraySolver;

class RBACDoctrineStorage implements RBACStorageInterface
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
        private readonly PermissionRepository $permissionRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getRole(string $roleKey): array
    {
        return $this->prepareRole($this->roleRepository->getRoleByName($roleKey));
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(array $keys = null): array
    {
        return array_map(
            [$this, 'prepareRole'],
            $keys === null
                ? $this->roleRepository->getAll()
                : $this->roleRepository->getRolesByNames($keys)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getPermission(string $permissionKey): array
    {
        return $this->preparePermission($this->permissionRepository->getByCode($permissionKey));
    }

    /**
     * {@inheritDoc}
     */
    public function getPermissions(): array
    {
        return array_map(
            [$this, 'preparePermission'],
            ArraySolver::splitBy($this->permissionRepository->getAll(), 'code'),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getRolePermissions(string $roleKey): array
    {
        return array_map(
            [$this, 'preparePermission'],
            ArraySolver::splitBy($this->roleRepository->getPermissions($roleKey), 'code')
        );
    }

    /**
     * Prepares the role data.
     *
     * @param mixed[] $data
     * @return mixed[]
     */
    public function prepareRole(array $data): array
    {
        if (empty($data)) {
            return [];
        }

        return [
            RoleDict::KEY => $data['name'],
            RoleDict::ATTRIBUTES => [
                'description' => $data['description'],
            ],
        ];
    }

    /**
     * Prepared the permission data.
     *
     * @param mixed[] $data
     * @return mixed[]
     */
    private function preparePermission(array $data): array
    {
        $result = [];

        if (empty($data)) {
            return $result;
        }

        $first = reset($data);
        $result[PermissionDict::KEY] = $first['code'];
        $result[PermissionDict::ATTRIBUTES]['type'] = $first['type'];
        $result[PermissionDict::ATTRIBUTES]['description'] = $first['description'];
        $result[PermissionDict::ARGUMENTS] = array_filter(array_column($data, 'argValue', 'argName'));

        return $result;
    }
}
