<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 10:14
 */

namespace app\service;
use TeamTNT\TNTSearch\TNTSearch;
use think\Service;

class TntService extends Service
{
    public function register()
    {
        $tnt = new TNTSearch();

        $tnt->loadConfig([
                             'driver'    => config('database.connections.mysql.type'),
                             'host'      => config('database.connections.mysql.hostname'),
                             'port'      => config('database.connections.mysql.hostport'),
                             'database'  => config('database.connections.mysql.database'),
                             'username'  => config('database.connections.mysql.username'),
                             'password'  => config('database.connections.mysql.password'),
                             'storage'   => root_path('cache'),
                             'tokenizer'   => \app\extend\NyTokenizer::class,
                             'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
                         ]);




        $this->app->bind('TNTSearch', $tnt);




    }




}