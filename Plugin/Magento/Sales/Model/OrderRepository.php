<?php

namespace Bodak\CheckoutCustomForm\Plugin\Magento\Sales\Model;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;


class OrderRepository
{
    protected $logger;
    protected $extensionFactory;

    const FIELD_NAME = 'checkout_purchase_order_no';
    
    public function __construct(
        OrderExtensionFactory $extensionFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->extensionFactory = $extensionFactory;
    }
    
    public function afterGet(\Magento\Sales\Api\OrderRepositoryInterface $subject, 
                             \Magento\Sales\Api\Data\OrderInterface $order)
    {
        $checkout_purchase_order_no = $order->getData(self::FIELD_NAME);
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setCheckoutPurchaseOrderNo($checkout_purchase_order_no);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

}
