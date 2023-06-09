<?php

declare(strict_types=1);

namespace common\services;

use common\models\User;
use Exception;

class UserService
{
    /**
     * @throws Exception
     */
    public function createUser(string $username, string $email, string $password): User
    {
        $model = User::findByUsername(username: $username);

        if ($model !== null) {
            throw new Exception(message: 'User already exists');
        }

        $model = new User();
        $model->username = $username;
        $model->email = $email;
        $model->setPassword(password: $password);
        $model->status = User::STATUS_ACTIVE;

        if (!$model->save()) {
            throw new Exception(
                message: 'Could not create a user',
            );
        }

        return $model;
    }
}
