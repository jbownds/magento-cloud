<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Eway\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;

/**
 * Assert that payment information is valid and matches with expected values.
 */
class AssertOrderPaymentInformation extends AbstractConstraint
{
    /**
     * Assert that payment information is valid and matches with expected values.
     *
     * @param OrderInjectable $order
     * @param OrderIndex $orderIndex
     * @param SalesOrderView $salesOrderView
     * @param array $paymentInfo
     * @return void
     */
    public function processAssert(
        OrderInjectable $order,
        OrderIndex $orderIndex,
        SalesOrderView $salesOrderView,
        array $paymentInfo
    ) {
        $orderIndex->open();
        $orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $order->getId()]);
        /** @var \Magento\Sales\Test\Block\Adminhtml\Order\View\Tab\Info $infoTab */
        $infoTab = $salesOrderView->getOrderForm()->getOrderInfoBlock();
        $actualPaymentInformation = $infoTab->getPaymentInfoBlock()->getData();

        \PHPUnit_Framework_Assert::assertEmpty(
            array_diff($paymentInfo, $actualPaymentInformation),
            'Payment Information missmatch with expected values.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Payment Information valid and matches with expected values.';
    }
}