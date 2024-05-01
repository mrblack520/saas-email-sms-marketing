<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use Wave\Plan;
class CouponController extends Controller
{
    public function checkCoupon(Request $request, $id)
    {


            $discountCode = $request->input('discount_code');

            $coupon = Coupon::where('code', $discountCode)->first();

            $plan = Plan::find($id);

            if ($plan !== null && $coupon !== null) {
                $price = $this->fetchPriceForPlan($plan);

                $discountAmount = $this->calculateDiscountAmount($coupon, $price);

                return response()->json([
                    'valid' => true,
                    'discount_amount' => $discountAmount,
                ]);
            } else {
                // Handle the case where the plan or coupon is not found
                return response()->json([
                    'valid' => false,
                    'error' => 'Plan or coupon not found',
                ], 404);
            }

            // Log the exception for debugging purposes
            \Log::error('Error checking coupon: ' . $e->getMessage());

            // Return a generic error message to the client
            return response()->json([
                'valid' => false,
                'error' => 'Error checking coupon. Please try again.',
            ], 500);

    }





    public function removeCoupon(Request $request)
    {


        return response()->json(['message' => 'Coupon removed successfully.']);
    }

    private function calculateDiscountAmount($coupon, $price)
    {
        if ($coupon->discount_percentage > 0) {

            $discountedTotal = $price - ($price * ($coupon->discount_percentage / 100));

        return $discountedTotal;
        } else {
            // No valid discount amount found, use the original price
            return $price;
        }

    }


    private function fetchPriceForPlan($plan)
{

    return $plan->price;
}
}
