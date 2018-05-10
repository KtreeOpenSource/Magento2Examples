<?php
namespace Ktree\TicketingSystem\Model\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve status options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('New')],
            ['value' => 2, 'label' => __('Open')],
            ['value' => 3, 'label' => __('Pending')],
            ['value' => 4, 'label' => __('Closed')]
        ];
    }
}
