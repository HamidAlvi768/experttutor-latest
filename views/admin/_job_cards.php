<?php
use yii\helpers\Html;
use app\components\Helper;

/* @var $dataProvider \yii\data\ActiveDataProvider */
?>

<div class="row g-4">
    <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title flex-shrink-0"><?= Html::encode($model->title ?? "Not Provided") ?></h5>
                    <p class="card-text flex-shrink-0">
                        <?= Html::encode(substr($model->details ?? "", 0, 150)) . '...' ?>
                    </p>
                    <ul class="card-meta list-unstyled flex-shrink-0 mb-2">
                        <li><i class="fa fa-money"></i> <span><strong>Budget:</strong> <?= Helper::getCurrency() ?> <?= Html::encode($model->budget ?? 0) ?></span></li>
                        <?php if ($model->post_code ?? ""): ?>
                            <li><i class="fa fa-map-marker"></i> <span><strong>Location:</strong> <?= Html::encode($model->location ?? "") ?></span></li>
                        <?php endif; ?>
                        <li><i class="fa fa-book"></i> <span><strong>Subject:</strong> <?= Html::encode($model->subject ?? "") ?></span></li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent text-end">
                    <?= Html::a('View Details', ['post/view', 'id' => $model->id ?? 0], ['class' => 'btn btn-primary btn-sm ms-2']) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= \yii\widgets\LinkPager::widget([
    'pagination' => $dataProvider->pagination,
    'options' => ['class' => 'pagination justify-content-center mt-4'],
    'linkOptions' => ['class' => 'page-link'],
    'pageCssClass' => 'page-item',
    'prevPageCssClass' => 'page-item',
    'nextPageCssClass' => 'page-item',
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled',
    'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
    'prevPageLabel' => '&laquo;',
    'nextPageLabel' => '&raquo;',
]) ?>