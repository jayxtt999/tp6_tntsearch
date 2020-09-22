<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:51
 */

namespace app\service\TntResultHook;
use think\facade\Db;


class ServerIpBlock implements HookInterFace
{
    public function boot($result,$tag='')
    {
        $returnData = [];
        $lineCache  = cache('line_cache');
        if (isset($result['ids']) && $result['ids']) {
            $list = Db::table('server_ip_block')->field('id,serviceIp,lineId')->where('id', 'in', $result['ids'])->order('serviceIp asc,id desc')->limit(1)->select()->toArray();
            foreach ($list as $item) {
                $limeName     = isset($lineCache[$item['lineId']]) ? $lineCache[$item['lineId']] : '';
                $returnData[] = [
                    'result'        => $tag . '-' . $limeName,
                    'highlight_key' => $item['serviceIp'],
                    'url'           => 'BlockIp/index',
                    'url_param'     => [
                        'searchType' => 'ip',
                        'keyword' => $item['serviceIp'],
                    ],
                ];

            }
        }

        return $returnData;
    }


    public function insert(){

        $insertData = [];

        $config = config('tnt_index.server_ip_block@serviceIp');
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
                'serviceIp'=>$datum['serviceIp'],
            ];
        }
        return $insertData;
    }

}