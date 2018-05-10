<?php

namespace Ktree\TicketingSystem\Ui\Component\Listing\Column;

class Update extends \Magento\Ui\Component\Listing\Columns\Column
{

     /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformation
     * @param array $components
     * @param array $data
     */


    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $blockInstance = $objectManager->get('Ktree\TicketingSystem\Block\Create');
        $priorities = $blockInstance->getPriorities();
        $categories = $blockInstance->getCategories();
        $status = $blockInstance->getStatus();
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['status'] = $status[$item['status']];
                $item['priority'] = $priorities[$item['priority']];
                $item['category'] = $categories[$item['category']];
            }
        }
        return $dataSource;
    }
}
