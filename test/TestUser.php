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
    ];

    // 待测试的用户sid
    public $sids = [
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
        // TODO 请添加登录信息
        $result = User::isLogin();

        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('uid', $result);

        $result = User::isLogin();

        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('uid', $result);
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
