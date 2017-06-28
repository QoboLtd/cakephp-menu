<?php

namespace Menu\MenuBuilder;

/**
 *  MenuItem class
 *
 */
class MenuItem extends BaseMenuItem
{
    /**
     * @var $propertiesList
     */
    protected $propertiesList = ['label', 'icon', 'target', 'desc', 'url', 'children', 'noLable', 'dataType', 'confirmMsg'];
}
