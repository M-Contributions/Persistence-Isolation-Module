<?php
declare(strict_types=1);

/**
 * Base Repository Class
 * @category    Ticaje
 * @package     Ticaje_Persistence
 * @author      Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Repository\Base;

/**
 * Class BaseRepository
 * @package Ticaje\Persistence\Repository\Base
 */
trait BaseTrait
{
    protected function getCollectionName()
    {
        return $this->collection;
    }

    protected function getObjectManager()
    {
        return $this->objectManager;
    }
}
