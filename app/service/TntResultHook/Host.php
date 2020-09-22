<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:52
 */

namespace app\service\TntResultHook;
use think\facade\Db;


class Host implements HookInterFace
{
    public function boot($result,$tag='')
    {
        $returnData = [];
        $lineCache  = cache('line_cache');
        if (isset($result['ids']) && $result['ids']) {
            $servers = Db::table('server_ip')->field('id, ip,lineId')->where('id', 'in', $result['ids'])->order('ip asc,id desc')->limit(1)->select()->toArray();
            foreach ($servers as $server) {
                $limeName     = isset($lineCache[$server['lineId']]) ? $lineCache[$server['lineId']] : '';
                $returnData[] = [
                    'result'        => $tag . '-' . $limeName,
                    'highlight_key' => $server['ip'],
                    'url'           => 'Ip/index',
                    'url_param'     => [
                        'searchType' => 'ip',
                        'keyword' => $server['ip'],
                    ],
                ];

            }
        }

        return $returnData;
    }


    public function insert(){

        $insertData = [];

        $config = config('tnt_index.host@ip');
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