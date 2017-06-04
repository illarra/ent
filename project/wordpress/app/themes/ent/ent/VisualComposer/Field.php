<?php
namespace Ent\VisualComposer;

class Field {
    protected $parameters = [];
    protected $type_map = [
        'checkbox'  => 'checkbox',
        'color'     => 'colorpicker',
        'image'     => 'attach_image',
        'rich_text' => 'textarea_html',
        'select'    => 'dropdown',
        'text'      => 'textfield',
        'textarea'  => 'textarea',
        'link'      => 'vc_link',
    ];

    public static function make($type, $name, $label) {
        return (new Field())
            ->set_type($type)
            ->set_name($name)
            ->set_label($label);
    }

    public function get_parameters() {
        return $this->parameters;
    }

    public function set_group($group) {
        $this->parameters['group'] = $group;

        return $this;
    }

    public function set_label($label) {
        $this->parameters['heading'] = $label;

        return $this;
    }

    public function set_name($name) {
        $this->parameters['param_name'] = $name;

        return $this;
    }

    public function set_options($options) {
        $this->parameters['value'] = $options;

        return $this;
    }

    public function set_type($type) {
        if (array_key_exists($type, $this->type_map)) {
            $this->parameters['type'] = $this->type_map[$type];
        } else {
            $this->parameters['type'] = $type;
        }

        return $this;
    }
}
