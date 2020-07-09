<?php

if (! function_exists('mask'))
{
    function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}

if (! function_exists('flash'))
{
    function flash($type, $message)
    {
        Session::flash('message', __($message));
        Session::flash('alert-type', $type);
    }
}

if (! function_exists('alternative_money'))
{
    function alternative_money(float $val, $symbol='$', $r=2, $dec_point=".", $thousands_sep = ",")
    {
        return __($symbol) . ' '. number_format($val, $r, $dec_point, $thousands_sep);
    }
}

if (! function_exists('sanitize_var'))
{
    function sanitize_var($var, $filter = FILTER_DEFAULT, $options = null)
    {
        if ($filter == FILTER_SANITIZE_NUMBER_INT)
        {
            return str_replace(['-', '+'], '', filter_var($var, $filter, $options));
        }
        return filter_var($var, $filter, $options);
    }
}
