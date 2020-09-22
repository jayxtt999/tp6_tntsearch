<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:36
 */

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Db;

class AddIndex  extends Command
{
    protected function configure()
    {
        $this->setName('AddIndex')
             ->setDescription('AddIndex');
    }

    protected function execute(Input $input, Output $output)
    {

        /**
         * @var $tnt \TeamTNT\TNTSearch\TNTSearch
         */
        $tnt = app('TNTSearch');
        $config = config('tnt_index');
        foreach ($config as $item){
            $tnt->config['tokenizer'] = null;
            $tnt->selectIndex($item['index']);
            $index = $tnt->getIndex();
            $hook = $item['hook'];
            $resultHook = invoke($hook);
            $insertData = $resultHook->insert();
            foreach ($insertData as $insertDatum){
                $index->insert($insertDatum);
                $output->writeln("insert id :" . $insertDatum['id']);
            }

            $sql   = $item['sql'];
            $where = $item['where'];
            if ($where) {
                $sql .= (' '.$where);
            }
            $last_id_sql = $item['last_id_sql'];
            if ($where) {
                $last_id_sql .= (' '.$where);
            }
            $res    = Db::query($last_id_sql);
            $lastId = $res[0]['max'];
            cache($item['index'], $lastId);

            $output->writeln("Success:" . $item['name']);

        }
    }

}