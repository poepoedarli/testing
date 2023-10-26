<?php

namespace App\Builder;

use Collective\Html\FormFacade as Form;

class FormControls
{
    static function dt_control($data = [], $control_title = '', $control_class = '', $icon_class = '', $icon_text = '')
    {
        $data_attributes = "";
        foreach ($data as $key => $value) {
            $data_attributes .= "data-$key='$value'";
        }
        return "<a $data_attributes title='$control_title' class='$control_class'><i class='fa fa-xs $icon_class'>$icon_text</i></a>";
    }

    static function anchor_control($link_href = '', $link_title = '', $link_class = '', $icon_class = '', $icon_text = '')
    {
        return "<a href='$link_href' title='$link_title' class='$link_class'><i class='fa fa-xs $icon_class'>$icon_text</i></a>";
    }

    static function form_control_group($class = '', $controls = [])
    {
        $form_control = '';
        foreach ($controls as $key => $control) {
            switch ($key) {
                case 'text':
                    $form_control .= Form::text($control['name'], $control['value'], $control['properties']);
                    break;
                case 'label':
                    $form_control .= Form::label($control['for'], $control['text'], $control['properties']);
                    break;
                case 'radio':
                    $form_control .= Form::radio($control['name'], $control['value'], $control['checked'], $control['properties']);
                    break;
                case 'checkbox':
                    $form_control .= Form::checkbox($control['name'], $control['value'], $control['checked'], $control['properties']);
                    break;
                case 'number':
                    $form_control .= Form::number($control['name'], $control['value'], $control['properties']);
                    break;
                case 'password':
                    $form_control .= Form::password($control['name'], $control['properties']);
                    break;
                case 'email':
                    $form_control .= Form::email($control['name'], $control['value'], $control['properties']);
                    break;
                case 'select':
                    $form_control .= Form::select($control['name'], $control['values'], $control['value'], $control['properties']);
                    break;
                case 'date':
                    $form_control .= Form::date($control['name'], $control['value'], $control['properties']);
                    break;
                case 'textarea':
                    $form_control .= Form::textarea($control['name'], $control['value'], $control['properties']);
                    break;
                default:
                    $form_control .= $controls[$key];
                    break;
            }
        }
        return "<div class='$class'>$form_control</div>";
    }

    static function checkbox_control($name, $value, $checked, $properties, $label = null, $switch = false)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-check-label']
            ];
        }

        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-check-input' : 'form-check-input';
        $controls['checkbox'] = [
            'name' => $name,
            'value' => $value,
            'checked' => $checked,
            'properties' => $properties
        ];
        $switch = $switch ? 'form-switch' : '';
        return self::form_control_group(
            "form-check $switch",
            $controls
        );
    }

    static function radio_control($name, $value, $checked, $properties, $label = null, $parent_class = '')
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-check-label']
            ];
        }

        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-check-input' : 'form-check-input';
        $controls['radio'] = [
            'name' => $name,
            'value' => $value,
            'checked' => $checked,
            'properties' => $properties
        ];

        return self::form_control_group(
            "form-check $parent_class",
            $controls
        );
    }

    static function text_control($name, $value, $properties = [], $label = null)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $controls['text'] = [
            'name' => $name,
            'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            'form-group',
            $controls
        );
    }

    static function email_control($name, $value, $properties = [], $label = null)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $controls['email'] = [
            'name' => $name,
            'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            'form-group',
            $controls
        );
    }

    static function number_control($name, $value, $properties = [], $label = null)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $controls['number'] = [
            'name' => $name,
            'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            'form-group',
            $controls
        );
    }

    static function password_control($name, $value, $properties = [], $label = null)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $controls['password'] = [
            'name' => $name,
            // 'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            'form-group',
            $controls
        );
    }

    static function select_control($name, $values, $value, $properties = [], $label = null)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-select' : 'form-select';
        $controls['select'] = [
            'name' => $name,
            'values' => $values,
            'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            'form-group',
            $controls
        );
    }

    static function grid_col($size, $control, $parent_class = '')
    {
        return "<div class='col-$size mt-2 $parent_class'>$control</div>";
    }

    static function grid_row($controls, $class = "")
    {
        $row = "<div class='row $class'>";
        foreach ($controls as $control) {
            $row .= $control;
        }
        $row .= "</div>";
        return $row;
    }

    static function date_control($name, $value, $properties = [], $label = null)
    {
        $controls = [];
        if (!is_null($label)) {
            $a = $label['properties'] ?? [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $controls['date'] = [
            'name' => $name,
            'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            'form-group',
            $controls
        );
    }

    static function textarea_control($name, $value, $properties = [], $label = null, $parent_class = '')
    {
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $controls['textarea'] = [
            'name' => $name,
            'value' => $value,
            'properties' => $properties
        ];

        return self::form_control_group(
            "form-group  $parent_class",
            $controls
        );
    }

    static function tabs_control($id, $tabs, $active_index = 0, $nav_class = '', $tab_content_class)
    { // tabs = [tab_control]

        $tabs_nav = "<ul class='nav nav-tabs $nav_class' id='$id' role='tablist'>";
        $tab_content = "<div class='block-content tab-content $tab_content_class' id='$id-content'>";
        foreach ($tabs as $key => $tab) {
            $active = $key == $active_index ? 'active' : '';

            $nav = "<li class='nav-item' role='presentation'>";
            $nav .= "<a class='nav-link $active' data-bs-toggle='tab' role='tab' href='#" . $tab['id'] . "'>" . $tab['title'] . "</a>";
            $nav .= "</li>";
            $tabs_nav .= $nav;
            $tab_content .= "<div class='tab-pane fade container show $active $tab_content_class' id='" . $tab['id'] . "' role='tabpanel'>" . $tab['element'] . "</div>";
        }
        $tab_content .= "</div>";
        $tabs_nav .= "</ul>";
        return $tabs_nav . $tab_content;
    }

    static function tab_control($id, $title, $element)
    {
        return ['id' => $id, 'title' => $title, 'element' => $element];
    }

    static function carousel_control($images = [], $dir, $id = 'carouselExampleIndicators', $active_index = 0, $max_height = 480)
    {
        $images = array_map(function ($image) use ($dir) {
            $image['src'] = asset('media/images/' . $dir . '/' . $image['filename']);
            $image['class'] = 'w-100';//ratio ratio-21x9';
            return $image;
        }, $images);

        $max_height = "$max_height" . "px";
        $carousel = "<div id='$id' class='carousel slide'>";

        $carousel_indicators = "<div class='carousel-indicators'>";
        $carousel_inner = "<div class='carousel-inner'>";
        foreach ($images as $key => $image) {
            // image['name'], image['filename']
            $active = $key == $active_index ? 'active' : '';
            $carousel_indicators .= "<button type='button' data-bs-target='#$id' data-bs-slide-to='$key' class='$active' aria-current='true' aria-label='" . $image['name'] . "'></button>";
            $carousel_inner .= "<div class='carousel-item $active' style='max-height:$max_height;'>
                <img src='" . $image["src"] . "' class='d-block " . $image['class'] . "' alt='" . $image['name'] . "'>
            </div>";
        }
        $carousel_indicators .= "</div>";
        $carousel_inner .= "</div>";
        $carousel_controls = "
            <button class='carousel-control-prev' type='button' data-bs-target='#$id'
                data-bs-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Previous</span>
            </button>
            <button class='carousel-control-next' type='button' data-bs-target='#$id'
                data-bs-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Next</span>
            </button>
        ";


        $carousel = $carousel . $carousel_indicators . $carousel_inner . $carousel_controls . "</div>";

        // Log::info([
        //     '$carousel' => $carousel,
        // ]);
        return $carousel;
    }

    static function ckeditor_control($name, $value, $properties = [], $label = null, $parent_class = '')
    {
        // include ckeditor plugin lib
        // include in page load, Dashmix.helpersOnLoad(['js-ckeditor5']);
        //$properties['id'] = 'js-ckeditor5'; // keyword for Dashmix helper 
        return self::textarea_control(
            $name,
            $value,
            $properties,
            $label,
            $parent_class
        );
    }

    static function file_upload_control($name, $properties, $label = null)
    {
        // Set form 'files' => true OR enctype="multipart/form-data", if multiple, name should consist of [], not auto included here
        $controls = [];
        if (!is_null($label)) {
            $a = isset($label['properties']) ? $label['properties'] : [];
            $controls['label'] = [
                'for' => $properties['id'],
                'text' => $label['text'],
                'properties' => [...$a, 'class' => 'form-label']
            ];
        }
        $multiple = isset($properties['multiple']) ? 'multiple' : '';
        $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
        $properties_str = '';

        foreach ($properties as $key => $value) {
            $properties_str .= " $key" . "='$value'";
        }

        $controls['upload_file'] = "<input name='$name' $properties_str type='file' $multiple />";

        return self::form_control_group(
            'form-group',
            $controls
        );

    }

    // static function upload_image_control($name, $properties, $label = null)
    // {
    //     // Set form 'files' => true OR enctype="multipart/form-data", if multiple, name should consist of [], not auto included here
    //     $controls = [];
    //     if (!is_null($label)) {
    //         $a = isset($label['properties']) ? $label['properties'] : [];
    //         $controls['label'] = [
    //             'for' => $properties['id'],
    //             'text' => $label['text'],
    //             'properties' => [...$a, 'class' => 'form-label']
    //         ];
    //     }
    //     $multiple = isset($properties['multiple']) ? 'multiple' : '';
    //     $properties['class'] = isset($properties['class']) ? $properties['class'] . ' form-control' : 'form-control';
    //     $properties_str =  ''; 

    //     foreach ($properties as $key => $value) {
    //         $properties_str .= " $key"."='$value'";
    //     }

    //     // $controls['upload_image'] = '<input class="' . $properties['class'] . '" id="' . $properties['id'] . '" name="'  . $name . '" type="file" accept="image/*" title="' . $properties['title'] . '" ' . $multiple . ' >';
    //     $controls['upload_image'] = "<input name='$name' $properties_str type='file' accept='image/*' $multiple />";

    //     return self::form_control_group(
    //         'form-group',
    //         $controls
    //     );
    // }
}