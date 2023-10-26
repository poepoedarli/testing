<?php

namespace App\Builder;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Log;

class Template
{
    public static function convert_template_to_controls($template_data = null)
    {
        $form_controls = [];
        if(is_null($template_data) || !is_string($template_data) || empty($template_data)){
            return $form_controls;
        }
        $controls = json_decode($template_data, true);
        
        foreach ($controls as $key => $control) {
            $keys = explode("-", $key);
            if (count($keys) == 2) {
                $index = intval($keys[1]);
                switch ($keys[0]) {
                    case 'textbox':
                        $textbox = self::getTextbox($control);
                        $form_controls[$index][] = FormControls::grid_col(
                            12,
                            $textbox
                        );
                        break;
                    case 'checkbox':
                        $checkbox = self::getCheckbox($control);
                        $form_controls[$index][] = FormControls::grid_col(
                            12,
                            $checkbox
                        );
                        break;
                    case 'radiolist':
                        $radiolist = self::getRadiolist($control);
                        $form_controls[$index][] = FormControls::grid_col(
                            12,
                            FormControls::form_control_group(
                                'form-group',
                                [
                                    'label' => ['for' => $control['name'], 'text' => $control['label'], 'properties' => ['class' => 'form-label']],
                                ]
                            )
                        );
                        $form_controls[$index][] = FormControls::grid_col(
                            12,
                            $radiolist
                        );
                        break;
                    case 'select':
                        $select = self::getSelect($control);
                        $form_controls[$index][] = FormControls::grid_col(
                            12,
                            $select
                        );
                        break;
                    case 'fileupload':
                        $fileupload = self::getFileUpload($control);
                        $form_controls[$index][] = FormControls::grid_col(
                            12,
                            $fileupload
                        );
                        break;
                    default:
                        break;
                }
            }
        }
        // ksort($form_controls);
        return $form_controls;
    }

    private static function getTextbox($control)
    {
        $properties = ['id' => ''];
        $multiple = false;
        if (isset($control["properties"])) {
            $properties = array_combine($control["properties"]["attributes"], $control["properties"]["values"]);
            $multiple = array_search('multiple', $control["properties"]["attributes"]) ? true : false;
        }
        return $multiple ? FormControls::textarea_control(
            $control["name"],
            null,
            [...$properties, 'rows' => 2],
            ['text' => $control["label"]]
        )
            :
            FormControls::text_control(
                $control["name"],
                null,
                [...$properties],
                ['text' => $control["label"]]
            );
    }
    private static function getCheckbox($control)
    {
        $properties = ['id' => ''];
        if (isset($control["properties"])) {
            $properties = array_combine($control["properties"]["attributes"], $control["properties"]["values"]);
        }
        return FormControls::checkbox_control(
            $control['name'],
            false,
            false,
            [...$properties],
            ['text' => $control['label']],
            true
        );
    }
    private static function getRadiolist($control)
    {
        $items = [];
        $properties = ['id' => ''];
        $radiolist = '';
        if (isset($control["properties"])) {
            $properties = array_combine($control["properties"]["attributes"], $control["properties"]["values"]);
        }
        if (isset($control["items"])) {
            $items = array_combine($control["items"]["values"], $control["items"]["labels"]);
        }
        foreach ($items as $key => $value) {
            $radiolist .= FormControls::radio_control(
                $control["name"],
                $value,
                false,
                [...$properties, 'id' => "_$key"],
                ['text' => $value],
                "form-check-inline"
            );
        }
        return $radiolist;
    }
    private static function getSelect($control)
    {
        $properties = ['id' => ''];
        $options = [];
        if (isset($control["properties"])) {
            $properties = array_combine($control["properties"]["attributes"], $control["properties"]["values"]);
        }
        if (isset($control['options'])) {
            $options = array_combine($control["options"]["values"], $control["options"]["labels"]);
        }
        return FormControls::select_control(
            $control['name'],
            $options,
            null,
            [...$properties],
            ['text' => $control['label']]
        );
    }
    private static function getFileUpload($control)
    {
        $properties = ['id' => ''];
        $multiple = false;
        if (isset($control["properties"])) {
            $properties = array_combine($control["properties"]["attributes"], $control["properties"]["values"]);
            $multiple = array_search('multiple', $control["properties"]["attributes"]) ? true : false;
        }

        $data_type = $control["data_type"];
        switch ($data_type) {
            case 'image':
                return FormControls::file_upload_control(
                    $multiple ? $control['name'] : $control['name'] . '[]',
                    [...$properties, 'accept' => 'image/*'],
                    ['text' => $control['label']]
                );
            case 'video':
                return FormControls::file_upload_control(
                    $control['name'],
                    [...$properties, 'accept' => 'video/*'],
                    ['text' => $control['label']]
                );
            case 'document':
                return FormControls::file_upload_control(
                    $control['name'],
                    [...$properties, 'accept' => '.csv, .json, .xlsx'],
                    ['text' => $control['label']]
                );
            default:
            case 'any':
                return FormControls::file_upload_control(
                    $control['name'],
                    [...$properties],
                    ['text' => $control['label']]
                );
        }
    }
}