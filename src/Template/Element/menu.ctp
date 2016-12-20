<?php
use Cake\Event\Event;

$name = isset($name) ? $name : 'main';

if (!is_string($name)) {
    throw new InvalidArgumentException('Menu [name] must be a string');
}

$renderAs = isset($renderAs) ? $renderAs : RENDER_AS_LIST;
$menu = isset($menu) ? $menu : [];
$fullBaseUrl = (isset($fullBaseUrl) && is_bool($fullBaseUrl)) ? $fullBaseUrl : false;

if (is_string($name) && empty($menu)) {
    $menu = $this->Menu->getMenu($name, ['fullBaseUrl' => $fullBaseUrl]);
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
    'icon' => 'cube'
];

$user = isset($user) ? $user : [];

if (empty($user) || isset($_SESSION['Auth']['User'])) {
    $user = $_SESSION['Auth']['User'];
};

$event = new Event('Menu.Menu.beforeRender', $this, ['menu' => $menu, 'user' => $user]);
$this->eventManager()->dispatch($event);
if (!empty($event->result)) {
    $menu = $event->result;
}

echo $format['menuStart'];
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

echo $this->Html->script('Menu.menu', ['block' => 'scriptBottom']);
