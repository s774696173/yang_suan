<?php
/**
 * 获取客户端IP
 * @return string 返回ip地址,如127.0.0.1
 */
function getIp()
{
    $onlineip = 'Unknown';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        $real_ip = $ips['0'];
        if ($_SERVER['HTTP_X_FORWARDED_FOR'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $real_ip))
        {
            $onlineip = $real_ip;
        }
        elseif ($_SERVER['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
        {
            $onlineip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_CDN_SRC_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_SRC_IP']))
    {
        $onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
        $c_agentip = 0;
    }
    if ($onlineip == 'Unknown' && isset($_SERVER['HTTP_NS_IP']) && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_NS_IP'] ))
    {
        $onlineip = $_SERVER ['HTTP_NS_IP'];
        $c_agentip = 0;
    }
    if ($onlineip == 'Unknown' && isset($_SERVER['REMOTE_ADDR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['REMOTE_ADDR']))
    {
        $onlineip = $_SERVER['REMOTE_ADDR'];
        $c_agentip = 0;
    }
    return $onlineip;
}