<?php

use common\models\Apple;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;
use backend\assets\AppleGridAsset;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

AppleGridAsset::register(view: $this);

$this->title = 'Apple Application';
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-sm btn-success" id="add-apples">Add apples</button>
        </div>
        <div class="col-lg-12">
            <?php Pjax::begin(config: ['id' => 'apples-list']); ?>

            <?= GridView::widget([
                'dataProvider' =>  $dataProvider,
                'columns' => [
                    ['class' => SerialColumn::class],
                    'color',
                    'state',
                    'volume',
                    'createdAt',
                    'fellAt',
                    [
                        'class' => yii\grid\ActionColumn::class,
                        'template' => '{fall} {eat}',
                        'buttons' => [
                            'fall' => function($url, Apple $model, $key) {
                                return $model->isOnTree()
                                    ? Html::a(
                                        text: 'Упасть',
                                        url: '#',
                                        options: [
                                            'class' => 'btn btn-sm btn-primary fall-btn',
                                            'data-id' => $model->id,
                                            'data-url' => Url::to(url: ['apple/fall', 'id' => $model->id]),
                                        ],
                                    )
                                    : null;
                            },
                            'eat' => function($url, Apple $model, $key) {
                                return $model->isFell()
                                    ? Html::a(
                                        text: 'Съесть',
                                        url: '#',
                                        options: [
                                            'class' => 'btn btn-sm btn-success eat-btn',
                                            'data-id' => $model->id,
                                            'data-url' => Url::to(url: ['apple/eat']),
                                            'data-volume' => $model->volume,
                                        ],
                                    )
                                    : null;
                            }
                        ]
                    ]
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>

<div class="modal" id="eat-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Съесть яблоко</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="eatVolume" class="form-control" placeholder="Количество в процентах" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-sm btn-primary" id="eat-btn" data-bs-dismiss="modal">Съесть</button>
            </div>
        </div>
    </div>
</div>
