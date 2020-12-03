<?php
declare(strict_types=1);

/**
 * Base Repository Class
 * @category    Ticaje
 * @package     Ticaje_Persistence
 * @author      Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Repository\Base;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\ObjectManagerInterface; // For the sake of simplicity we're using Magento OM.
use Exception;
use Throwable;

/**
 * Class BaseRepository
 * @package Ticaje\Persistence\Repository\Base
 * The drawbacks of using this abstraction is having three dependencies, defined in this class attributes.
 * It is a must to pass such a dependencies through
 */
class BaseRepository implements BaseRepositoryInterface
{
    use BaseTrait;

    private $object; // The current model class name

    private $collection; // The current model collection class name

    /** @var SearchResultsInterfaceFactory $searchResultsFactory */
    private $searchResultsFactory;

    /** @var ObjectManagerInterface $objectManager */
    private $objectManager;

    /**
     * PersistenceRepository constructor.
     * @param string $object
     * @param string $collection
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param ObjectManagerInterface $objectManager
     */
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
    public function save($object)
    {
        try {
            $object->save();
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $object = $this->objectManager->create($this->object);
        try {
            $object->load($id);
            if (!$object->getId()) {
                throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
            }
            return $object;
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSingle(SearchCriteriaInterface $criteria)
    {
        $list = $this->getList($criteria);
        return $list->getTotalCount() > 0 ? $list->getItems()[0] : null;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->objectManager->create($this->collection);
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }

    /**
     * @inheritDoc
     * We're dealing here with some high level issue like returning an object with information about deleting action
     * Perhaps a returning normalized interface would be more convenient instead
     */
    public function delete($object): array
    {
        $result = ['success' => true, 'message' => 'successfully deleted!!!'];
        try {
            $object->delete();
        } catch (Throwable $exception) {
            $result = ['success' => false, 'message' => $exception->getMessage()];
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): array
    {
        $object = $this->getById($id);
        $result = $this->delete($object);
        return $result;
    }
}
