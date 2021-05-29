<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function my_form_dropdown($data = '', $options = array(), $selected = array(), $disabled = array(), $hidden= array(), $extra = '')
{
    $defaults = array();

    if ( is_array($data) ) {
        if ( isset($data['selected']) ) {
            $selected = $data['selected'];
            unset($data['selected']); // select tags don't have a selected attribute
        }

        if ( isset($data['options']) ) {
            $options = $data['options'];
            unset($data['options']); // select tags don't use an options attribute
        }

        if ( isset($data['disabled']) ) {
            $disabled = $data['disabled'];
            unset($data['disabled']); // select tags don't use an disabled attribute
        }

        if ( isset($data['hidden']) ) {
            $hidden = $data['hidden'];
            unset($data['hidden']); // select tags don't use an hidden attribute
        }
    } else {
        $defaults = array('name' => $data);
    }

    is_array($options)  OR $options     = array($options);
    is_array($selected) OR $selected    = array($selected);
    is_array($disabled) OR $disabled    = array($disabled);
    is_array($hidden)   OR $hidden      = array($hidden);

    // If no selected state was submitted we will attempt to set it automatically
    if ( empty($selected) ) {
        if ( is_array($data) ) {
            if ( isset($data['name'], $_POST[$data['name']]) ) {
                $selected = array($_POST[$data['name']]);
            }
        } elseif ( isset($_POST[$data]) ) {
            $selected = array($_POST[$data]);
        }
    }

    $extra = _attributes_to_string($extra);

    $multiple = (count($selected) > 1 && stripos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

    $form = '<select '.rtrim(_parse_form_attributes($data, $defaults)).$extra.$multiple.">\n";

    foreach ($options as $key => $val) {
        $key = (string) $key;

        if ( is_array($val) ) {
            $form .= '<option value="'.html_escape($key) . '"'
                . (isset($val['class']) ?       ' class="' . $val['class'] . '"' : '')
                . (isset($val['selected']) ?   ' selected="selected"' : '')
                . (isset($val['disabled']) ?   ' disabled' : '')
                . (isset($val['hidden']) ?   ' hidden' : '')
                . '>'
                . (string) $val['value']
                . "</option>\n";
        } else {
            $form .= '<option value="'.html_escape($key) . '"'
                . (in_array($key, $selected) ?  ' selected="selected"' : '') 
                . (in_array($key, $disabled) ?  ' disabled': '')
                . (in_array($key, $hidden) ?    ' hidden': '')
                . '>'
                . (string) $val
                . "</option>\n";
        }
    }
    return $form."</select>\n";
} 