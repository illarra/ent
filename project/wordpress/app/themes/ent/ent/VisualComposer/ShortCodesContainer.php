<?php
namespace Ent\VisualComposer;

use Ent\VisualComposer\Traits\RenderComponent;

class ShortCodesContainer extends \WPBakeryShortCode {
    use RenderComponent;

    public static $type = 'container';
    public static $children = [''];
    public static $is_layout = true;
}
