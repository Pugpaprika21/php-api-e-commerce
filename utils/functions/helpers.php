<?php

/**
 * @param mixed ...$params
 * @return void
 */
function dump()
{
    $vars = func_get_args();
    $last = end($vars);

    echo "<pre>";
    echo "<div id='debug-data' style='padding: 10px; color: #FFFFFF; background-color: #000000;'>";
    print_r((count($vars) > 1) ? $vars : $vars[0]);
    echo "</div>";
    echo "</pre>";

    if (is_int($last)) {
        exit;
    }
}

/**
 * @param array $array
 * @param int $case
 * @return array
 */
function arr_upr($array, $case = MB_CASE_TITLE)
{
    $convToCamel = function ($str) {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    };

    $newArray = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $newArray[$convToCamel($key)] = arr_upr($value, $case);
        } else {
            $newArray[$convToCamel($key)] = $value;
        }
    }
    return $newArray;
}

/**
 * @param string $text
 * @return string
 */
function conText($text)
{
	$outText = stripslashes(htmlspecialchars(trim($text), ENT_QUOTES));
	return $outText;
}
