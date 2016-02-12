<?php
$name = $name ?: 'main';
$renderAs = $renderAs ?: 'list';
$menu = $menu ?: [];

if (is_string($name) && empty($menu)) {
    $menu = $this->Menu->getMenu($name);
}

$renderFormats = [
    'list' => [
        'menuStart' => '<ul>',
        'menuEnd' => '</ul>',
        'itemStart' => '<li>',
        'itemEnd' => '</li>',
        'item' => '<a href="%url%">%label%</a>',
    ],
    'dropdown' => [
        'menuStart' => '<select>',
        'menuEnd' => '</select>',
        'itemStart' => '<option>',
        'itemEnd' => '</option>',
        'item' => '%label%',
    ],
    'none' => [
        'menuStart' => '',
        'menuEnd' => '',
        'itemStart' => '',
        'itemEnd' => '',
        'item' => '',
    ],
];

if (is_string($renderAs) && !empty($renderFormats[$renderAs])) {
    $format = $renderFormats[$renderAs];
}
elseif (is_array($renderAs)) {
    $defaults = [
        'menuStart' => '<ul>',
        'menuEnd' => '</ul>',
        'itemStart' => '<li>',
        'itemEnd' => '</li>',
        'item' => '%label%',
    ];
    $format = array_merge($defaults, $renderAs);
}
else {
    throw new InvalidArgumentException("Ooops!");
}
echo $format['menuStart'];
foreach ($menu as $item) {
    echo $format['itemStart'];
    $itemContent = $format['item'];
    foreach ($item as $key => $value) {
        $itemContent = preg_replace('/%' . $key . '%/', $value, $itemContent);
    }
    echo $itemContent;
    echo $format['itemEnd'];
}
echo $format['menuEnd'];
?>