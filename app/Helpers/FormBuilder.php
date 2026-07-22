<?php

namespace App\Helpers;

class FormBuilder
{
    public static function input($name, $label, $type = 'text', $value = '', $options = [])
    {
        $id = $options['id'] ?? $name;
        $class = $options['class'] ?? '';
        $required = isset($options['required']) ? 'required' : '';
        $placeholder = $options['placeholder'] ?? '';

        return "
            <div class='mb-3'>
                <label for='{$id}' class='form-label'>{$label}</label>
                <input type='{$type}' name='{$name}' id='{$id}' value='{$value}' 
                       class='form-control {$class}' {$required} placeholder='{$placeholder}'>
                <div class='invalid-feedback'></div>
            </div>
        ";
    }

    public static function select($name, $label, $data, $selected = '', $options = [])
    {
        $id = $options['id'] ?? $name;
        $class = $options['class'] ?? 'select2';
        $required = isset($options['required']) ? 'required' : '';

        $html = "<div class='mb-3'>
                    <label for='{$id}' class='form-label'>{$label}</label>
                    <select name='{$name}' id='{$id}' class='form-select {$class}' {$required}>
                        <option value=''>Select Option</option>";
        
        foreach ($data as $val => $text) {
            $sel = ($val == $selected) ? 'selected' : '';
            $html .= "<option value='{$val}' {$sel}>{$text}</option>";
        }

        $html .= "</select></div>";
        return $html;
    }

    public static function textarea($name, $label, $value = '', $options = [])
    {
        $id = $options['id'] ?? $name;
        $rows = $options['rows'] ?? 3;
        return "
            <div class='mb-3'>
                <label for='{$id}' class='form-label'>{$label}</label>
                <textarea name='{$name}' id='{$id}' class='form-control' rows='{$rows}'>{$value}</textarea>
            </div>
        ";
    }
}
