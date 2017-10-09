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

use Cake\Event\Event;
use Menu\Event\EventName;

$name = isset($name) ? $name : 'main';

if (!is_string($name)) {
    throw new InvalidArgumentException('Menu [name] must be a string');
}

$user = isset($user) ? $user : [];

if (empty($user) || isset($_SESSION['Auth']['User'])) {
    $user = $_SESSION['Auth']['User'];
};

$renderAs = isset($renderAs) ? $renderAs : RENDER_AS_LIST;
$menu = isset($menu) ? $menu : [];

if (empty($menu)) {
    $event = new Event((string)EventName::GET_MENU(), $this, [
        'name' => $name,
        'user' => $user,
        'fullBaseUrl' => isset($fullBaseUrl) ? (bool)$fullBaseUrl : false
    ]);
    $this->eventManager()->dispatch($event);
    $menu = $event->result;
}

$renderFormats = [
    RENDER_AS_PROVIDED => [
        'menuStart' => '',
        'menuEnd' => '',
        'itemStart' => '',
        'itemEnd' => '',
        'item' => '%label%',
    ],
    RENDER_AS_LIST => [
        'menuStart' => '<ul>',
        'menuEnd' => '</ul>',
        'itemStart' => '<li>',
        'itemEnd' => '</li>',
        'item' => '<a href="%url%"><i class="fa fa-%icon%"></i> %label%</a>',
    ],
    RENDER_AS_DROPDOWN => [
        'menuStart' => '<select>',
        'menuEnd' => '</select>',
        'itemStart' => '<option>',
        'itemEnd' => '</option>',
        'item' => '<i class="fa fa-%icon%"></i> %label%',
    ],
    RENDER_AS_NONE => [
        'menuStart' => '',
        'menuEnd' => '',
        'itemStart' => '',
        'itemEnd' => '',
        'item' => '',
    ]
];

if (is_string($renderAs) && !empty($renderFormats[$renderAs])) {
    $format = $renderFormats[$renderAs];
} elseif (is_array($renderAs)) {
    $defaults = [
        'menuStart' => '<ul>',
        'menuEnd' => '</ul>',
        'childMenuStart' => '<ul>',
        'childMenuEnd' => '</ul>',
        'itemStart' => '<li>',
        'itemEnd' => '</li>',
        'item' => '%label%',
    ];
    $format = array_merge($defaults, $renderAs);
} else {
    throw new InvalidArgumentException("Ooops!");
}

$itemDefaults = [
    'url' => '#',
    'label' => 'Undefined',
    'icon' => 'circle-o'
];

$event = new Event((string)EventName::MENU_BEFORE_RENDER(), $this, ['menu' => $menu, 'user' => $user]);
$this->eventManager()->dispatch($event);
if (!empty($event->result)) {
    $menu = $event->result;
}

echo $format['menuStart'];
if (!empty($format['header'])) {
    echo $format['header'];
}
foreach ($menu as $item) {
    // skip empty menu item
    if (empty($item)) {
        continue;
    }
    echo $format['itemStart'];
    $itemContent = $format['item'];
    if (!empty($item['children'])) {
        $itemContent = $format['itemWithChildren'];
    }
    $item = array_merge($itemDefaults, $item);
    if (is_array($item['url'])) {
        $item['url'] = $this->Url->build($item['url']);
    }
    foreach ($item as $key => $value) {
        if (false !== strpos($itemContent, $key)) {
            $itemContent = preg_replace('/%' . $key . '%/', $value, $itemContent);
        }
    }
    echo $itemContent;
    if (!empty($item['children'])) {
        echo $format['childMenuStart'];
        foreach ($item['children'] as $child) {
            if (empty($child)) {
                continue;
            }
            echo $format['itemStart'];
            $childItemContent = $format['item'];
            $child = array_merge($itemDefaults, $child);
            if (is_array($child['url'])) {
                $child['url'] = $this->Url->build($child['url']);
            }
            foreach ($child as $key => $value) {
                if (false !== strpos($childItemContent, $key)) {
                    $childItemContent = str_replace('%' . $key . '%', $value, $childItemContent);
                }
            }
            echo $childItemContent;
            echo $format['itemEnd'];
        }
    }
    if (!empty($item['children'])) {
        echo $format['childMenuEnd'];
    }
    echo $format['itemEnd'];
}
echo $format['menuEnd'];
