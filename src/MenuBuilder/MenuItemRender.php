<?php

namespace Menu\MenuBuilder;

use Cake\View\Helper\UrlHelper;

class MenuItemRender extends BaseMenuItemRenderClass
{
    /**
     *  render method
     *
     * @param Menu\MenuBuilder\MenuItem $menuItem menu item object
     * @param array $format list of parameters to format menu structure
     * @return string
     */
    public function render($menuItem, $format)
    {
        $children = $menuItem->getChildren();

        $html = $format['itemStart'];
        $item = !empty($children) ? $format['itemWithChildren'] : $format['item'];
        foreach ($menuItem->getProperties() as $attr) {
            if (false === strpos($item, $attr)) {
                continue;
            }
            $val = $menuItem->get($attr);
            if ($attr == 'url') {
                $val = is_array($val) ? UrlHelper::build($val) : $val;
            }
            $item = str_replace('%' . $attr . '%', $val, $item);
        }

        $html .= $item;

        if (!empty($children)) {
            $html .= $format['childMenuStart'];
            foreach ($children as $childItem) {
                $html .= $this->render($childItem, $format);
            }
            $html .= $format['childMenuEnd'];
        }
        $format['itemEnd'];

        return $html;
    }
}
