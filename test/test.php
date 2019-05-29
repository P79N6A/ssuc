<?php
/***************************************************************************
 * @Description:
 * 
 * @FileName:         test.php
 * @Author :          liyong5@staff.sina.com.cn
 * @CreatedTime:      Tue 28 May 2019 04:10:53 PM CST
 ************************************************************************/

namespace Daisy\SSUC\Test;
use Daisy\SSUC\User;
require_once __DIR__ . '/bootstrap.php';

testGetByUids();

function testGetByUids() {
    $uids = [
        '3137174017',
        '6808055814',
        '2118803707',
        '1265539540',
        '6809080397',
        '5467955978',
        '5679146080',
        '6808003129',
    ];
    $result = User::getByUids($uids);
    print_r($result);
}
