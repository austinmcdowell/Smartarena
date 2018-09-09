@extends('layouts.no-vue')

@section('content')
    <div id="subscribe" class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="subscription-card">
                <div class="sub-price">
                    <h1 class="sub-price" align="center">$25</h1>
                </div>
                <div class="sub-title">
                    <h3 align="center">Month To Month Membership</h3>
                </div>
                
                <form action="/charge?plan=monthly" method="POST">
                    {{ csrf_field() }}
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="pk_live_aZlhsimJsWybDP10BrMv7spB"
                        data-name="SmartArena"
                        data-description="Month To Month Membership"
                        data-amount="2500"
                        data-label="Sign Me Up!">
                    </script>
                    <script>
                        // Hide default stripe button, be careful there if you
                        // have more than 1 button of that class
                        document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
                    </script>
                    <button type="submit" class="buy-btn">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="subscription-card">
            <h2 align="center">$1 Limited time</h2>
                <div class="sub-price">
                    <h1 class="sub-price" align="center" style="text-decoration-line: line-through">$99</h1>
                </div>
                <div class="sub-title">
                    <h3 align="center">6 Month Membership (1 Month Free)</h3>
                </div>
                
                <form action="/charge?plan=biyearly" method="POST">
                    {{ csrf_field() }}
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="pk_live_aZlhsimJsWybDP10BrMv7spB"
                        data-name="SmartArena"
                        data-description="6 Month Membership (1 Month Free)"
                        data-amount="9900"
                        data-label="Sign Me Up!">
                    </script>
                    <script>
                        // Hide default stripe button, be careful there if you
                        // have more than 1 button of that class
                        document.getElementsByClassName("stripe-button-el")[1].style.display = 'none';
                    </script>
                    <button type="submit" class="buy-btn">Subscribe</button>
                </form>

                <!-- <form action="/charge?plan=biyearly" method="POST">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="xxx"
                        data-amount="999"
                        data-name="zzz"         
                        data-locale="auto">
                    </script>
                    <script>
                        document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
                    </script>
                    <button type="submit" class="yourCustomClass">Buy my things</button>
                </form> -->
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="subscription-card">
                <div class="sub-price">
                    <h1 class="sub-price" align="center">$179</h1>
                </div>
                <div class="sub-title">
                    <h3 align="center">12 Month Membership (3 Months Free)</h3>
                </div>
                
                <form action="/charge?plan=yearly" method="POST">
                    {{ csrf_field() }}
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="pk_live_aZlhsimJsWybDP10BrMv7spB"
                        data-name="SmartArena"
                        data-description="12 Month Membership (3 Months Free)"
                        data-amount="17900"
                        data-label="Sign Me Up!">
                    </script>
                    <script>
                        // Hide default stripe button, be careful there if you
                        // have more than 1 button of that class
                        document.getElementsByClassName("stripe-button-el")[2].style.display = 'none';
                    </script>
                    <button type="submit" class="buy-btn">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
@endsection