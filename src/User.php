<?php
/***************************************************************************
 * @Description: 通过debut.sports.sina.com.cn项目提供的API获取用户信息
 *  wiki: http://wiki.intra.sina.com.cn/display/netdevpublic/debut.sports.sina.com.cn
 * 
 * @FileName:         User.php
 * @Author :          liyong5@staff.sina.com.cn
 * @CreatedTime:      Tue 21 May 2019 02:02:02 PM CST
 ************************************************************************/
namespace Daisy\SSUC;

class User 
{
    const API_IS_LOGIN = 'http://debut.sports.sina.com.cn/uc/api/intra/islogin';

    const API_FETCH_USER = 'http://debut.sports.sina.com.cn/uc/api/intra/get_by_uid';

    const API_FETCH_USERS = 'http://debut.sports.sina.com.cn/uc/api/intra/get_by_uids';

    const API_FETCH_USER_SID = 'http://debut.sports.sina.com.cn/uc/api/intra/get_by_sid';

    const API_FETCH_USER_SIDS = 'http://debut.sports.sina.com.cn/uc/api/intra/get_by_sids';

    /**
     * 验证用户是否登录, 未登录/未找到用户信息返回false, 登录返回用户信息, 登录用户的票据需要放到$_COOKIE['SUB']中,
     * 默认票据有效域为 .sports.sina.com.cn 如果使用的是其它域请在$_COOKIE['sso_domain']中指定:
     * 例 $_COOKIE['sso_domain']='.sina.com.cn;'
     *
     * return false | array
     * throw Exception
     * throw BaseModelException
     */
    public static function islogin() {
        Tool::checkEnv();
        if (! isset($_COOKIE['SUB']) || empty($_COOKIE['SUB'])) {
            return false;
        }

        $arr = [];
        foreach ($_COOKIE as $key => $value) {
            array_push($arr, "{$key}={$value}");
        }
        $cookie = implode(';', $arr);

        $result = \BaseModelHttp::get(self::API_IS_LOGIN, Tool::rheader(), 0.5, $cookie, 2);
        $result = json_decode($result, true);

        if (isset($result['result']['code']) && 0 !== $result['result']['code']) {
            throw new \BaseModelException('[ssuc:getByUid]' . $result['result']['status']['msg'],
                    $result['result']['status']['code']);
        }
        return $result['result']['data'];
    }

    /**
     * 单个用户信息
     * return false | array
     *      [
     *          uid:"",
     *          sid:"",
     *          avator:"",
     *          avator2:"",
     *          nickname:"",
     *          sex:""
     *      ]
     *      ]
     * throw Exception
     * throw BaseModelException
     */
    public static function getByUid($uid) {
        Tool::checkEnv();

        if (empty($uid)) {
            throw new \BaseModelException('[ssuc::getByUid]参数错误');
        }

        $post = array_merge(['uid' => $uid], (array)Tool::appinfo());
        $header = Tool::rheader();

        $result = \BaseModelHttp::post(self::API_FETCH_USER, $post, $header, 0.5, '', 2);
        $result = json_decode($result, true);

        if (isset($result['result']['code']) && 0 !== $result['result']['code']) {
            throw new \BaseModelException('[ssuc:getByUid]' . $result['result']['status']['msg'],
                    $result['result']['status']['code']);
        }
        if (empty($result['result']['data'])) {
            return false;
        }
        return $result['result']['data'];
    }

    /**
     * 匹量获取用户信息
     * return array
     *      [
     *          "xxxxx" => [
     *              uid:"",
     *              sid:"",
     *              avator:"",
     *              avator2:"",
     *              nickname:"",
     *              sex:"",
     *          ]
     *      ]
     * throw Exception
     * throw BaseModelException
     */
    public static function getByUids($uids) {
        Tool::checkEnv();

        if (! is_array($uids)) {
            throw new \BaseModelException('参数错误[debut:info]');
        }
        $uids = array_filter($uids);
        if (empty($uids)) {
            throw new \BaseModelException('参数错误[debut:info]');
        }

        $post = array_merge(['uids' => implode(',', $uids)], (array)Tool::appinfo());
        $header = Tool::rheader();

        $result = \BaseModelHttp::post(self::API_FETCH_USERS, $post, $header, 0.5, '', 2);
        $result = json_decode($result, true);

        if (isset($result['result']['code']) && 0 !== $result['result']['code']) {
            throw new Exception($result['result']['status']['msg'],
                    $result['result']['status']['code']);
        }

        $users = [];
        foreach ($result['result']['data'] as $user) {
            $users[$user['uid']] = $user;
        }
        return $users;
    }

    /**
     * 通过sid获取用户信息
     * return false | array
     *      返回用户信息同getByUid
     *
     * throw Exception
     * throw BaseModelException
     */
    public static function getBySid($sid) {
        Tool::checkEnv();

        if (empty($sid)) {
            throw \BaseModelException('参数错误[debut:info]');
        }

        $post = array_merge(['sid' => $sid], (array)Tool::appinfo());
        $header = Tool::rheader();

        $result = \BaseModelHttp::post(self::API_FETCH_USER_SID, $post, $header, 0.5, '', 2);
        $result = json_decode($result, true);

        if (isset($result['result']['code']) && 0 !== $result['result']['code']) {
            throw new Exception($result['result']['status']['msg'],
                    $result['result']['status']['code']);
        }
        if (empty($result['result']['data'])) {
            return false;
        }
        return $result['result']['data'];
    }

    /**
     * 通过sid匹量获取用户信息
     * return array
     *      返回用户信息同getByUids
     *
     * throw Exception
     * throw BaseModelException
     */
    public static function getBySids($sids) {
        Tool::checkEnv();

        if (! is_array($sids)) {
            throw new \BaseModelException('参数错误[debut:info]');
        }
        $sids = array_filter($sids);
        if (empty($sids)) {
            throw new \BaseModelException('参数错误[debut:info]');
        }

        $post = array_merge(['sids' => implode(',', $sids)], (array)Tool::appinfo());
        $header = Tool::rheader();

        $result = \BaseModelHttp::post(self::API_FETCH_USER_SIDS, $post, $header, 0.5, '', 2);
        $result = json_decode($result, true);

        if (isset($result['result']['code']) && 0 === $result['result']['code']) {
            throw new Exception($result['result']['status']['msg'],
                    $result['result']['status']['code']);
        }

        $users = [];
        foreach ($result['result']['data'] as $user) {
            $users[$user['sid']] = $user;
        }
        return $users;
    }
}
