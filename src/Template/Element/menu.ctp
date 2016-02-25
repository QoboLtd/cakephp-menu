<?php
$allControllers = !isset($allControllers) ? true : (bool)$allControllers;
$name = $name ?: 'main';
$renderAs = $renderAs ?: RENDER_AS_LIST;
$menu = isset($menu) ? $menu : [];

if (is_string($name) && empty($menu)) {
    $menu = $this->Menu->getMenu($name, $allControllers);
}

$renderFormats = [
    RENDER_AS_LIST => [
        'menuStart' => '<ul>',
        'menuEnd' => '</ul>',
        'itemStart' => '<li>',
        'itemEnd' => '</li>',
        'item' => '<a href="%url%">%label%</a>',
    ],
    RENDER_AS_DROPDOWN => [
        'menuStart' => '<select>',
        'menuEnd' => '</select>',
        'itemStart' => '<option>',
        'itemEnd' => '</option>',
        'item' => '%label%',
    ],
    RENDER_AS_NONE => [
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
        switch ($key) {
            case 'url' :
                $itemContent = $this->Html->link($itemContent, $value);
            case 'label':
            default:
                $itemContent = preg_replace('/%' . $key . '%/', $value, $itemContent);
                break;
        }
    }
    echo $itemContent;
    echo $format['itemEnd'];
}
echo $format['menuEnd'];
?>