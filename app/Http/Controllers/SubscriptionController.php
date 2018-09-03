<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function get()
    {
        return view('subscriptions.choose');
    }

    public function charge(Request $request)
    {
        $stripe_token = $request->input('stripeToken');
        $plan = $request->input('plan');
        $user = Auth::user();
        $plan_id = '';

        switch ($plan) {
            case 'monthly':
                $plan_id = 'plan_DUoN0q61wkdkpz';
                break;
            case 'biyearly':
                $plan_id = 'plan_DUoNw4tMCZh9CS';
                break;
            case 'yearly':
                $plan_id = 'plan_DUoNcYplZL4bFj';
                break;
        }

        $user->newSubscription('main', $plan_id)->create($stripe_token, [
            'email' => $user->email
        ]);

        return redirect('/confirmation');
    }
}
