<?php
namespace Ktree\TicketingSystem\Model\Source;

class Priority implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve status options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Urgent')],
            ['value' => 1, 'label' => __('High')],
            ['value' => 2, 'label' => __('Medium')],
            ['value' => 3, 'label' => __('Low')]
        ];
    }
}
