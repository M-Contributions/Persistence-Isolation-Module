<?php
declare(strict_types=1);
/**
 * Entity Collection Class
 * @package Ticaje_Persistence
 * @author  Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Entity\Resource\Collection;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

/**
 * Class Base
 * @package Ticaje\Persistence\Entity\Resource\Collection
 */
class Base extends AbstractCollection
{
    public function __construct(
        string $idFieldName,
        string $model,
        string $resourceModel,
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->_model = $model;
        $this->_resourceModel = $resourceModel;
        $this->_idFieldName = $idFieldName;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    protected function _construct()
    {
        $this->_init($this->_model, $this->_resourceModel);
    }
}
