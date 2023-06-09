<?php

declare(strict_types=1);

namespace common\services;

use Exception;
use Yii;
use yii\rbac\Assignment;
use yii\rbac\Role;

class RbacService
{
    /**
     * @throws Exception
     */
    public function getRole(string $name, bool $createIfNotExists = false): ?Role
    {
        $role = Yii::$app->authManager->getRole(name: $name);

        if ($role === null && $createIfNotExists) {
            $role = Yii::$app->authManager->createRole(name: $name);
            Yii::$app->authManager->add(object: $role);
        }

        return $role;
    }

    /**
     * @throws Exception
     */
    public function assignRoleToUser(Role $role, int|string $userId): Assignment
    {
        return Yii::$app->authManager->assign(role: $role, userId: $userId);
    }
}
