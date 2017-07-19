<?php

namespace Menu\MenuBuilder;

use Cake\View\Helper\UrlHelper;
use Menu\MenuBuilder\Menu;

/**
 *  BaseMenuRenderClass class
 *
 *  Base class for menu renders
 */
class BaseMenuRenderClass implements MenuRenderInterface
{
    /**
     * @var $format array with formats
     */
    protected $format = [];

    /**
     * @var $menu list of menu items
     */
    protected $menu = null;

    /**
     * @var $viewEntity
     */
    protected $viewEntity = null;

    /**
     *  __construct method
     *
     * @param Menu\MenuBuilder\Menu $menu menu to render
     * @param View $viewEntity view entity
     * @return void
     */
    public function __construct($menu, $viewEntity)
    {
        $this->menu = $menu;
        $this->viewEntity = $viewEntity;
    }

    /**
     *  render method
     *
     * @param array $options to generate menu
     * @return string rendered menu as per specified format
     */
    public function render(array $options = [])
    {
        $html = $this->format['menuStart'];
        $html .= !empty($options['title']) ? $options['title'] : '';

        foreach ($this->menu->getMenuItems() as $index => $menuItem) {
            $html .= $this->_renderMenuItem($menuItem);
        }
        $html .= $this->format['menuEnd'];

        return $html;
    }

    /**
     *  _renderMenuItem method
     *
     * @param Menu\MenuBuilder\MenuItem $item menu item definition
     * @return string rendered menu item as HTML
     */
    protected function _renderMenuItem($item)
    {
        $children = $item->getChildren();

        $html = $this->format['itemStart'];

        $html .= $this->_buildItem($item, !empty($children) && !empty($this->format['itemWithChildrenPostfix']) ? $this->format['itemWithChildrenPostfix'] : '');

        if (!empty($children)) {
            $html .= $this->format['childMenuStart'];
            foreach ($children as $childItem) {
                $html .= !empty($this->format['childItemStart']) ? $this->format['childItemStart'] : '';
                $html .= $this->_renderMenuItem($childItem);
                $html .= !empty($this->format['childItemEnd']) ? $this->format['childItemEnd'] : '';
            }
            $html .= $this->format['childMenuEnd'];
        }
        $this->format['itemEnd'];

        return $html;
    }

    /**
     *  _buildItem method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
     * @return string generated HTML element
     */
    protected function _buildItem($item, $extLabel)
    {
        $class = get_class($item);
        // Menu\MenuBuilder\MenuItemLink
        switch ($class) {
            case 'Menu\MenuBuilder\MenuItemPostlink':
                $result = $this->_buildPostlink($item, $extLabel);
                break;
            case 'Menu\MenuBuilder\MenuItemButton':
                $result = $this->_buildButton($item, $extLabel);
                break;
            case 'Menu\MenuBuilder\MenuItemSeparator':
                $result = $this->_buildSeparator($item, $extLabel);
                break;
            default:
                $result = $this->_buildLink($item, $extLabel);
        }

        return $result;
    }

    /**
     *  _buildLink method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
     * @return string generated HTML element
     */
    protected function _buildLink($item, $extLabel = '')
    {
        $params = [
            'title' => __($item->getLabel()),
            'escape' => false,
        ];

        if (!empty($item->getExtraAttribute())) {
            $params['class'] = $item->getExtraAttribute();
        }
        //if (!empty($item->get('dataType'))) {
        //    $params['data-type'] = $item->get('dataType');
        //}
        //if (!empty($item->getConfirmMsg())) {
        //    $params['data-confirm-msg'] = $item->getConfirmMsg();
        //}
        $label = '<i class="menu-icon fa fa-' . $item->getIcon() . '"></i> ';
        $label .= !empty($this->format['itemHeaderStart']) ? $this->format['itemHeaderStart'] : '';
        $label .= !empty($this->format['itemWrapperStart']) ? $this->format['itemWrapperStart'] : '';
        $label .= __($item->getLabel());
        $label .= $extLabel;
        $label .= !empty($this->format['itemWrapperEnd']) ? $this->format['itemWrapperEnd'] : '';
        $label .= !empty($item->getDescription()) ? $this->format['itemDescrStart'] . $item->getDescription() . $this->format['itemDescrEnd'] : '';
        $label .= !empty($this->format['itemHeaderEnd']) ? $this->format['itemHeaderEnd'] : '';
        $result = $this->viewEntity->Html->link($label, $item->getUrl(), $params);

        return $result;
    }

    /**
     *  _buildPostlink method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $postFix additional label elements
     * @return string generated HTML element
     */
    protected function _buildPostlink($item, $postFix)
    {
        $params = [
            'title' => $item->get('label'),
            'escape' => false,
        ];

        if (!empty($item->get('class'))) {
            $params['class'] = $item->get('class');
        }

        if (!empty($item->get('confirmMsg'))) {
            $params['confirm'] = $item->get('confirmMsg');
        }

        $label = '<i class="fa fa-' . $item->get('icon') . '"></i> ' . ($item->get('noLabel') ? '' : __($item->get('label'))) . $postFix;
        $result = $this->viewEntity->Form->postLink($label, $item->get('url'), $params);

        return $result;
    }

    /**
     *  _buildButton method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $postFix additional label elements
     * @return string generated HTML element
     */
    protected function _buildButton($item, $postFix)
    {
        $params = [
            'type' => 'button',
        ];

        if (!empty($item->get('class'))) {
            $params['class'] = $item->get('class');
        }

        if (!empty($item->getChildren())) {
            $params['data-toggle'] = 'dropdown';
            $params['aria-haspopup'] = 'true';
            $params['aria-expanded'] = 'false';
        }

        $label = $item->get('label');
        if (!empty($item->get('icon'))) {
            $label = '<i class="fa fa-' . $item->get('icon') . '"></i> ' . $label;
        }

        if (!empty($this->format['itemLabelPostfix'])) {
            $label .= ' ' . $this->format['itemLabelPostfix'];
        }

        $result = '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $label . '</button>';

        return $result;
    }

    /**
     *  _buildSeparator method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $postFix additional label elements
     * @return string generated HTML element
     */
    protected function _buildSeparator($item, $postFix)
    {
        $result = '<hr class="separator" />';

        return $result;
    }
}
