<?php

namespace ChintakExtensions\ProductRestrict\Model\Attribute\Source;

class CustomerGroup extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $collectionFactory
     */
    public function __construct(\Magento\Customer\Model\ResourceModel\Group\CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get all options of customer group
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = $this->collectionFactory->create()->toOptionArray();
        }
        return $this->_options;
    }
}