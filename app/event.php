<?php

/**
 * @author DjJustin
 * @copyright 2015
 */

class event
{
    public static $events = array();
    public static function run($event, &$args = array())
    {
        
        if(isset(self::$events[$event]))
        {
            foreach(self::$events[$event] as $func)
            {
                
                call_user_func($func, $args);
            }
        }
    }
    public static function addHandler($event, Closure $func)
    {
        self::$events[$event][] = $func;
    }
}

?>