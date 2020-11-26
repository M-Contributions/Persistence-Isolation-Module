<?php
declare(strict_types=1);

/**
 * Entity Class
 * @package Ticaje_Persistence
 * @author Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Entity;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Class Base
 * @package Ticaje\Persistence\Entity
 */
class Base extends AbstractModel implements IdentityInterface
{
    private $resourceModelClass;

    private $cacheTag;

    /**
     * Base constructor.
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param string $resourceModelClass
     * @param string $cacheTag
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        string $resourceModelClass,
        string $cacheTag,
        array $data = []
    ) {
        $this->resourceModelClass = $resourceModelClass;
        $this->cacheTag = $cacheTag;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init($this->resourceModelClass);
    }

    public function getIdentities()
    {
        return [$this->cacheTag . '_' . $this->getId()];
    }
}
