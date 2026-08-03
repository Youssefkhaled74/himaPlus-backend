<?php

namespace Tests\Unit;

use App\Http\Controllers\Front\VendorOrderController;
use App\Services\OrderStatusService;
use App\Services\VendorOrderVisibilityService;
use PHPUnit\Framework\TestCase;

class VendorOrderFlowTest extends TestCase
{
    public function test_maintenance_and_quotation_orders_use_offer_flow(): void
    {
        $controller = new VendorOrderController(
            new OrderStatusService(),
            new VendorOrderVisibilityService()
        );

        $this->assertTrue($controller->shouldUseOfferFlow(2));
        $this->assertTrue($controller->shouldUseOfferFlow(3));
        $this->assertFalse($controller->shouldUseOfferFlow(1));
    }
}
