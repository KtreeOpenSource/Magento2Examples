<?php
namespace Ktree\CustomModule\Block;

class Test extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }

    public function displayContent()
    {
        return __('Hello World!');
    }
}
