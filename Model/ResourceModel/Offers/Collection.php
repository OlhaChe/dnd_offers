<?php

namespace OlhaChe\Offers\Model\ResourceModel\Offers;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use OlhaChe\Offers\Model\Offers as OffersModel;
use OlhaChe\Offers\Model\ResourceModel\Offers as OffersResourceModel;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'offers_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            OffersModel::class,
            OffersResourceModel::class
        );
    }
}

