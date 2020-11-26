<?php
declare(strict_types=1);

/**
 * Entity Resource Class
 * @package Ticaje_Persistence
 * @author Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Entity\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context as ParentContext;

/**
 * Class Base
 * @package Ticaje\Persistence\Entity\Resource
 */
class Base extends AbstractDb
{
    private $tableName;

    private $referenceId;

    /**
     * Base constructor.
     * @param ParentContext $context
     * @param null $connectionName
     * @param string $tableName
     * @param string $referenceId
     */
    public function __construct(
        ParentContext $context,
        $connectionName = null,
        string $tableName,
        string $referenceId
    ) {
        $this->tableName = $tableName;
        $this->referenceId = $referenceId;
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init($this->tableName, $this->referenceId);
    }
}
