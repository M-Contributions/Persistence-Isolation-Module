<?php
declare(strict_types=1);

/**
 * Module Definition File
 * @package Ticaje_Persistence
 * @author Hector Barrientos <ticaje@filetea.me>
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Ticaje_Persistence',
    __DIR__
);
