<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:52
 */

namespace app\service\TntResultHook;
use think\facade\Db;


class ServerMaster1 implements HookInterFace
{
    public function boot($result,$tag='')
    {
        $returnData = [];
        $lineCache  = cache('line_cache');
        if (isset($result['ids']) && $result['ids']) {
            $list = Db::table('server_master')->field('id,ip,lineID,remarks')->where('id', 'in', $result['ids'])->order('ip asc ,id desc')->limit(1)->select()->toArray();
            foreach ($list as $item) {
                $limeName     = isset($lineCache[$item['lineID']]) ? $lineCache[$item['lineID']] : '';
                $returnData[] = [
                    'result'        => $tag . '-' . $limeName. '-' . $item['remarks'],
                    'highlight_key' => $item['ip'],
                    'url'           => 'Master/index',
                    'url_param'     => [
                        'searchType' => 'ip',
                        'keyword' => $item['ip'],
                    ],
                ];

            }
        }
        return $returnData;
    }

    public function insert(){

        $insertData = [];

        $config = config('tnt_index.server_master@ip');
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
                'ip'=>$datum['ip'],
            ];
        }
        return $insertData;
    }
}