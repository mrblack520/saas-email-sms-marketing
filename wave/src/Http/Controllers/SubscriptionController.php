<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use TCG\Voyager\Models\Role;
use Wave\PaddleSubscription;
use Carbon\Carbon;
use Wave\Plan;
use Wave\User;
use Stripe\Stripe;
use Stripe\Invoice;

class SubscriptionController extends Controller
{

    private $paddle_checkout_url;
    private $paddle_vendors_url;
    private $endpoint = 'https://vendors.paddle.com/api';

    private $vendor_id;
    private $vendor_auth_code;

    // public function __construct(){
    //     $this->vendor_auth_code = config('wave.paddle.auth_code');
    //     $this->vendor_id = config('wave.paddle.vendor');

    //     $this->paddle_checkout_url = (config('wave.paddle.env') == 'sandbox') ? 'https://sandbox-checkout.paddle.com/api' : 'https://checkout.paddle.com/api';
    //     $this->paddle_vendors_url = (config('wave.paddle.env') == 'sandbox') ? 'https://sandbox-vendors.paddle.com/api' : 'https://vendors.paddle.com/api';
    // }

    public function cancel(Request $request){
        $this->cancelSubscription($request->id);
        return response()->json(['status' => 1]);
    }

    private function cancelSubscription($subscription_id){
        $subscription = PaddleSubscription::where('subscription_id', $subscription_id)->first();
        $subscription->cancelled_at = Carbon::now();
        $subscription->status = 'cancelled';
        $subscription->save();
        $user = User::find( $subscription->user_id );
        $cancelledRole = Role::where('name', '=', 'cancelled')->first();
        $user->role_id = $cancelledRole->id;
        $user->save();
    }

    // public function checkout(Request $request){

    //     try {
    //         // Validate and sanitize user input
    //         $data = $request->validate([
    //             'amount' => 'required|numeric',
    //             'subID' => 'required',
    //             'stripeToken' => 'required',
    //         ]);
    
    //         // Ensure the user is authenticated
    //         $user = Auth::user();
    //         $user_id = $user->id;
    
    //         $apiKey = "sk_test_51NvElWDsAglUhVjeIov5U9NYH2iD8oHDJXsZ7mv3PRC15JMtYWm0hxCx0N1jannoBbOuIdI2zv9vDt006OKZbDWF00dxLpHy3O";
    
    //         Stripe\Stripe::setApiKey($apiKey);
    
    //         // Retrieve existing tokens if needed (check if this is necessary)
    //         $existingTokens = $user;
    
    //         $payment = Stripe\Charge::create([
    //             "amount" => $data['amount'] * 100,
    //             "metadata" => [
    //                 "subscription_id" => $data['subID'],
    //             ],
    //             "currency" => "usd",
    //             "source" => $data['stripeToken'],
    //             "description" => "Test Payment"
    //         ]);
    
    //         // Store payment information in the database
    //         $store = PaddleSubscription::create([
    //             'subscription_id' => $data['subID'],
    //             'plan_id' => $payment['metadata']->subscription_id,
    //             'user_id' => $user_id,
    //             'status' => $payment->status,
    //         ]);
    
    //         if ($payment->status === 'succeeded') {
    //             // Assuming $payment['metadata']->subscription_id is providing the correct value
    //             $purchasedPlan = $payment['metadata']->subscription_id;
    
    
    
    //             if ($purchasedPlan === '1') {
    //                 User::where('id', $user_id)->update(['role_id' => 3]);
    //             } elseif ($purchasedPlan === '2') {
    //                 User::where('id', $user_id)->update(['role_id' => 5]);
    //             } elseif ($purchasedPlan === '3') {
    //                 User::where('id', $user_id)->update(['role_id' => 4]);
    //             }
    //         }
    
    
    
    
    //         return redirect()->route('wave.dashboard')->with('success', 'Payment Successful');
    //     } catch (Stripe\Exception\CardException | Stripe\Exception\InvalidRequestException | Stripe\Exception\AuthenticationException | Stripe\Exception\ApiConnectionException | Exception $e) {
    //         // Log the exception for debugging purposes
    //         \Log::error($e);
    
    //         // Handle the Stripe exception
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function invoices(){

        $user = auth()->user();

        if (!$user->subscription || !$user->subscription->stripe_subscription_id) {
            return response()->json(['error' => 'User does not have an active subscription'], 404);
        }
    
        // Set your Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            // Retrieve Stripe invoices
            $invoices = Invoice::all([
                'subscription' => $user->subscription->stripe_subscription_id,
                'status' => 'paid', // You can adjust the status as needed
            ]);
    
            return response()->json(['invoices' => $invoices]);
        } catch (\Exception $e) {
            // Handle any errors during invoice retrieval
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function switchPlans(Request $request){
        $plan = Plan::where('plan_id', $request->plan_id)->first();

        if(isset($plan->id)){
            // Update the user plan with Paddle
            $response = Http::post($this->paddle_vendors_url . '/2.0/subscription/users/update', [
                'vendor_id' => $this->vendor_id,
                'vendor_auth_code' => $this->vendor_auth_code,
                'subscription_id' => $request->user()->subscription->subscription_id,
                'plan_id' => $request->plan_id
            ]);

            if($response->successful()){
                $body = $response->json();

                if($body['success']){
                    // Next, update the user role associated with the updated plan
                    $request->user()->forceFill([
                        'role_id' => $plan->role_id
                    ])->save();

                    // And, update the subscription with the updated plan.
                    $request->user()->subscription()->update([
                        'plan_id' => $request->plan_id
                    ]);

                    return back()->with(['message' => 'Successfully switched to the ' . $plan->name . ' plan.', 'message_type' => 'success']);
                }
            }

        }

        return back()->with(['message' => 'Sorry, there was an issue updating your plan.', 'message_type' => 'danger']);


    }

}
