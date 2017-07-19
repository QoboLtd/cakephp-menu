<?php

namespace Menu\MenuBuilder;

/**
 *  MenuRenderInterface
 *
 * the interface for all menu render classes
 */
interface MenuRenderInterface
{
    /**
     *  render method
     *
     * @param array $options to generate menu
     * @return string rendered menu as per specified format
     */
    public function render(array $options = []);
}
