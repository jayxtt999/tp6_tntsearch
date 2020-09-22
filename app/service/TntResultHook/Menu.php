<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:51
 */

namespace app\service\TntResultHook;

use think\facade\Db;


class Menu implements HookInterFace
{
    public function boot($result,$tag='')
    {
        $returnData = [];
        $list = Db::table('admin_menu')->field('id, title,url')->where('id', 'in', $result['ids'])->limit(10)->select()->toArray();
        foreach ($list as $item) {
            $returnData[] = [
                'result'        => $tag . '-' . $item['title'],
                'highlight_key' => $item['title'],
                'url'           => $item['url'],
                'url_param'     => [
                ],
            ];

        }

        return $returnData;
    }

    public function insert(){

        $insertData = [];

        $config = config('tnt_index.menu');
        $lastId = (int)cache($config['index']);
        $sql = $config['sql'];
        $where = $config['where'];
        if($where){
            $sql .= ($where.' and id >'.$lastId);
        }else{
            $sql .= (' where id >'.$lastId);
        }
        $data = Db::query($sql);
        foreach ($data as $datum){
            $insertData[] = [
                'id'=>$datum['id'],
                'title'=>$datum['title'],
            ];
        }
        return $insertData;
    }
}