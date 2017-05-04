<?php
use Cake\Event\Event;

$itemDefaults = [
    'url' => '#',
    'label' => 'Undefined',
    'icon' => 'circle-o',
    'target' => '_self',
    'desc' => ''
];

$renderMenuItem = function ($item) use ($format, $itemDefaults, &$renderMenuItem) {
    // skip empty menu item
    if (empty($item)) {
        return;
    }

    echo $format['itemStart'];

    $html = !empty($item['children']) ? $format['itemWithChildren'] : $format['item'];

    $item = array_merge($itemDefaults, $item);

    // prepare url
    $item['url'] = is_array($item['url']) ? $this->Url->build($item['url']) : $item['url'];

    foreach ($item as $attr => $val) {
        // skip if attribute is not found in the html
        if (false === strpos($html, $attr)) {
            continue;
        }
        $html = str_replace('%' . $attr . '%', $val, $html);
    }

    echo $html;

    // handle children
    if (!empty($item['children'])) {
        echo $format['childMenuStart'];

        foreach ($item['children'] as $child) {
            $renderMenuItem($child);
        }

        echo $format['childMenuEnd'];
    }

    echo $format['itemEnd'];
};

$event = new Event('Menu.Menu.beforeRender', $this, ['menu' => $menuItems, 'user' => $user]);
$this->eventManager()->dispatch($event);
if (!empty($event->result)) {
    $menuItems = $event->result;
}

echo $format['menuStart'];
if (!empty($format['header'])) {
    echo $format['header'];
}

foreach ($menuItems as $item) {
    $renderMenuItem($item, $itemDefaults, $format);
}

echo $format['menuEnd'];
