<?php

include_once dirname(__DIR__) . "/db/dbo.php";
include "./util.php";

$ip = getIp();
$result = ['code' => -1, 'token' => base64_encode($ip . 'abc')];

$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';

try {
    $m = new Model();
    $siteconfig = $m->find("SELECT * FROM admin_config WHERE id < 4");
    if ($siteconfig) {
        $data = [];

        foreach ($siteconfig as $k => $v) {
            $data[$v['id']] = $v;
        }

        $result['code'] = 1;

        if ($q == 3) {
            $result['data'] = $data[3]['value'];
        } else {
            $result['data'] = $data;
        }
    }
} catch (Exception $e) {

} finally {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}


