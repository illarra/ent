<?php
namespace Ent\VisualComposer;

use Ent\VisualComposer\Traits\RenderComponent;

class ShortCode extends \WPBakeryShortCode {
    use RenderComponent;

    public static $type = 'regular';
    public static $parents = [''];
    public static $is_layout = true;
}
