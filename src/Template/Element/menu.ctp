<?php
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;

$name = isset($name) ? $name : 'main';
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
}
elseif (is_array($renderAs)) {
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
}
else {
    throw new InvalidArgumentException("Ooops!");
}

$itemDefaults = [
    'url' => '#',
    'label' => 'Undefined',
    'icon' => 'cube'
];

$capsTable = TableRegistry::get('RolesCapabilities.Capabilities');
$user = [];
if (isset($_SESSION['Auth']['User'])) {
    $user = $_SESSION['Auth']['User'];
};

if (!function_exists('checkCapsList')) {
    function checkCapsList($caps, $capsTable, $user) {
        $result = false;
        foreach ($caps as $cap) {
            if ($capsTable->hasAccess($cap, $user['id'])) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}

if (!function_exists('checkFromUrl')) {
    function checkFromUrl($item, $capsTable, $user) {
        $result = false;
        if (!is_array($item['url'])) {
            throw new RuntimeException(__('Url parameters are not a CakePHP Url builder compatible array'));
        }
        try {
            $capsTable->checkAccess($item['url'], $user);
            $result = true;
        } catch (ForbiddenException $e) {
            $result = false;
        }

        return $result;
    }
}

foreach ($menu as $k => $item) {
    if (!array_key_exists('capabilities', $item)) {
        continue;
    }

    /*
    requires at least access to one capability from the list
     */
    $hasAccess = true;
    if (is_array($item['capabilities'])) {
        $hasAccess = checkCapsList($item['capabilities'], $capsTable, $user);
    } elseif (is_string($item['capabilities'])) {
        switch ($item['capabilities']) {
            case 'fromUrl':
                $hasAccess = checkFromUrl($item, $capsTable, $user);
                break;

            case 'fromChildren':
                if (empty($item['children'])) {
                    throw new RuntimeException(__('Children not defined'));
                }
                $childrenCaps = [];
                $hasAcessChild = false;
                foreach ($item['children'] as $i => $child) {
                    if (!array_key_exists('capabilities', $child)) {
                        continue;
                    }
                    if (is_array($child['capabilities'])) {
                        $hasAcessChild = checkCapsList($child['capabilities'], $capsTable, $user);
                        if ($hasAcessChild) {
                            break;
                        }
                    } elseif (is_string($child['capabilities'])) {
                        switch ($child['capabilities']) {
                            case 'fromUrl':
                                $hasAcessChild = checkFromUrl($child, $capsTable, $user);
                                break;
                            default:
                                $hasAcessChild = $capsTable->hasAccess($child['capabilities'], $user['id']);
                                break;
                        }
                    }

                    if (!$hasAcessChild) {
                        unset($menu[$k]['children'][$i]);
                        if (!empty($menu[$k]['children'])) {
                            $hasAccess = true;
                        } else {
                            $hasAccess = false;
                        }
                    }
                }
                break;

            default:
                $hasAccess = $capsTable->hasAccess($item['capabilities'], $user['id']);
                break;
        }
    }

    if (!$hasAccess) {
        unset($menu[$k]);
    }
}

echo $format['menuStart'];
foreach ($menu as $item) {
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
?>