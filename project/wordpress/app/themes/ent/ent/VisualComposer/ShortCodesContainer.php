<?php
namespace Ent\VisualComposer;

use Ent\VisualComposer\Traits\RenderComponent;

class ShortCodesContainer extends \WPBakeryShortCodesContainer {
    use RenderComponent;

    public static $type = 'container';
    public static $children = [''];
    public static $is_layout = true;
}
