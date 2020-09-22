<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;

class Index extends BaseController
{

    public function search(){

        $key = input('key','','trim');
        if(!$key){
            return  json(['result'=>false,'message'=>'key is empty..']);
        }
        $number = (int)input('number',1);
        $config = config('tnt_index');
        $lineCache = cache('line_cache');
        if(!$lineCache){
            $lineList = Db::table('server_line')->field('id,name')->where('status', '<>','-1')->select()->toArray();
            $lineList = array_column($lineList,'name','id');
            cache('line_cache',$lineList);
        }
        $returnResult = [];
        $i = 0;
        $defaultUrlKey = env('DEFAULT_URL_KEY');
        foreach ($config as $item){
            /**
             * @var $tnt \TeamTNT\TNTSearch\TNTSearch
             */
            $tnt = app('TNTSearch');
            $index = $item['index'];
            $hook = $item['hook'];
            $name = $item['name'];
            $searchFuzziness = $item['search_fuzziness'];
            $search = $item['search'];
            $tnt->selectIndex($index);
            if($searchFuzziness){
                $tnt->fuzzy_distance = 4;
                $tnt->fuzziness = true;
                //if(preg_match("/^(\d{1,3}\.?)+/",$key)){
                //    $tnt->fuzzy_distance = 4;
                //}
                //if(preg_match("/^\d{16}$/",$key)){
                //    $tnt->fuzziness = false;
                //}
                //if(preg_match("/^\d+$/",$key)){
                //    $tnt->fuzzy_distance = 2;
                //}
            }
            if($search =='search'){
                $result = $tnt->search($key, $number);
            }
            if($search =='searchBoolean'){
                $result = $tnt->searchBoolean($key);
            }
            $resultHook = invoke($hook);
            $result = $resultHook->boot($result,$name);
            //echo '<pre>';
            //print_r($result);exit;
            if($result){
                foreach ($result as $item){
                    $url = url($defaultUrlKey."****".$item['url'],$item['url_param'])->build();
                    $url = str_replace('****','/',$url);
                    $returnResult[$i] = [
                        'id'=>$i,
                        'word'=>$item['highlight_key'],
                        'description'=>$item['result'],
                        'url'=>$url ,
                    ];
                    $i++;
                }
            }
        }
        return  json(['result'=>true,'data'=>$returnResult]);
    }


    public function init(){
        
        /**
         * @var $tnt \TeamTNT\TNTSearch\TNTSearch
         */
        $tnt = app('TNTSearch');
        $config = config('tnt_index');
        foreach ($config as $item){
            $index = $item['index'];
            $name = $item['name'];
            $sql = $item['sql'];
            $indexer = $tnt->createIndex($index);
            $indexer->query($sql);
            $indexer->run();
            //echo ("Success:" . $name.'<br/>');
        }
        return  json(['result'=>true,'data'=>'success']);

    }

}
