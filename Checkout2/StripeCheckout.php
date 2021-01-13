<?php

namespace App\Checkout;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class StripeCheckout extends AbstractController
{
    /**
     * @Route("/create-checkout-session", name="create_checkout_session", methods={"GET", "POST"})
     *
     * @param string $apiSecretKey
     * @param string $productName
     * @param integer $amount
     * @param string $currency
     * @return JsonResponse
     */
    public function createCheckoutSession(
        string $apiSecretKey = 'sk_test_51I7qCgIjktDIYiezUfNYo411jpXTPey9JPxQBzojqxMJxHKmUA6XN2czkq5r4dGieTTSZytFtYosvhLReG1m3z3E00GDzfPTIn',
        string $productName = 'T-shirt',
        int $amount = 2000,
        string $currency = 'usd'
    ): JsonResponse
    {
        \Stripe\Stripe::setApiKey($apiSecretKey);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                'name' => $productName,
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
        ]);

        return new JsonResponse([ 'id' => $session->id ], 200);
    }
}