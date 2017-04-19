<?php
use Cake\Event\Event;

$renderAs = isset($renderAs) ? $renderAs : RENDER_AS_LIST;

if ((bool)$menu->default) {
    $event = new Event('Menu.Menu.getMenu', $this, [
        'name' => $menu->name,
        'user' => $user,
        'fullBaseUrl' => $fullBaseUrl
    ]);
    $this->eventManager()->dispatch($event);
    $menu = $event->result;
}

$itemDefaults = [
    'url' => '#',
    'label' => 'Undefined',
    'icon' => 'circle-o'
];

$event = new Event('Menu.Menu.beforeRender', $this, ['menu' => $menu, 'user' => $user]);
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

echo $this->Html->script('Menu.menu', ['block' => 'scriptBottom']);
