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

use Cake\View\View;
use \ReflectionClass;
use \ReflectionException;

/**
 *  BaseMenuRenderClass class
 *
 *  Base class for menu renders
 */
class BaseMenuRenderClass implements MenuRenderInterface
{
    const RENDER_CLASS_NAME_POSTFIX = 'Render';
    const DEFAULT_RENDER_METHOD = 'buildLink';

    /**
     * @var $format array with formats
     */
    protected $format = [];

    /**
     * @var Menu $menu
     */
    protected $menu = null;

    /**
     * @var View $viewEntity
     */
    protected $viewEntity = null;

    /**
     * @var $noLabel
     */
    protected $noLabel = false;

    /**
     *  __construct method
     *
     * @param \Menu\MenuBuilder\Menu $menu menu to render
     * @param \Cake\View\View $viewEntity view entity
     * @return void
     */
    public function __construct(Menu $menu, View $viewEntity)
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

        /**
         * @var MenuItemInterface $menuItem
         */
        foreach ($this->menu->getMenuItems() as $menuItem) {
            if ($menuItem->isEnabled()) {
                $html .= $this->renderMenuItem($menuItem);
            }
        }
        $html .= $this->format['menuEnd'];

        return $html;
    }

    /**
     *  _renderMenuItem method
     *
     * @param \Menu\MenuBuilder\MenuItemInterface $item menu item definition
     * @return string rendered menu item as HTML
     */
    protected function renderMenuItem(MenuItemInterface $item)
    {
        $children = $item->getMenuItems();

        $html = $this->format['itemStart'];

        $html .= $this->buildItem($item, !empty($children) && !empty($this->format['itemWithChildrenPostfix']) ? $this->format['itemWithChildrenPostfix'] : '');

        if (!empty($children)) {
            $enabledChildren = array_filter($children, function (MenuItemInterface $child) {
                return $child->isEnabled();
            });

            $html .= $this->format['childMenuStart'];
            /** @var MenuItemInterface $childItem */
            foreach ($enabledChildren as $childItem) {
                $html .= !empty($this->format['childItemStart']) ? $this->format['childItemStart'] : '';
                $html .= $this->renderMenuItem($childItem);
                $html .= !empty($this->format['childItemEnd']) ? $this->format['childItemEnd'] : '';
            }
            $html .= $this->format['childMenuEnd'];
        }

        $html .= $this->format['itemEnd'];

        return $html;
    }

    /**
     *  buildItem method
     *
     * @param MenuItemInterface $item menu item entity
     * @param string $extLabel additional label elements
     * @return string generated HTML element
     */
    protected function buildItem(MenuItemInterface $item, $extLabel)
    {
        try {
            $shortClass = (new ReflectionClass($item))->getShortName();
            $method = str_replace(BaseMenuItem::MENU_ITEM_CLASS_PREFIX, 'build', $shortClass);
            if (!method_exists($this, $method)) {
                $method = self::DEFAULT_RENDER_METHOD;
            }
        } catch (ReflectionException $e) {
            $method = self::DEFAULT_RENDER_METHOD;
        }

        $result = call_user_func([$this, $method], $item, $extLabel, $item->getAttributes());
        $result .= !empty($item->getRawHtml()) ? $item->getRawHtml() : '';

        return $result;
    }

    /**
     *  buildLink method
     *
     * @param MenuItemInterface $item menu item entity
     * @param string $extLabel additional label elements
     * @param array $params HTML attributes
     * @return string generated HTML element
     */
    protected function buildLink(MenuItemInterface $item, $extLabel = '', $params = [])
    {
        $params['title'] = __($item->getLabel());
        $params['escape'] = false;
        $params['target'] = $item->getTarget();

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
     *  buildLinkButton method
     *
     * @param MenuItemLinkButton $item menu item entity
     * @param string $extLabel additional label elements
     * @param array $params HTML attributes
     * @return string generated HTML element
     */
    protected function buildLinkButton(MenuItemLinkButton $item, $extLabel, $params = [])
    {
        if (empty($params['class'])) {
            $params['class'] = 'btn btn-default';
        }

        if (!empty($item->getDataType())) {
            $params['data-type'] = $item->getDataType();
        }

        if (!empty($item->getConfirmMsg())) {
            $params['data-confirm-msg'] = $item->getConfirmMsg();
        }

        return $this->buildLink($item, $extLabel, $params);
    }

    /**
     * buildLinkButtonModal method
     *
     * @param MenuItemLinkModal $item menu item entity
     * @param string $extLabel additional label elements
     * @param array $params HTML attributes
     * @return string generated HTML element
     */
    protected function buildLinkModal(MenuItemLinkModal $item, $extLabel, $params = [])
    {
        $item->setUrl('#');

        $params['data-toggle'] = 'modal';
        $params['data-target'] = '#' . $item->getModalTarget();

        return $this->buildLink($item, $extLabel, $params);
    }

    /**
     * buildLinkButtonModal method
     *
     * @param MenuItemLinkButtonModal $item menu item entity
     * @param string $extLabel additional label elements
     * @param array $params HTML attributes
     * @return string generated HTML element
     */
    protected function buildLinkButtonModal(MenuItemLinkButtonModal $item, $extLabel, $params = [])
    {
        $item->setUrl('#');

        if (empty($params['class'])) {
            $params['class'] = 'btn btn-default';
        }

        return $this->buildLinkModal($item, $extLabel, $params);
    }

    /**
     *  buildPostlink method
     *
     * @param MenuItemPostlink $item menu item entity
     * @param string $postFix additional label elements
     * @param array $params HTML attributes
     * @return string generated HTML element
     */
    protected function buildPostlink(MenuItemPostlink $item, $postFix, $params = [])
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
     *  buildPostlinkButton method
     *
     * @param MenuItemPostlinkButton $item menu item entity
     * @param string $postFix additional label elements
     * @param array $params HTML attributes
     * @return string generated HTML element
     */
    protected function buildPostlinkButton(MenuItemPostlinkButton $item, $postFix, $params = [])
    {
        if (empty($params['class'])) {
            $params['class'] = 'btn btn-default';
        }

        return $this->buildPostlink($item, $postFix, $params);
    }

    /**
     *  buildButton method
     *
     * @param MenuItemButton $item menu item entity
     * @param string $postFix additional label elements
     * @return string generated HTML element
     */
    protected function buildButton(MenuItemButton $item, $postFix, $params = [])
    {
        $params['type'] = 'button';

        if (empty($params['class'])) {
            $params['class'] = 'btn btn-default';
        }

        if (!empty($item->getExtraAttribute())) {
            $params['class'] = $item->getExtraAttribute();
        }

        if (!empty($item->getMenuItems())) {
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

        return $this->viewEntity->Html->tag('button', $label, $params);
    }

    /**
     *  buildSeparator method
     *
     * @param MenuItemSeparator $item menu item entity
     * @param string $postFix additional label elements
     * @return string generated HTML element
     */
    protected function buildSeparator(MenuItemSeparator $item, $postFix)
    {
        $result = '<hr class="separator" />';

        return $result;
    }
}
