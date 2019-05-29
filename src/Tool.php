<?php
/***************************************************************************
 * @Description: 工具类
 * 
 * @FileName:         Tool.php
 * @Author :          liyong5@staff.sina.com.cn
 * @CreatedTime:      Tue 21 May 2019 02:10:28 PM CST
 ************************************************************************/
namespace Daisy\SSUC;

class Tool
{
    // 验证是否在Dagger环境下运行
    public static function checkEnv() {
        if (! defined('DAGGER_ROLE')) {
            throw new Exception('未加载Dagger环境');
        }

        $coreClass = [
            '\BaseModelHttp',
            '\BaseModelMemcached',
            '\BaseModelException',
            '\SysInitConfig',
            '\BaseModelLog',
        ];
        foreach ($coreClass as $cn) {
            if (! class_exists($cn, true)) {
                throw new Exception('缺少类' . $cn);
            }
        }
        return true;
    }

    // 收集当前应用信息
    public static function appinfo() {
        return [
            'version'  => self::version(),
            'env'      => defined('QUEUE') ? 'cli' : (defined('WEB') ? 'web' : 'nil'),
        ];
    }

    // 请求头信息
    public static function rheader() {
        return [
            'ssuc-auth-v'       => \SysInitConfig::$config['ssuc']['auth_v'],
            'ssuc-auth-pid'     => \SysInitConfig::$config['sys']['project_id'],
            'ssuc-auth-secret'  => self::sign(\SysInitConfig::$config['ssuc']['auth_v'],
                    \SysInitConfig::$config['sys']['project_id'], \SysInitConfig::$config['sys']['project_key']),
            'Referer'           => defined('DOMAIN') ? 'http://' . DOMAIN : 'http://sports.sina.com.cn',
        ];
    }

    public static function version() {
        return '0.1.0';
    }

    // 生成加密串
    public static function sign($key1, $key2, $key3) {
        $str = strrev(md5(sprintf('%s,%s,%s', $key1, $key2, $key3)));
        return substr(sha1($str), 6, 20);
    }
}
