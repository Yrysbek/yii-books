<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success create-book', 'title' => 'Добавить книгу']) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel, 'authors' => $authors]); ?>
    <br>
    <?= GridView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'preview',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data['preview'], ['width' => '150px', 'alt' => $data['name']]);
                },
            ],
            ['label' => 'Автор', 'value' => 'authorText', 'attribute' => 'author_id'],
            ['label' => 'Дата выхода книги', 'value' => 'dateFormatted', 'attribute' => 'date'],
            ['label' => 'Дата добавления', 'value' => 'dateCreateRelativeTime', 'attribute' => 'date_create'],

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

</div>
