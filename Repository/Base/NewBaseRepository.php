<?php
declare(strict_types=1);
/**
 * Base Repository Class
 * @category    Ticaje
 * @package     Ticaje_Persistence
 * @author      Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Repository\Base;

use Exception;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\ObjectManagerInterface;
use Throwable;
use Ticaje\Contract\Persistence\Entity\EntityInterface;

/**
 * Class NewBaseRepository
 * @package Ticaje\Persistence\Repository\Base
 */
class NewBaseRepository implements BaseRepositoryInterface
{
    use RepositoryTrait;

    private $object; // The current model class name

    private $collection; // The current model collection class name

    /** @var SearchResultsInterfaceFactory $searchResultsFactory */
    private $searchResultsFactory;

    /** @var ObjectManagerInterface $objectManager */
    private $objectManager;

    public function __construct(
        string $object,
        string $collection,
        SearchResultsInterfaceFactory $searchResultsFactory,
        ObjectManagerInterface $objectManager
    ) {

        $this->object = $object;
        $this->collection = $collection;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->objectManager = $objectManager;
    }

    /**
     * @inheritDoc
     */
    public function save(EntityInterface $object): EntityInterface
    {
        try {
            $object->getResource()->save($object);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?EntityInterface
    {
        /** @var AbstractModel $object */
        $object = $this->objectManager->create($this->object);
        $object->getResource()->load($object, $id);
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getSingle($criteria): ?EntityInterface
    {
        $list = $this->getList($criteria);

        return $list->getTotalCount() > 0 ? (function () use ($list) {
            $result = current($list->getItems());

            return $result;
        })() : null;
    }

    /**
     * @inheritDoc
     */
    public function getList($criteria = null): SearchResultsInterface
    {
        $collection = $this->objectManager->get($this->collection);
        if ($criteria) {
            $this->addFiltersToCollection($criteria, $collection);
            $this->addSortOrdersToCollection($criteria, $collection);
            $this->addPagingToCollection($criteria, $collection);
        }
        $collection->load();

        return $this->buildSearchResult($criteria, $collection);
    }

    /**
     * @inheritDoc
     * We're dealing here with some high level issue like returning an object with information about deleting action
     * Perhaps a returning normalized interface would be more convenient instead
     */
    public function delete(EntityInterface $object): array
    {
        $result = [
            'success' => true,
            'message' => 'successfully deleted!!!',
        ];
        try {
            $object->getResource()->delete($object);
        } catch (Throwable $exception) {
            $result = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): array
    {
        $object = $this->getById($id);
        $result = $this->delete($object);

        return $result;
    }
}
