<?php

include_once dirname(__FILE__) . '/../Validation_Interface.php';

class Validation_Sanitize implements Validation_Interface
{
    private static $indicator = 'sanitize';

    public static function getIndicator()
    {
        return self::$indicator;
    }

    /**
     * [[Description]]
     * @author Till Uhlig
     * @param  [[Type]] $key              [[Description]]
     * @param  [[Type]] $input            [[Description]]
     * @param  [[Type]] [$setting = null] [[Description]]
     * @param  [[Type]] [$param = null]   [[Description]]
     * @return [[Type]] [[Description]]
     */
    public static function validate_sanitize_url($key, $input, $setting = null, $param = null)
    {
        if ($setting['setError']) {
            return;
        }

        if (!isset($input[$key]) || empty($input[$key])) {
            return;
        }

        $var = $input[$key];

        if (!is_string($var)) {
            $var = strval($var);
        }

        $var = filter_var($var, FILTER_SANITIZE_URL);

        return array('valid'=>true,'field'=>$key,'value'=>$var);
    }

    /**
     * [[Description]]
     * @author Till Uhlig
     * @param  [[Type]] $key              [[Description]]
     * @param  [[Type]] $input            [[Description]]
     * @param  [[Type]] [$setting = null] [[Description]]
     * @param  [[Type]] [$param = null]   [[Description]]
     * @return [[Type]] [[Description]]
     */
    public static function validate_sanitize($key, $input, $setting = null, $param = null)
    {
        if ($setting['setError']) {
            return;
        }

        if (!isset($input[$key]) || empty($input[$key])) {
            return;
        }

        $var = self::cleanInput($input[$key]);

        return array('valid'=>true,'field'=>$key,'value'=>$var);
    }

    /**
     * [[Description]]
     * @author Till Uhlig
     * @param  [[Type]] $input [[Description]]
     * @return [[Type]] [[Description]]
     */
    private static function cleanInput($input)
    {
        if (is_array($input)) {

            foreach ($input as &$element) {
                // pass $element as reference so $input will be modified
                $element = self::cleanInput($element);
            }
        } else {

            if (get_magic_quotes_gpc() == 0) {
                // magic quotes is turned off
                $input = htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
            } else {
                $input = htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, 'UTF-8');
            }
        }

        return $input;
    }
}
