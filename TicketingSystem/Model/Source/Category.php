<?php
namespace Ktree\TicketingSystem\Model\Source;

class Category implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve status options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Order')],
            ['value' => 2, 'label' => __('Payment')],
            ['value' => 3, 'label' => __('Others')]
        ];
    }
}
