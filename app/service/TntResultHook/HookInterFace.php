<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:53
 */

namespace app\service\TntResultHook;


interface HookInterFace
{

    /**
     * @param $result
     *
     *
     * @return mixed
     * @author xietaotao
     */
    public function boot($result,$tag='');
}