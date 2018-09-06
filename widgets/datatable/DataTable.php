<?php
/**
 * @copyright Copyright (c) 2015 Serhiy Vinichuk
 * @license MIT
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 */
namespace codeup\widgets\datatable;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
/**
 * Class DataTable
 * @package nullref\datatable
 * Features
 * @property bool $autoWidth Feature control DataTables' smart column width handling
 * @property bool $deferRender Feature control deferred rendering for additional speed of initialisation.
 * @property bool $info Feature control table information display field
 * @property bool $jQueryUI Use markup and classes for the table to be themed by jQuery UI ThemeRoller.
 * @property bool $lengthChange Feature control the end user's ability to change the paging display length of the table.
 * @property bool $ordering Feature control ordering (sorting) abilities in DataTables.
 * @property bool $paging Enable or disable table pagination.
 * @property bool $processing Feature control the processing indicator.
 * @property bool $scrollX Enable horizontal scrolling
 * @property bool $scrollY Enable vertical scrolling
 * @property bool $searching Feature control search (filtering) abilities
 * @property bool $serverSide Enable server-side filtering, paging and sorting calculations
 * @property bool $stateSave Restore table state on page reload
 * @property array $language
 * Options
 * @property array $ajax Load data for the table's content from an Ajax source
 * @property array $data Data to use as the display data for the table.
 * @property array $columnDefs Set column definition initialisation properties.
 * @property array $columns Set column specific initialisation properties.
 * @property bool|int|array $deferLoading Delay the loading of server-side data until second draw
 * @property bool $destroy Destroy any existing table matching the selector and replace with the new options.
 * @property int $displayStart Initial paging start point
 * @property string $dom Define the table control elements to appear on the page and in what order
 * @property array $lengthMenu Change the options in the page length `select` list.
 * @property bool $orderCellsTop Control which cell the order event handler will be applied to in a column
 * @property bool $orderClasses Highlight the columns being ordered in the table's body
 * @property array $order Initial order (sort) to apply to the table
 * @property array $orderFixed Ordering to always be applied to the table
 * @property bool $orderMulti Multiple column ordering ability control.
 * @property int $pageLength Change the initial page length (number of rows per page)
 * @property string $pagingType Pagination button display options.
 * @property string|array $renderer Display component renderer types
 * @property bool $retrieve Retrieve an existing DataTables instance
 * @property bool $scrollCollapse Allow the table to reduce in height when a limited number of rows are shown.
 * @property array $search
 * @property array $searchCols Define an initial search for individual columns.
 * @property array $searchDelay Set a throttle frequency for searching
 * @property int $stateDuration Saved state validity duration
 * @property array $stripeClasses Set the zebra stripe class names for the rows in the table.
 * @property int $tabIndex Tab index control for keyboard navigation
 * Callbacks
 * @property string $createdRow Callback for whenever a TR element is created for the table's body.
 * @property string $drawCallback Function that is called every time DataTables performs a draw.
 * @property string $footerCallback Footer display callback function.
 * @property string $formatNumber Number formatting callback function.
 * @property string $headerCallback Header display callback function.
 * @property string $infoCallback Table summary information display callback.
 * @property string $initComplete Initialisation complete callback.
 * @property string $preDrawCallback Pre-draw callback.
 * @property string $rowCallback Row draw callback.
 * @property string $stateLoadCallback Callback that defines where and how a saved state should be loaded.
 * @property string $stateLoaded State loaded callback.
 * @property string $stateLoadParams State loaded - data manipulation callback
 * @property string $stateSaveCallback Callback that defines how the table state is stored and where.
 * @property string $stateSaveParams State save - data manipulation callback
 */
class DataTable extends Widget
{
    const COLUMN_TYPE_DATE = 'date';
    const COLUMN_TYPE_NUM = 'num';
    const COLUMN_TYPE_NUM_FMT = 'num-fmt';
    const COLUMN_TYPE_HTML_NUM = 'html-num';
    const COLUMN_TYPE_HTML_NUM_FMT = 'html-num-fmt';
    const COLUMN_TYPE_STRING = 'string';
    const PAGING_SIMPLE = 'simple';
    const PAGING_SIMPLE_NUMBERS = 'simple_numbers';
    const PAGING_FULL = 'full';
    const PAGING_FULL_NUMBERS = 'full_numbers';
    protected $_options = [];
    public $id;
    /**
     * @var array Html options for table
     */
    public $tableOptions = [];

    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;
    /**
     * @var
     */
    public $dataProvider;
    public function init()
    {
        parent::init();
        $this->tableOptions['class'] = 'table table-striped table-bordered';
        $this->tableOptions['style'] = 'width:100%';
        //Bfrtip
        if(!isset($this->_options['dom']))
            $this->_options['dom']= "r<'row'
                                   <'col-xs-12 pull-right'
                                        <'pull-right'B>
                                   >
                                   <'col-sm-6'l>
                                   <'col-sm-6'f>
                                   <'col-xs-12't>
                                   <'col-xs-12'i>
                                   <'col-xs-12'p>
                                 >";
        if(!isset($this->_options['processing']))
            $this->_options['processing'] = true;
        if(!isset($this->_options['serverSide']))
            $this->_options['serverSide'] = true;
        if(!isset($this->_options['buttons']))
            $this->_options['buttons'] = [
                'colvis','copy','print','excel','csv','pdf'
            ];
        $this->autoWidth = false;
        if(!isset($this->_options['order']))
            $this->order = [[1, 'asc']];
        $this->pageLength = 10;
        $this->initColumns();
    }
    public function run()
    {

        $id = isset($this->id) ? $this->id : $this->getId();
        echo Html::beginTag('table', ArrayHelper::merge(['id' => $id], $this->tableOptions));
        echo '<tfoot style="display: table-row-group;"><tr>';
        foreach($this->_options['columns'] as $key_columns =>$columns){
            echo '<th>';
            if(is_array($columns) && isset($columns['data'])){
                if(isset($columns['searchable']) && !$columns['searchable'])
                    continue;
                if(isset($columns['cfilter_select'])) {
                    echo '<select class="dtfilter form-control" style="width:100%;padding: 0 3px;height: 25px;">';
                    echo '<option value="">---</option>';
                    foreach($columns['cfilter_select'] as $key => $val){
                        echo '<option value="'.$key.'">'.$val.'</option>';
                    }
                    echo '</select>';
                }else{
                    echo '<input type="text" class="dtfilter form-control" style="width:100%;padding: 0 3px;height: 25px;"/>';
                }
            }
            echo '</th>';
        }
        echo '</tr></tfoot>';
        echo Html::endTag('table');
        $this->getView()->registerJs('codeup_datatable=[];codeup_datatable["'.$id.'"]=jQuery("#' . $id . '").DataTable(' . Json::encode($this->getParams()) . ');');
        $this->getView()->registerJs('$("#'.$id.' .dtfilter").on( \'input\', function () {
        
        codeup_datatable["'.$id.'"]
          .column( $(this).parent().index()+\':visible\' )
          .search(this.value)
          .draw()
    } );');
    }
    protected function getParams()
    {
        return $this->_options;
    }
    protected function initColumns()
    {
        if (isset($this->_options['columns'])) {
            foreach ($this->_options['columns'] as $key => $value) {
                if (is_string($value)) {
                    $this->_options['columns'][$key] = [
                        'data' => $value,
                        'title' => $this->model->getAttributeLabel($value)
                    ];
                }elseif(is_array($value)) {
                    if(!isset($value['title']) && !isset($value['class']))
                        $value['title'] = $this->model->getAttributeLabel($value['data']);
                    $this->_options['columns'][$key] = $value;
                }
                if (isset($value['type'])) {
                    if ($value['type'] == 'link') {
                        $value['class'] = LinkColumn::className();
                    }
                }
                if (isset($value['class'])) {
                    $column = \Yii::createObject($value);
                    //print_r($column);exit;
                    $this->_options['columns'][$key] = $column;
                }
                if(!is_object( $this->_options['columns'][$key]) && !isset( $this->_options['columns'][$key]['name'])){
                    $this->_options['columns'][$key]['name']= $this->_options['columns'][$key]['data'];
                }
            }
        }
    }
    public function __set($name, $value)
    {
//        if($name == 'columns')
//            return $this->_options[$name] = array_merge($this->_options[$name], $value);
        return $this->_options[$name] = $value;
    }
    public function __get($name)
    {
        return isset($this->_options[$name]) ? $this->_options[$name] : null;
    }
}