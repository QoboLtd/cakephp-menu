<?php

switch ($name) {
    case 'sidebar': ?>
        <ul class="nav">
            <?php
            $menu = $this->Menu->getMenu($name);
            foreach ($menu as $item) : ?>
                <li>
                    <a href="<?= $this->Url->build($item['url']) ?>"><?= $item['label']; ?></a>
                </li>
            <?php
            endforeach; ?>
        </ul>
<?php
        break;
    case 'top': ?>
        <ul class="nav navbar-top-links navbar-right">
            <?php
            $menu = $this->Menu->getMenu($name);
            foreach ($menu as $item) : ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="<?= $this->Url->build($item['url']) ?>">
                        <?= $item['label']; ?>
                    </a>
                </li>
            <?php
            endforeach; ?>
        </ul>
        <!-- /.navbar-top-links -->
<?php
        break;
    default:
        throw new NotFound("Layout is not found.");

        break;
}

