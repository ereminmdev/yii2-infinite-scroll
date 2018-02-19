# yii2-infinite-scroll

Infinite Ajax Scroll widget.

Based on jQuery plugin: https://infiniteajaxscroll.com

## Install

``composer require ereminmdev/yii2-infinite-scroll``

## Documentation

See for clientOptions: https://infiniteajaxscroll.com/docs/options.html

## Use

Add as pager component:

```
echo ListView::widget([
     'dataProvider' => $dataProvider,
     'itemOptions' => ['class' => 'item'],
     'pager' => ['class' => \ereminmdev\yii2\infinite_scroll\InfiniteScroll::class]
]);
```

or insert as widget into view:

```
<div class="pagination">
    <?= InfiniteScroll::widget([
        'pagination' => $dataProvider->getPagination(),
        'clientOptions' => [
            'container' => '.items',
            'item' => '.item',
            'pagination' => '.pagination',
        ],
        'clientExtensions' => [
            InfiniteScroll::EXT_TRIGGER => [
                'offset' => 0,
                'text' => Yii::t('app', 'Load more...'),
                'html' => '<div class="ias-trigger ias-trigger-next"><a class="btn btn-default">{text}</a></div>',
                'textPrev' => Yii::t('app', 'Load previous...'),
                'htmlPrev' => '<div class="ias-trigger ias-trigger-prev"><a class="btn btn-default">{text}</a></div>',
            ],
            InfiniteScroll::EXT_SPINNER => [
                'html' => '<div class="ias-spinner"><i class="fa fa-refresh fa-spin fa-lg"></i></div>',
            ],
            InfiniteScroll::EXT_NONE_LEFT => [
                'html' => 'You reached the end.',
            ],
        ],
    ]) ?>
</div>
```

When updating content throw ajax, don't forget to reinitialize plugin:

```
$(document).on('click', '#sample_filter', function (event) {
    $('.list-view').load('sample_url', function () {
        //reinitialize plugin after load success
        jQuery.ias().reinitialize();
    });
    event.preventDefault();
});
```
