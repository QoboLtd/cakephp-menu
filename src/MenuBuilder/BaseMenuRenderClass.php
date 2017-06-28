<?php

namespace Menu\MenuBuilder;

use Cake\View\Helper\UrlHelper;
use Menu\MenuBuilder\Menu;

/**
 *  BaseMenuRenderClass class
 *
 *  Base class for menu renders
 */
class BaseMenuRenderClass
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
     * @param View $view view entity
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
     * @return string rendered menu as HTML
     */
    public function render()
    {
        $html = $this->format['menuStart'];
        $html .= !empty($this->menu->title()) ? $this->menu->title() : '';

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
    protected function _renderMenuItem(MenuItem $item)
    {
        $children = $item->getChildren();

        $html = $this->format['itemStart'];
        
        $html .= $this->_buildItem($item, !empty($children) && !empty($this->format['itemWithChildrenPostfix']) ? $this->format['itemWithChildrenPostfix'] : '');                                               

        if (!empty($children)) {
            $html .= $this->format['childMenuStart'];
            foreach ($children as $childItem) {
                $html .= $this->_renderMenuItem($childItem);
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
        switch ($item->get('type')) {
            case 'postlink':
                $result = $this->_buildPostlink($item, $extLabel);
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
            'title' => __($item->get('label')), 
            'escape' => false,
        ];

        if (!empty($item->get('class'))) {
            $params['class'] = $item->get('class');
        }    
        if (!empty($item->get('dataType'))) {
            $params['data-type'] = $item->get('dataType');
        }    
        if (!empty($item->get('confirmMsg'))) {
            $params['data-confirm-msg'] = $item->get('confirmMsg');
        }    
        $label = '<i class="fa fa-' . $item->get('icon') . '"></i> ' . ($item->get('noLabel') ? '' : __($item->get('label'))) . $extLabel;
        $result = $this->viewEntity->Html->link($label, $item->get('url'), $params); 
        return $result;
    }
    
    /**
     *  _buildPostlink method
     *
     * @param Menu\MenuBuilder\Menu $item menu item entity
     * @param string $extLabel additional label elements
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
}
