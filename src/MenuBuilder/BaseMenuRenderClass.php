<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
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
    const RENDER_CLASS_NAME_POSTFIX = 'Render';

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
     * @var $noLabel
     */
    protected $noLabel = false;

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
     * setFormat method
     *
     * @param array $format containing all required keys
     * @return void
     */
    public function setFormat(array $format = [])
    {
        $this->format = $format;
    }

    /**
     * getFormat method
     *
     * @return array $format containing menu settings
     */
    public function getFormat()
    {
        return $this->format;
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
            case 'Menu\MenuBuilder\MenuItemLinkButton':
                $result = $this->_buildLinkButton($item, $extLabel);
                break;
            case 'Menu\MenuBuilder\MenuItemPostlinkButton':
                $result = $this->_buildPostlinkButton($item, $extLabel);
                break;
            case 'Menu\MenuBuilder\MenuItemLinkButtonModal':
                $result = $this->_buildLinkButtonModal($item, $extLabel);
                break;
            case 'Menu\MenuBuilder\MenuItemLinkModal':
                $result = $this->_buildLinkModal($item, $extLabel);
                break;
            default:
                $result = $this->_buildLink($item, $extLabel);
        }

        $result .= !empty($item->getRawHtml()) ? $item->getRawHtml() : '';

        return $result;
    }

    /**
     *  _buildLink method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
     * @param array $params additional params
     * @return string generated HTML element
     */
    protected function _buildLink($item, $extLabel = '', $params = [])
    {
        $params['title'] = __($item->getLabel());
        $params['escape'] = false;

        $label = '<i class="menu-icon fa fa-' . $item->getIcon() . '"></i> ';
        $label .= !empty($this->format['itemHeaderStart']) ? $this->format['itemHeaderStart'] : '';
        $label .= !empty($this->format['itemWrapperStart']) ? $this->format['itemWrapperStart'] : '';
        $label .= $this->noLabel ? '' : __($item->getLabel());
        $label .= !empty($this->format['itemWrapperEnd']) ? $this->format['itemWrapperEnd'] : '';
        $label .= $extLabel;
        $label .= !empty($item->getDescription()) ? $this->format['itemDescrStart'] . $item->getDescription() . $this->format['itemDescrEnd'] : '';
        $label .= !empty($this->format['itemHeaderEnd']) ? $this->format['itemHeaderEnd'] : '';
        $result = $this->viewEntity->Html->link($label, $item->getUrl(), $params);

        return $result;
    }

    /**
     *  _buildLinkButton method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
     * @return string generated HTML element
     */
    protected function _buildLinkButton($item, $extLabel)
    {
        $params = ['class' => 'btn btn-default'];

        if (!empty($item->getDataType())) {
            $params['data-type'] = $item->getDataType();
        }

        if (!empty($item->getConfirmMsg())) {
            $params['data-confirm-msg'] = $item->getConfirmMsg();
        }

        return $this->_buildLink($item, $extLabel, $params);
    }

    /**
     * _buildLinkButtonModal method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
     * @param array $params additional params
     * @return string generated HTML element
     */
    protected function _buildLinkModal($item, $extLabel, $params = [])
    {
        $params['data-toggle'] = 'modal';
        $params['data-target'] = '#' . $item->getModalTarget();

        return $this->_buildLink($item, $extLabel, $params);
    }

    /**
     * _buildLinkButtonModal method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
     * @return string generated HTML element
     */
    protected function _buildLinkButtonModal($item, $extLabel)
    {
        $params = [
            'class' => 'btn btn-default',
        ];

        return $this->_buildLinkModal($item, $extLabel, $params);
    }

    /**
     *  _buildPostlink method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $postFix additional label elements
     * @param array $params additional params
     * @return string generated HTML element
     */
    protected function _buildPostlink($item, $postFix, $params = [])
    {
        $params['title'] = $item->getLabel();
        $params['escape'] = false;

        if (!empty($item->getConfirmMsg())) {
            $params['confirm'] = $item->getConfirmMsg();
        }

        $label = '<i class="fa fa-' . $item->getIcon() . '"></i> ' . ($this->noLabel ? '' : __($item->getLabel())) . $postFix;
        $result = $this->viewEntity->Form->postLink($label, $item->getUrl(), $params);

        return $result;
    }

    /**
     *  _buildPostlinkButton method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $postFix additional label elements
     * @return string generated HTML element
     */
    protected function _buildPostlinkButton($item, $postFix)
    {
        $params['class'] = 'btn btn-default';

        return $this->_buildPostlink($item, $postFix, $params);
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

        if (!empty($item->getExtraAttribute())) {
            $params['class'] = $item->getExtraAttribute();
        }

        if (!empty($item->getChildren())) {
            $params['data-toggle'] = 'dropdown';
            $params['aria-haspopup'] = 'true';
            $params['aria-expanded'] = 'false';
        }

        $label = $item->getLabel();
        if (!empty($item->getIcon())) {
            $label = '<i class="fa fa-' . $item->getIcon() . '"></i> ' . $label;
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
