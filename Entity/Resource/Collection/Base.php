<?php
declare(strict_types=1);

/**
 * Entity Collection Class
 * @package Ticaje_Persistence
 * @author Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Entity\Resource\Collection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Base
 * @package Ticaje\Persistence\Entity\Resource\Collection
 */
class Base extends AbstractCollection
{
    /**
     * Base constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     * @param string $idFieldName
     * @param string $model
     * @param string $resourceModel
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null,
        string $idFieldName,
        string $model,
        string $resourceModel
    ) {
        $this->_idFieldName = $idFieldName;
        $this->_model = $model;
        $this->_resourceModel = $resourceModel;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    protected function _construct()
    {
        $this->_init($this->_model, $this->_resourceModel);
    }
}
