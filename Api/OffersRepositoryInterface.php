<?php

namespace OlhaChe\Offers\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use OlhaChe\Offers\Api\Data\OffersInterface;
use Magento\Framework\Exception\LocalizedException;
use OlhaChe\Offers\Api\Data\OffersSearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface OffersRepositoryInterface
{
    /**
     * Save offers
     *
     * @param OffersInterface $offers
     * @return OffersInterface
     * @throws LocalizedException
     */
    public function save(OffersInterface $offers): OffersInterface;

    /**
     * Retrieve offers
     *
     * @param string $offersId
     * @return OffersInterface
     * @throws LocalizedException
     */
    public function get(string $offersId): OffersInterface;

    /**
     * Retrieve offers matching the specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return OffersSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $criteria): OffersSearchResultsInterface;

    /**
     * Delete offers
     *
     * @param OffersInterface $offers
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(OffersInterface $offers): bool;

    /**
     * Delete offers by ID
     *
     * @param string $offersId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(string $offersId): bool;
}
