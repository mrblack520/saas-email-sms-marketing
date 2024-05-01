@extends('theme::layouts.app')

@section('content')







<div style="    margin-left: 25.0rem" class=" w-full border-gray-200 px-5 py-10 text-gray-800 flex justify-center items-center">
    <div class="w-full">
        <div class="-mx-3 md:flex items-start">
            <div class="px-3 md:w-7/12 lg:pr-10">
                <div class="w-full mx-auto text-gray-800 font-light mb-6 border-b border-gray-200 pb-6">
                    <div class="w-full flex items-center">

                        <div class="flex-grow pl-3">
                            <h6 class="font-semibold uppercase text-gray-600">{{ request('name', 1) }}.</h6>

                        </div>
                        <div>
                            <span class="font-semibold text-gray-600 text-xl">${{ request('price', 1) }}</span><span class="font-semibold text-gray-600 text-sm">.00</span>
                        </div>
                    </div>
                </div>
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <form id="couponForm" >
                    <div class="-mx-2 flex items-end justify-end">
                        <div class="flex-grow px-2 lg:max-w-xs">
                            <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Discount code</label>
                            <div>
                                <input type="hidden" id="planid" value={{ request('id', 1) }} name="planid">
                                <input type="hidden" value={{ request('price', 1) }} name="price">
                                <input id="discount-code-input" name="discount_code" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="XXXXXX" type="text"/>

                            </div>
                        </div>
                        <div class="px-2">
                            <button id="apply-discount-btn"  class="block w-full max-w-xs mx-auto border border-transparent bg-gray-400 hover:bg-gray-500 focus:bg-gray-500 text-white rounded-md px-5 py-2 font-semibold">APPLY</button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="mb-6 pb-6 border-b border-gray-200 text-gray-800">
                    <div class="w-full flex mb-3 items-center">
                        <div class="flex-grow">
                            <span class="text-gray-600">Subtotal</span>
                        </div>
                        <div class="pl-3">
                            <span class="font-semibold">${{ request('price', 1) }}</span>
                        </div>
                    </div>
                    <div class="w-full flex items-center">
                        <div class="flex-grow">
                            <span class="text-gray-600">Discount </span>
                        </div>
                        <div class="pl-3">
                            <span id="discount-amount" class="font-semibold"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-6 pb-6 border-b border-gray-200 md:border-none text-gray-800 text-xl">
                    <div class="w-full flex items-center">
                        <div class="flex-grow">
                            <span class="text-gray-600">Total</span>
                        </div>
                        <div class="pl-3">
                            <span class="font-semibold text-gray-400 text-sm">USD</span> <span id="total-amount" class="font-semibold"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 md:w-5/12">
                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                    <div class="w-full flex mb-3 items-center">
                        <div class="w-32">
                            <span class="text-gray-600 font-semibold">Contact</span>
                        </div>
                        <div class="flex-grow pl-3">
                            <span>{{auth()->user()->phone}}</span>
                        </div>
                    </div>
                    <div class="w-full flex items-center">
                        <div class="w-32">
                            <span class="text-gray-600 font-semibold">Billing Address</span>
                        </div>
                        @php
    $userData = DB::table('users')
                ->join('cities', 'users.city', '=', 'cities.city_id')
                ->join('countries', 'users.country', '=', 'countries.country_id')
                ->where('users.id', auth()->user()->id)
                ->select('users.address', 'cities.city_name as city', 'countries.country_name as country')
                ->first();
@endphp
                        <div class="flex-grow pl-3">
                            <span>{{ optional($userData)->address ? $userData->address : 'Update your profile' }},
                                {{ optional($userData)->city ?? 'Update your profile' }},
                                {{ optional($userData)->country ?? 'Update your profile' }}
                            </span>
                            
                        </div>
                    </div>
                </div>
                <form id='checkout-form' method='post' action="{{ route('create.payment') }}">
                    @csrf
                    <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">
                        <div class="w-full p-3 border-b border-gray-200">
                            <div class="mb-5">
                                <label for="type1" class="flex items-center cursor-pointer">
                                    <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="type" id="type1" checked>
                                    <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png" class="h-6 ml-3">
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Name on card</label>
                                <div>
                                    <input type='hidden' name='stripeToken' id='stripe-token-id'>
                                    <input type='hidden' name='couponCode' id='couponCode' value="">

                                    <input type='hidden' name='subID' value="{{ request('id', 1) }}">
                                    <input class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text"/>
                                </div>
                            </div>
                            <div id="card-element"></div>
                        </div>
                    </div>
                    <div>
                        <button id='pay-btn' onclick="createToken()" class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-2 font-semibold"><i class="mdi mdi-lock-outline mr-1"></i> PAY NOW</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

    $(document).ready(function () {
        $("#apply-discount-btn").click(function (e) {
            e.preventDefault();

            var planid = $("#planid").val();
            var discountCode = $("#discount-code-input").val();
            $("#couponCode").val(discountCode);

            $.ajax({
                type: "POST",
                url: "/check-coupon/" + planid,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    discount_code: discountCode
                },

                success: function (response ,xhr, status, error) {

                    if (response.valid) {
                        var discountAmount = response.discount_amount;
                        var subtotal = parseFloat("{{ request('price', 1) }}");
                        var totalAmount = subtotal - discountAmount;

                        // Use Intl.NumberFormat for currency formatting
                        var formatter = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        });
                        
                        $("#discount-amount").text(formatter.format(totalAmount));

                        $("#total-amount").text(formatter.format(discountAmount));
                    } else {

                        e.error("Error checking coupon:", error);
        console.log(xhr.responseText);
                        alert("Invalid coupon code. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error checking coupon:", error);
        console.log(xhr.responseText);
                    // Display a more user-friendly message
                    alert("Error checking coupon. Please try again.");
                }
            });
        });
    });

    </script>

@endsection
