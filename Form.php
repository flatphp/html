<?php namespace Flagphp\Html;

class Form
{
    protected $_data = array();

    public function __construct($data = array())
    {
        if (!empty($data)) {
            $this->setData($data);
        }
    }

    /**
     * Set Form data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function __get($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    /**
     * ===========================
     * From inputs
     * ===========================
     */

    public function text($name, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        return '<input type="text" name="' . $name . '" value="' . $this->_value($name, $default_value) . '"' . $this->_options($options) . ' />';
    }

    public function hidden($name, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        return '<input type="hidden" name="' . $name . '" value="' . $this->_value($name, $default_value) . '"' . $this->_options($options) . ' />';
    }

    public function email($name, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        return '<input type="email" name="' . $name . '" value="' . $this->_value($name, $default_value) . '"' . $this->_options($options) . ' />';
    }

    public function password($name, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        return '<input type="password" name="' . $name . '" value="' . $this->_value($name, $default_value) . '"' . $this->_options($options) . ' />';
    }

    public function textarea($name, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        return '<textarea name="' . $name . '"' . $this->_options($options) . '>' . $this->_value($name, $default_value) . '</textarea>';
    }

    public function select($name, $data, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        $str = '<select name="' . $name . '"' . $this->_options($options) . '>';
        foreach ($data as $k => $v) {
            $selected = ($k == $this->_value($name, $default_value)) ? ' selected' : '';
            $str .= '<option value="' . $k . '"' . $selected . '>' . $v . '</option>';
        }
        $str .= '</select>';
        return $str;
    }

    /**
     * $value two style:
     * '1'    => name="test[]" value="1"
     * '10:2' => name="test[10]" value="2"
     */
    public function checkbox($name, $value = 1, $options = null, $checked = false)
    {
        $checked = $checked ? ' checked' : '';
        if (true == ($poz = strpos($value, ':'))) {
            $name .= '['. substr($value, 0, $poz) .']';
            $value = substr($value, $poz + 1);
        } else {
            $name .= '[]';
        }
        return '<input type="checkbox" name="' . $name . '" value="' . $value . '"' . $checked . $this->_options($options) . ' />';
    }

    public function radio($name, $value, $options = null, $checked = false)
    {
        $checked = $checked ? ' checked' : '';
        return '<input type="radio" name="' . $name . '" value="' . $value . '"' . $checked . $this->_options($options) . ' />';
    }

    public function checkboxGroup($name, $data, $options = null)
    {
        $default_value = $this->_defaultValue($options, []);
        $checked_list = $this->_value($name, $default_value);
        if (!is_array($checked_list)) {
            $checked_list = explode(',', $checked_list);
        }
        $str = '';
        $class = isset($options['class']) ? (' class="'. $options['class'] .'"') : '';
        unset($options['class']);
        foreach ($data as $k => $v) {
            $checked = in_array($k, $checked_list);
            $str .= '<label'. $class .'>' . $this->checkbox($name, $k, $options, $checked) .'<span>'. $v . '</span></label>';
        }
        return $str;
    }

    public function radioGroup($name, $data, $options = null)
    {
        $default_value = $this->_defaultValue($options);
        $str = '';
        foreach ($data as $k => $v) {
            $checked = ($k == $this->_value($name, $default_value)) ? ' checked' : '';
            $str .= '<label>' . $this->radio($name, $k, $checked, $options) . $v . '</label>';
        }
        return $str;
    }

    /**
     * Get the value
     * @param $name
     * @param $default_value
     * @return string
     */
    protected function _value($name, $default_value = '')
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : $default_value;
    }

    /**
     * Concat options
     * @param array $options
     * @param array $apend
     * @return string
     */
    protected function _options($options)
    {
        if (empty($options)) {
            return '';
        }
        if (is_string($options)) {
            return ' '. $options;
        }
        $str = '';
        foreach ($options as $k => $v) {
            $str .= ' '. $k .'="'. $v .'"';
        }
        return $str;
    }

    /**
     * @param $options
     * @param string $default
     * @return string
     */
    protected function _defaultValue(&$options, $default = '')
    {
        $default_value = $default;
        if (isset($options['default_value'])) {
            $default_value = $options['default_value'];
            unset($options['default_value']);
        }
        return $default_value;
    }
}