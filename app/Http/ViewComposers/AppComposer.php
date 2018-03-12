<?php namespace App\Http\ViewComposers;
 
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Human;

class AppComposer {

    protected $isLoggedIn;
    protected $user;


    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->isLoggedIn = Auth::check();
        $this->user = Auth::user();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('isLoggedIn', $this->isLoggedIn);
        $view->with('user', $this->user);
    }

}