<?php
namespace Ktree\CustomTab\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form;

class Custom extends AbstractModifier
{
    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'test' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'additionalClasses' => 'admin__fieldset-product-custom',
                                'label' => __('Custom Tab'),
                                'collapsible' => true,
                                'componentType' => Form\Fieldset::NAME,
                                'dataScope' => self::DATA_SCOPE_PRODUCT,
                                'disabled' => false,
                                'sortOrder' => $this->getNextGroupSortOrder(
                                    $meta,
                                    'search-engine-optimization',
                                    15
                                )
                            ],
                        ],
                    ],
                    'children' =>$this->getPanelChildren(),
                ],
            ]
        );

        return $meta;
    }
    protected function getPanelChildren()
    {
        return [
            'custom_tab_content' => $this->getCustomContent()

        ];
    }
    protected function getCustomContent()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'content' => "custom tab inputs here",
                        'formElement' => 'container',
                        'componentType' => 'container',
                        'label' => false,
                        'template' => 'ui/form/components/complex',
                    ],
                ],
            ],
            'children' => [],
        ];
    }
}
?>
