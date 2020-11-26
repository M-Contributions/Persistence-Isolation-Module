<?php
declare(strict_types=1);

/**
 * Persistence Repository Interface
 * @category    Ticaje
 * @package     Ticaje_Persistence
 * @author      Hector Luis Barrientos <ticaje@filetea.me>
 */

namespace Ticaje\Persistence\Repository\Base;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface PersistenceRepositoryInterface
 * @package Ticaje\Persistence\Repository\Base
 */
interface BaseRepositoryInterface
{
    /**
     * @param $object
     * @return mixed
     * @throws CouldNotSaveException
     */
    public function save($object);

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $criteria
     * @return mixed|null
     */
    public function getSingle(SearchCriteriaInterface $criteria);

    /**
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface;

    /**
     * @param $object
     * @return array
     */
    public function delete($object): array;

    /**
     * @param $id
     * @return array
     */
    public function deleteById($id): array;
}
