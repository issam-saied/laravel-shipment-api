<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Package;
use App\Models\ShipmentOption;
use Carbon\Carbon;
use Illuminate\Support\Collection;


final class CheckoutService
{
    public function __construct(
        private OrderRepository   $orders,
        private UserRepository    $users,
        private ProductRepository $products,
        private PaymentClient     $payments,
        private Logger            $logger,
        private Database          $db,
    )
    {
    }

    /**
     * Creates an order and charges the user.
     */
    public function checkout(int $userId, array $items, string $currency): int
    {
        // items = [ ['productId' => 10, 'qty' => 2], ... ]

        $user = $this->users->find($userId);
        if (!$user) {
            throw new RuntimeException("User not found");
        }

        $total = 0;

        foreach ($items as $item) {
            $product = $this->products->find($item['productId']);
            $total += $product->price * $item['qty'];
        }

        $orderId = $this->orders->insert([
            'user_id' => $userId,
            'user_email' => $user->email,
            'status' => 'CREATED',
            'currency' => $currency,
            'total' => $total,
            'created_at' => date('c'),
        ]);

        // charge payment
        $paymentId = $this->payments->charge([
            'customerEmail' => $user->email,
            'amount' => $total,
            'currency' => $currency,
            'reference' => (string)$orderId,
        ]);

        $this->orders->update($orderId, [
            'status' => 'PAID',
            'payment_id' => $paymentId,
        ]);

        $this->logger->info("Checkout OK", [
            'orderId' => $orderId,
            'userId' => $userId,
            'total' => $total,
        ]);

        return $orderId;
    }

    /**
     * Creates an order and charges the user.
     */
    public function checkout2(int $userId, array $items, string $currency, string $correlationId): int
    {
        if (empty($items)) {
            throw new InvalidArgumentException("Items required");
        }

        $user = $this->users->find($userId);
        if (!$user) {
            throw new RuntimeException("User not found");
        }

        $totalCents = 0;

        foreach ($items as $item) {
            $qty = (int)($item['qty'] ?? 0);
            $productId = (int)($item['productId'] ?? 0);

            if ($qty <= 0 || $productId <= 0) {
                throw new InvalidArgumentException("Invalid item");
            }

            $product = $this->products->find($productId);
            if (!$product) {
                throw new RuntimeException("Product not found: {$productId}");
            }

            // price in cents (int)
            $totalCents += $product->priceCents * $qty;
        }

        // Create order first (persist intent)
        $orderId = $this->orders->insert([
            'user_id'               => $userId,
            'status'                => 'PAYMENT_PENDING',
            'currency'              => $currency,
            'total_cents'           => $totalCents,
            'correlation_id'        => $correlationId,
            'created_at'            => date('c'),
            // if you really want snapshot:
            'user_email_snapshot'   => $user->email,
        ]);


/*        $orderId = $this->orders->insert([
            'user_id' => $userId,
            'user_email' => $user->email,
            'status' => 'CREATED',
            'currency' => $currency,
            'total' => $total,
            'created_at' => date('c'),
        ]);*/


        $start = microtime(true);

        // charge payment
/*        $paymentId = $this->payments->charge([
            'customerEmail' => $user->email,
            'amount'        => $total,
            'currency'      => $currency,
            'reference'     => (string)$orderId,
        ]);*/

        try {
            // Idempotent charge: same correlationId => no double charge
            $paymentId = $this->payments->charge([
                'amountCents'    => $totalCents,
                'currency'       => $currency,
                'reference'      => (string)$orderId,
                'idempotencyKey' => $correlationId,
            ]);

/*            $this->orders->update($orderId, [
                'status'      => 'PAID',
                'payment_id'  => $paymentId,
            ]);*/


            $this->orders->update($orderId, [
                'status'     => 'PAID',
                'payment_id' => $paymentId,
            ]);


/*            $this->logger->info("Checkout OK", [
                'orderId' => $orderId,
                'userId'  => $userId,
                'total'   => $total,
            ]);*/

            $this->logger->info("Checkout OK", [
                'correlationId' => $correlationId,
                'orderId'       => $orderId,
                'userId'        => $userId,
                'totalCents'    => $totalCents,
                'paymentMs'     => (int)((microtime(true) - $start) * 1000),
            ]);

            return $orderId;
        } catch (\Throwable $e) {
            $this->orders->update($orderId, [
                'status' => 'PAYMENT_FAILED',
            ]);

            $this->logger->error("Checkout failed", [
                'correlationId' => $correlationId,
                'orderId'       => $orderId,
                'userId'        => $userId,
                'error'         => $e->getMessage(),
                'paymentMs'     => (int)((microtime(true) - $start) * 1000),
            ]);

            throw $e;
        }
    }


}



