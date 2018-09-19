# Menu plugin for CakePHP

[![Build Status](https://travis-ci.org/QoboLtd/cakephp-menu.svg?branch=master)](https://travis-ci.org/QoboLtd/cakephp-menu)
[![Latest Stable Version](https://poser.pugx.org/qobo/cakephp-menu/v/stable)](https://packagist.org/packages/qobo/cakephp-menu)
[![Total Downloads](https://poser.pugx.org/qobo/cakephp-menu/downloads)](https://packagist.org/packages/qobo/cakephp-menu)
[![Latest Unstable Version](https://poser.pugx.org/qobo/cakephp-menu/v/unstable)](https://packagist.org/packages/qobo/cakephp-menu)
[![License](https://poser.pugx.org/qobo/cakephp-menu/license)](https://packagist.org/packages/qobo/cakephp-menu)
[![codecov](https://codecov.io/gh/QoboLtd/cakephp-menu/branch/master/graph/badge.svg)](https://codecov.io/gh/QoboLtd/cakephp-menu)

## About

CakePHP 3+ plugin for managing application menus.

This plugin is developed by [Qobo](https://www.qobo.biz) for [Qobrix](https://qobrix.com).  It can be used as standalone CakePHP plugin, or as part of the [project-template-cakephp](https://github.com/QoboLtd/project-template-cakephp) installation.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require qobo/menu
```
## Usage

Basic usage example - in the view

```php
$menu = new Menu();

// Create menu item link
$linkItem = new MenuItemLink();
$linkItem->setUrl('#');
$linkItem->setLabel(__('Edit'));
$linkItem->setIcon('pencil');
$linkItem->setOrder(100);
$menu->addMenuItem($linkItem);

$separatorItem = new MenuItemSeparator();
$menu->addMenuItem($separatorItem);

$postlinkItem = new MenuItemPostlink();
$postlinkItem->setUrl('#');
$postlinkItem->setLabel(__('Delete'));
$postlinkItem->setIcon('trash');
$postlinkItem->setConfirmMsg(__('Are you sure to delete it?'));
$postlinkItem->setOrder(130);

$menu->addMenuItem($postlinkItem);

$params = ['title' => 'Main Menu'];
$render = new MainMenuRenderAdminLte($menu, $this);
echo $render->render($params);

```

## Supported menu items

#### MenuItemLink

#### MenuItemLinkButton

#### MenuItemLinkModal

#### MenuItemPostlink

#### MenuItemPostlinkButton

#### MenuItemButton

#### MenuItemCustom

#### MenuItemSeparator

