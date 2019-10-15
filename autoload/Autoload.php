<?php


class Autoload
{
    public static $classMap = [];

    public static function setRegister()
    {
        // 注册自动加载方法
        spl_autoload_register('Autoload::load');
        return true;
    }

    public static function load($class)
    {
        //自动加载类库
        if (isset($classMap[$class])) {
            return true;
        } else {
            $classNew = str_replace('\\', '/', $class);
            $file = DIR . '/' . $classNew . '.php';
            if (is_file($file)) {
                include $file;
                // 加载类库完成，进行记录
                self::$classMap[$class] = $classNew;
            } else {
                return false;
            }
        }
        return true;
    }
}