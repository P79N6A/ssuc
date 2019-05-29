<?php
/***************************************************************************
 * @Description:
 * 
 * @FileName:         bootstrap.php
 * @Author :          liyong5@staff.sina.com.cn
 * @CreatedTime:      Mon 27 May 2019 04:14:28 PM CST
 ************************************************************************/

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    $loader = require_once __DIR__ . '/../vendor/autoload.php';
} else {
    throw new Exception('Can\'t find autoload.php. Did you install dependencies with Composer?');
}

// 加载dagger环境
// TODO 请指定版本和路径
define('DAGGER_VERSION', '');
define('DAGGER_LIB_PATH', '');
define('PATH_ROOT', rtrim(dirname(__FILE__), "/") . "/");
if (false === (@include_once DAGGER_LIB_PATH)) {
    throw new Exception('无法加载dagger');
}

// 检查必要的系统配置
if (! class_exists(SysInitConfig)) {
    throw new Exception('请添加系统配置');
}
