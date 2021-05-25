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
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection as Collection;

/**
 * Class BaseRepository
 * @package Ticaje\Persistence\Repository\Base
 */
trait RepositoryTrait
{
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @param Collection                   $collection
     *
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria = null, Collection $collection)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchCriteria ? $searchResults->setSearchCriteria($searchCriteria) : (function () {
        })();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
