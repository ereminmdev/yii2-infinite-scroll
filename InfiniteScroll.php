<?php

namespace ereminmdev\yii2\infinite_scroll;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\LinkPager;

/**
 * Class InfiniteScroll
 * @package ereminmdev\yii2\infinite_scroll
 * @see https://infiniteajaxscroll.com
 */
class InfiniteScroll extends LinkPager
{
    const EXT_TRIGGER = 'IASTriggerExtension';
    const EXT_SPINNER = 'IASSpinnerExtension';
    const EXT_NONE_LEFT = 'IASNoneLeftExtension';
    const EXT_PAGING = 'IASPagingExtension';
    const EXT_HISTORY = 'IASHistoryExtension';

    /**
     * @var array the client options
     * @see https://infiniteajaxscroll.com/docs/options.html
     */
    public $clientOptions = [];
    /**
     * @var array of pairs (ext => options) the client extension options. Set false to disable extension.
     * @see https://infiniteajaxscroll.com/docs/extension-trigger.html
     */
    public $clientExtensions = [];
    /**
     * @var array of pairs (event => function).
     * @see https://infiniteajaxscroll.com/docs/events.html
     */
    public $clientEvents = [];
    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make InfiniteScroll work.
     */
    public $pagination;
    /**
     * @var int maximum number of page buttons that can be displayed. Set to 0, because not needed.
     */
    public $maxButtonCount = 0;

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        $view = $this->getView();

        InfiniteScrollAsset::register($view);

        $clientVar = 'ias_' . $this->id;

        $options = ArrayHelper::merge([
            'container' => '.list-view',
            'item' => '.item',
            'pagination' => '.pagination',
            'next' => '.' . $this->nextPageCssClass . ' > a',
        ], $this->clientOptions);

        $view->registerJs('var ' . $clientVar . ' = jQuery.ias(' . Json::encode($options, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');');

        foreach ($this->clientEvents as $eventName => $eventFunc) {
            $view->registerJs($clientVar . '.on("' . $eventName . '", ' . $eventFunc . ')');
        }

        $extensions = ArrayHelper::merge([
            self::EXT_TRIGGER => [
                'offset' => $this->pagination->totalCount,
                'text' => Yii::t('app', 'Load more...'),
                'html' => '<div class="ias-trigger ias-trigger-next"><a class="btn btn-default">{text}</a></div>',
                'textPrev' => Yii::t('app', 'Load previous...'),
                'htmlPrev' => '<div class="ias-trigger ias-trigger-prev"><a class="btn btn-default">{text}</a></div>',
            ],
            self::EXT_SPINNER => [],
            self::EXT_NONE_LEFT => [
                'text' => '',
            ],
            self::EXT_PAGING => [],
            self::EXT_HISTORY => [
                'prev' => '.' . $this->prevPageCssClass . ' > a',
            ],
        ], $this->clientExtensions);

        foreach ($extensions as $name => $options) {
            if ($options !== false) {
                $view->registerJs($clientVar . '.extension(new ' . $name . '(' . Json::encode($options, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '));');
            }
        }
    }
}
