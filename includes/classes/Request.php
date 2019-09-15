<?php
class Request
{
    private function prepareValue($requestType, $key, $defaultValue = null) {
        if ($this->_isset($key, $defaultValue)) {
            $value = $requestType[$key];
            if (is_array($value)) {
                return $value;
            }
            return stringInput($value);
        }
        return $defaultValue;
    }

    private function _isset($key, $defaultValue = null) {
        return isset($_REQUEST[$key]);
    }

    public function _int($key, $defaultValue = 0){
        if ($this->_isset($key)){
            return (int)$_REQUEST[$key];
        }
        return $defaultValue;
    }

    public function _double($key, $defaultValue = 0){
        if ($this->_isset($key)){
            return (double)$_REQUEST[$key];
        }
        return $defaultValue;
    }

    public function _post($post, $defaultValue = null){
        return $this->prepareValue($_POST, $post, $defaultValue);
    }

    public function _get($get, $defaultValue = null){
        return $this->prepareValue($_GET, $get, $defaultValue);
    }

    public function _request($request, $defaultValue = null){
        return $this->prepareValue($_REQUEST, $request, $defaultValue);
    }
}