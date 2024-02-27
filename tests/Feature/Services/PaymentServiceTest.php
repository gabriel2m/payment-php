<?php

namespace Tests\Feature\Services;

use App\Contracts\Services\PaymentService;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public PaymentService $paymentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->paymentService = app(PaymentService::class);
    }

    public function test_can_creat_a_payment(): void
    {
        $data = $this->newPaymentData();

        $this->paymentService->create($data->toArray());

        $this->assertPaymentData(Payment::first(), $data);
    }

    public function test_can_update_a_payment(): void
    {
        $payment = Payment::factory()->create();
        $data = Payment::factory()->make()->toArray();

        $this->paymentService->update($payment, $data);

        $payment->refresh();

        $this->assertEquals(
            $payment->setVisible(array_keys($data))->toArray(),
            $data
        );
    }
}
