<?php
/***************************************************************************
 * @Description:
 * 
 * @FileName:         TestUser.php
 * @Author :          liyong5@staff.sina.com.cn
 * @CreatedTime:      Fri 24 May 2019 05:50:15 PM CST
 ************************************************************************/
namespace Daisy\SSUC\Test;

use Daisy\SSUC\User;

class TestUser extends \PHPUnit\Framework\TestCase
{
    // 待测试的用户id
    public $uids = [
        '3137174017',
        '6808055814',
        '2118803707',
        '1265539540',
        '6809080397',
        '5467955978',
        '5679146080',
        '6808003129',
    ];

    // 待测试的用户sid
    public $sids = [
        '240124406428013520',
        '240127949686442656',
        '240145925325553504',
        '240161329468311072',
        '240177859744014336',
        '240173109191391424',
        '240163408325476192',
        '240560690136973152',
    ];
    public function testGetByUids() {
        $uids = $this->uids;
        $result = User::getByUids($uids);

        $this->assertNotEmpty($result);
        $this->assertCount(count($uids), $result);
        foreach ($uids as $id) {
            $this->assertArrayHasKey($id, $result);
            $this->allField($result[$id]);
        }
    }

    public function testGetByUid() {
        foreach ($this->uids as $uid) {
            $result = User::getByUid($uid);
            $this->assertNotEmpty($result);
            $this->allField($result);
        }
    }

    public function testIsLogin() {
        $_COOKIE['SUB'] = '_2AyGFTM4VlHO1f-QWj28Yv0Q-yLKE_jvMVu4b6VnN2J13Y-WXlZJwAWiQyDS0XI1mq3yFc2IPPRObzq02ygLOv9p4';
        $_COOKIE['sso_domain'] = '.sports.sina.cn';
        $result = User::isLogin();

        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('uid', $result);

        // $_COOKIE['SUB'] = '_2AyGFTz1HlHM1f-QYj2oZvk08z76E_jvMVv1J6VnN2J13Z-WXlZNHAWiQz6oNvVYMTlN9o2yMfA6t-G250zZvbyUP';
        // $_COOKIE['sso_domain'] = '.sports.sina.cn';
        // $result = User::isLogin();

        // $this->assertNotEmpty($result);
        // $this->assertArrayHasKey('uid', $result);
    }

    public function testGetBySid() {
        foreach ($this->sids as $sid) {
            $result = User::getBySid($sid);
            $this->assertNotEmpty($result);
            $this->allField($result);
        }
    }

    public function testGetBySids() {
        $result = User::getBySids($this->sids);

        $this->assertNotEmpty($result);
        $this->assertCount(count($this->sids), $result);
        foreach ($this->sids as $sid) {
            $this->assertArrayHasKey($sid, $result);
            $this->allField($result[$sid]);
        }
    }

    private function allfield($result) {
        $this->assertArrayHasKey('uid', $result);
        $this->assertArrayHasKey('sid', $result);
        $this->assertArrayHasKey('nickname', $result);
        $this->assertArrayHasKey('sex', $result);
        $this->assertArrayHasKey('avator', $result);
    }
}
