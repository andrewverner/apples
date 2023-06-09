<?php

declare(strict_types=1);

namespace backend\controllers;

use common\exceptions\RuntimeException;
use common\services\AppleServiceInterface;
use Throwable;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class AppleController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly AppleServiceInterface $appleService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'generate' => ['get'],
                    'eat' => ['post'],
                    'fall' => ['post'],
                ],
            ],
        ];
    }

    public function actionGenerate(): void
    {
        $this->appleService->generate();
    }

    /**
     * @throws BadRequestHttpException|ServerErrorHttpException
     */
    public function actionFall(): void
    {
        $id = Yii::$app->request->get(name: 'id');

        if ($id === null) {
            throw new BadRequestHttpException(message: 'id is missing');
        }

        try {
            $this->appleService->fall(id: (int) $id);
        } catch (RuntimeException $exception) {
            throw new BadRequestHttpException(message: $exception->getMessage());
        } catch (Throwable) {
            throw new ServerErrorHttpException(message: 'Oops... Something went wrong');
        }
    }

    /**
     * @throws BadRequestHttpException|ServerErrorHttpException
     */
    public function actionEat(): void
    {
        $id = Yii::$app->request->post(name: 'id');
        $volume = (int) Yii::$app->request->post(name: 'volume');

        if ($id === null || !$volume) {
            throw new BadRequestHttpException(message: 'id or volume is invalid');
        }

        try {
            $this->appleService->eat(id: (int) $id, volume: $volume);
        } catch (RuntimeException $exception) {
            throw new BadRequestHttpException(message: $exception->getMessage());
        } catch (Throwable) {
            throw new ServerErrorHttpException(message: 'Oops... Something went wrong');
        }
    }
}
