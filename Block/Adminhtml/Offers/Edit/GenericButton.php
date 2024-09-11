<?php

namespace OlhaChe\Offers\Block\Adminhtml\Offers\Edit;

use Magento\Backend\Block\Widget\Context;

abstract class GenericButton
{

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(protected Context $context)
    {
    }

    /**
     * Return model ID
     *
     * @return int|null
     */
    public function getModelId()
    {
        return $this->context->getRequest()->getParam('offers_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
