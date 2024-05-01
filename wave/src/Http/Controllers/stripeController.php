<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use Wave\StripeConfiguration;
use Wave\PaddleSubscription;
use Wave\Plan;
use Illuminate\Http\Request;
use Stripe\InvoiceItem;
use Stripe\PaymentIntent;
use Stripe;
use Twilio\Rest\Client;
use Auth;
use App\Models\Coupon;
use Wave\User;
use Stripe\Charge;
use Carbon\Carbon;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\ApiConnectionException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
class stripeController extends Controller
{
    public function stripeform(){

        return view("theme::stripeform");
    }
    public function stripeApi(){
        return view("stripeApi");
    }


    public function stripeStore(Request $request){

        $request->validate([
            'stripe_key' => 'required',
            'stripe_secret' => 'required',
        ]);


        $stripeConfig = StripeConfiguration::firstOrNew();


        $stripeConfig->key = $request->input('stripe_key');
        $stripeConfig->secret = $request->input('stripe_secret');
        $stripeConfig->save();

        return redirect()->back()->with('success', 'Stripe configuration updated successfully');


    }

    public function create(Request $request)
{
    try {

        // Validate and sanitize user input
        $data = $request->validate([

            'subID' => 'required',
            'stripeToken' => 'required',
            'couponCode' => 'nullable|string',
        ]);

        $getPrice = Plan::where('id', $data['subID'])->select('price')->first();
        $basePrice = $getPrice->price;
        $testdiscountedAmount = 0;
        $discountedAmount = 0;
        if (!empty($data['couponCode'])) {

            $discountedAmount = $this->calculateDiscount($basePrice, $data['couponCode']);
            $testdiscountedAmount = $discountedAmount;
        } else{
        $discountedAmount = $basePrice;

        }

        // Ensure the user is authenticated
        $user = Auth::user();
        $user_id = $user->id;

        // $apiKey = "sk_test_51NvElWDsAglUhVjeIov5U9NYH2iD8oHDJXsZ7mv3PRC15JMtYWm0hxCx0N1jannoBbOuIdI2zv9vDt006OKZbDWF00dxLpHy3O";

     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));


        // Retrieve existing tokens if needed (check if this is necessary)
        $existingTokens = $user;

        $payment = Stripe\Charge::create([
            "amount" => $discountedAmount  * 100,
            "metadata" => [
                "subscription_id" => $data['subID'],
            ],
            "currency" => "usd",
            "source" => $data['stripeToken'],
            "description" => "Test Payment"
        ]);

        // Store payment information in the database
        $store = PaddleSubscription::create([
            'subscription_id' => $data['subID'],
            'plan_id' => $payment['metadata']->subscription_id,
            'user_id' => $user_id,
            'status' => $payment->status,
        ]);

        if ($payment->status === 'succeeded') {
            // Assuming $payment['metadata']->subscription_id is providing the correct value
            $purchasedPlan = $payment['metadata']->subscription_id;



            if ($purchasedPlan === '1') {
                User::where('id', $user_id)->update(['role_id' => 3]);
            } elseif ($purchasedPlan === '2') {
                User::where('id', $user_id)->update(['role_id' => 5]);
            } elseif ($purchasedPlan === '3') {
                User::where('id', $user_id)->update(['role_id' => 4]);
            }
        }

       
        // Render the invoice
$viewData = [
    'payment' => $payment,
    
];
// dd($viewData);
$pdf = PDF::loadView('invoices', [
    'viewData' => $viewData,
    'basePrice' => $basePrice,
    'testdiscountedAmount' => $testdiscountedAmount,
]);
// Specify the directory path
$directory = public_path('storage/invoices');

// Check if the directory exists, and create it if not
if (!File::exists($directory)) {
    File::makeDirectory($directory, 0777, true, true);
}
$filename = 'invoice_' . now()->format('YmdHis') . '.pdf';
// Save the PDF to the specified directory
$pdf->save(public_path("storage/invoices/{$filename}"));

$store->update(['invoice_pdf_path' => "invoices/{$filename}"]);

return redirect()->Route('wave.dashboard')->with('success' , 'you Billing is completed successfully');


    } catch (Stripe\Exception\CardException | Stripe\Exception\InvalidRequestException | Stripe\Exception\AuthenticationException | Stripe\Exception\ApiConnectionException | Exception $e) {
        // Log the exception for debugging purposes
        \Log::error($e);

        // Handle the Stripe exception
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function cancelSubscription(Request $request)
{
    // Retrieve user and subscription information
    $user = auth()->user();
    $subscription = $user->subscription;

    // Cancel the subscription using Stripe API
    try {
        $stripeSubscription = PaddleSubscription::update(
            $subscription->stripe_subscription_id,
            ['cancel_at_period_end' => true]
        );
    } catch (\Exception $e) {
        // Handle any errors during subscription cancellation
        return response()->json(['error' => $e->getMessage()], 500);
    }

    // Update local database to reflect the cancellation
    $subscription->update(['status' => 'canceled']);

    // Perform any additional logic here (e.g., update user role)

    return response()->json(['message' => 'Subscription canceled successfully']);
}
private function calculateDiscount($basePrice, $couponCode)
{
    if (!is_numeric($basePrice) || $basePrice < 0) {
        throw new \Exception('Invalid base price.');
    }

    $coupon = Coupon::where('code', $couponCode)->first();

    if (!$coupon) {
        throw new \Exception('Invalid coupon.');
    }

    $now = Carbon::now();

    if ($coupon->valid_from && $now->isBefore($coupon->valid_from)) {
        throw new \Exception('Coupon is not yet valid.');
    }

    if ($coupon->valid_to && $now->isAfter($coupon->valid_to)) {
        throw new \Exception('Coupon has expired.');
    }

    if ($coupon->discount_percentage < 0 || $coupon->discount_percentage > 100) {
        throw new \Exception('Invalid discount percentage.');
    }

    $discountedTotal = $basePrice - ($basePrice * ($coupon->discount_percentage / 100));
    $discountedTotal = max($discountedTotal, 0);

    return $discountedTotal;
}


}
