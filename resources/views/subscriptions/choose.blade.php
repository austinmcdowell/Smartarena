@extends('layouts.no-vue')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <h3>Month To Month Membership</h3>
            <h1>$25 per month</h1>
            <form action="/charge?plan=monthly" method="POST">
                {{ csrf_field() }}
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_ygkkJT2lcGE3GGmGdJvMOurQ"
                    data-name="SmartArena"
                    data-description="Month To Month Membership"
                    data-amount="2500"
                    data-label="Sign Me Up!">
                </script>
            </form>
        </div>
        <div class="col-lg-4">
            <h3>6 Month Membership (1 Month Free)</h3>
            <h1>$99</h1>
            <form action="/charge?plan=biyearly" method="POST">
                {{ csrf_field() }}
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_ygkkJT2lcGE3GGmGdJvMOurQ"
                    data-name="SmartArena"
                    data-description="6 Month Membership (1 Month Free)"
                    data-amount="9900"
                    data-label="Sign Me Up!">
                </script>
            </form>
        </div>
        <div class="col-lg-4">
            <h3>12 Month Membership (3 Months Free)</h3>
            <h1>$179</h1>
            <form action="/charge?plan=yearly" method="POST">
                {{ csrf_field() }}
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_ygkkJT2lcGE3GGmGdJvMOurQ"
                    data-name="SmartArena"
                    data-description="12 Month Membership (3 Months Free)"
                    data-amount="17900"
                    data-label="Sign Me Up!">
                </script>
            </form>
        </div>
    </div>
@endsection