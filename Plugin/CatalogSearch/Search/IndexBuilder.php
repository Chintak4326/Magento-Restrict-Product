<?php

namespace ChintakExtensions\ProductRestrict\Plugin\CatalogSearch\Search;

class IndexBuilder
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @param \Magento\CatalogSearch\Model\Search\IndexBuilder $indexBuilder
     * @param \Magento\Framework\DB\Select $select
     * @return \Magento\Framework\DB\Select
     */
    public function afterBuild(\Magento\CatalogSearch\Model\Search\IndexBuilder $indexBuilder, $select)
    {
        $customer = $this->customerSession->getCustomer();
        $customerGroupId = 0;
        if (!empty($customer->getId())) {
            $customerGroupId = $customer->getGroupId();
        }
        // Retrieve the product IDs are restricted
        $productIds = $this->productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('customer_group', ['finset' => (int)$customerGroupId])
            ->getAllIds();
        // Skip the products are restricted in the result
        if ($productIds) {
            $select = $select->where('search_index.entity_id NOT IN(?)', $productIds);
        }
        return $select;
    }
}