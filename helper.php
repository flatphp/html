<?php namespace Flatphp\Html;

/**
 * get asset url
 * @param string $file
 * @return string
 */
function asset($file)
{
    static $url_base = null;
    if (null === $url_base) {
        $url_base = _base();
    }
    return $url_base .'/'. $file;
}

/**
 * get url base
 * @return string
 */
function _base()
{
    $script = filter_has_var(INPUT_SERVER, 'SCRIPT_NAME') ? filter_input(INPUT_SERVER, 'SCRIPT_NAME') : filter_input(INPUT_SERVER, 'PHP_SELF');
    return rtrim(dirname($script), '\\/');
}
