<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:51
 */

namespace app\service\TntResultHook;


use think\facade\Db;

class Servers2 implements HookInterFace
{

    public function boot($result,$tag='')
    {
        $returnData = [];
        $lineCache  = cache('line_cache');
        if (isset($result['ids']) && $result['ids']) {
            $servers = Db::table('servers')->field('id,ip,lineID,cpu,memory')->where('id', 'in', $result['ids'])->where('orderStatus','<>','-2')->order('ip asc,id desc')->limit(1)->select()->toArray();
            foreach ($servers as $server) {
                $limeName     = isset($lineCache[$server['lineID']]) ? $lineCache[$server['lineID']] : '';
                $returnData[] = [
                    'result'        => $tag. '-'  . $limeName . '-' . $server['cpu'] . 'H' . $server['memory'] . 'G',
                    'highlight_key' => $server['ip'],
                    'url'           => 'Servers/listOne',
                    'url_param'     => ['serverid' => $server['id']],
                ];

            }
            $servers = Db::table('servers')->field('id,ip,lineID,cpu,memory')->where('id', 'in', $result['ids'])->where('orderStatus','=','-2')->order('ip asc,id desc')->limit(1)->select()->toArray();
            foreach ($servers as $server) {
                $limeName     = isset($lineCache[$server['lineID']]) ? $lineCache[$server['lineID']] : '';
                $returnData[] = [
                    'result'        => $tag. '-'  . $limeName . '-' . $server['cpu'] . 'H' . $server['memory'] . 'G-已删除',
                    'highlight_key' => $server['ip'],
                    'url'           => 'Servers/listOne',
                    'url_param'     => ['serverid' => $server['id']],
                ];

            }
        }
        return $returnData;
    }



    public function insert(){

        $insertData = [];

        $config = config('tnt_index.servers@guid');
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
                'guid'=>$datum['guid'],
            ];
        }
        return $insertData;
    }
}
