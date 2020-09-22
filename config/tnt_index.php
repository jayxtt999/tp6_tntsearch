<?php
/**
 * Created by PhpStorm.
 * User: xietaotao
 * Date: 2020/9/3
 * Time: 11:28
 */

return [

    'servers@ip'=>[
        'name'             => '云服务器业务IP',
        'index'            => 'servers.ip',
        'sql'              => 'SELECT id, ip FROM servers',
        'last_id_sql'          => 'SELECT max(id)  as max  FROM servers',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\Servers1::class,
        'search'           => 'search',
        'search_fuzziness' => true,

    ],
    'servers@guid'=>[
        'name'             => '云服务器GUID',
        'index'            => 'servers.guid',
        'sql'              => 'SELECT id, guid FROM servers',
        'last_id_sql'          => 'SELECT max(id)  as max FROM servers',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\Servers2::class,
        'search'           => 'search',
        'search_fuzziness' => true,

    ],

    'server_ip@ip'=>[
        'name'             => '云服务器资源IP',
        'index'            => 'server_ip.ip',
        'sql'              => 'SELECT id, ip FROM server_ip',
        'last_id_sql'          => 'SELECT max(id)  as max FROM server_ip',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\ServerIp::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],
    'server_ip_block@serviceIp'=>[
        'name'             => '云服务器黑洞ip',
        'index'            => 'server_ip_block.serviceIp',
        'sql'              => 'SELECT id, serviceIp FROM server_ip_block',
        'last_id_sql'          => 'SELECT max(id)  as max FROM server_ip_block',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\ServerIpBlock::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],
    'server_ip_exception@serviceIp'=>[
        'name'             => '云服务器异常ip',
        'index'            => 'server_ip_exception.serviceIp',
        'sql'              => 'SELECT id, serverIp FROM server_ip_exception',
        'last_id_sql'          => 'SELECT max(id)  as max FROM server_ip_exception',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\ServerIpException::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],
    'server_master@ip'=>[
        'name'             => '宿主机ip',
        'index'            => 'server_master.ip',
        'sql'              => 'SELECT id, ip FROM server_master',
        'last_id_sql'          => 'SELECT max(id)  as max FROM server_master',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\ServerMaster1::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],
    'server_master@gateway_ip'=>[
        'name'             => '宿主机网关ip',
        'index'            => 'server_master.gateway_ip',
        'sql'              => 'SELECT id, gateway_ip FROM server_master',
        'last_id_sql'          => 'SELECT max(id)  as max FROM server_master',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\ServerMaster2::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],
    'host@ip'=>[
        'name'             => '虚拟主机资源',
        'index'            => 'host.ip',
        'sql'              => 'SELECT id, ip FROM host',
        'last_id_sql'          => 'SELECT max(id)  as max FROM host',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\Host::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],
    'host_ip@ip'=>[
        'name'             => '虚拟主机IP',
        'index'            => 'host_ip.ip',
        'sql'              => 'SELECT id, ip FROM host_ip',
        'last_id_sql'          => 'SELECT max(id)  as max FROM host_ip',
        'where'            => '',
        'hook'             => \app\service\TntResultHook\HostIp::class,
        'search'           => 'search',
        'search_fuzziness' => true,


    ],

    'menu'=>[
        'name'             => '菜单',
        'index'            => 'menu',
        'sql'              => 'SELECT id, title FROM admin_menu',
        'last_id_sql'          => 'SELECT max(id)  as max FROM admin_menu',
        'where'            => ' where pid<>0 and `status`<>-1',
        'hook'             => \app\service\TntResultHook\Menu::class,
        'search'           => 'search',
        'search_fuzziness' => true,

    ],

];