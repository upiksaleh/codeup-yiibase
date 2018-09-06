<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\widgets\datatable;


use yii\base\BaseObject;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class ActionColumn extends BaseObject
{
    public $queryParams = [];
    public $baseUrl;
    public $links = [
        [
            'name' => 'view',
            'label'=> '<i class="fa fa-eye"></i>',
            'options' => ['title'=>'Lihat','class'=>'btn btn-default']

        ],
        [
            'name' => 'update',
            'label'=> '<i class="fa fa-pencil"></i>',
            'options' => ['title'=>'Update','class'=>'btn btn-info']

        ],
        [
            'name' => 'delete',
            'label'=> '<i class="fa fa-remove"></i>',
            'options' => ['title'=>'Hapus','class'=>'btn btn-danger']

        ],
    ];
    public $append_links = [];
    public $title= "Aksi";
    public $visible=true;
    public $options = [];
    public $data = null;
    public $render;
    public $searchable;
    public $orderable;
    public $width = "10%";
    public $className = 'text-center';
    public function init()
    {
        $this->title =\Yii::t('app',$this->title);
        $this->searchable = false;
        $this->orderable = false;
        $visible = $this->visible;
        if(is_array($visible)) $this->visible = true;
        if($this->append_links){
            foreach($this->append_links as $append_links) {
                array_push($this->links, $append_links);
            }
        }
        if (!isset($this->render)) {
            $links = [];
            foreach($this->links as $link){
                if(!isset($link['options']))
                    $link['options'] = [];
                $link['options']['id'] = 'dt-link-'.$link['name'].'-';
                if($link['name'] == 'delete'){
                    $link['options']['data-method'] = 'post';
                    $link['options']['data-confirm'] =  \Yii::t('app', 'Yakin untuk menghapus item ini?');
                }elseif($link['name'] == 'update'){
                    $link['options']['data-toggle'] = 'modal';
                    $link['options']['data-target'] = '#modal-form-data';
                }elseif($link['name'] == 'view'){
                    //$link['options']['data-toggle'] = 'modal';
                    //$link['options']['data-target'] = '#modal-form-data';
                }
                if((!is_array($visible)) || (is_array($visible) && in_array($link['name'],$visible)))
                    $links[$link['name']] = Html::a($link['label'], [$this->baseUrl.'/'.$link['name']], $link['options']);
            }
            $this->render = new JsExpression('function render( data, type, row, meta ){
                var html =\'<span class="btn-group btn-group-xs">\';
                var p = ' . Json::encode($this->queryParams) . ';
                var q = {};for (var i = 0; i < p.length; i++) {q[p[i]] = row[p[i]];}
                var links = '.Json::encode($links).';
                jQuery.each(links,function(key, val){
                    var link = jQuery(val);
                    var paramPrefix = ((link.attr("href").indexOf("?") < 0) ? "?" : "&");
                    link.attr("id", link.attr("id") + meta.row);
                    link.attr("href", link.attr("href") + paramPrefix + jQuery.param(q));
                    html += link.get()[0].outerHTML;
                })
                html += "</span>";
                return html;
            }');
        }
    }
}