<?php

declare(strict_types=1);

namespace console\controllers;

use common\services\RbacService;
use common\services\UserService;
use Exception;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class InitController extends Controller
{
    public ?string $username = null;

    public ?string $email = null;

    public ?string $password = null;

    /**
     * @inheritDoc
     * @return array<int, string>
     */
    public function options($actionID): array
    {
        return ['username', 'email', 'password'];
    }

    public function actionAddAdmin(): int
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $userService = new UserService();
            $rbacService = new RbacService();

            $user = $userService->createUser(username: $this->username, email: $this->email, password: $this->password);
            $adminRole = $rbacService->getRole(name: 'admin', createIfNotExists: true);
            $rbacService->assignRoleToUser(role: $adminRole, userId: $user->getId());

            $transaction->commit();
        } catch (Exception $exception) {
            $this->stderr(string: $exception->getMessage());

            $transaction->rollBack();
        }

        return ExitCode::OK;
    }
}
