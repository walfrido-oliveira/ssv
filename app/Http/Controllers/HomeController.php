<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use Illuminate\Support\Carbon;
use App\Models\Billing\Billing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Auth::logout();
        $user = auth()->user();

        if ($user->hasRole("Admin"))
        {
            $totalUsers = User::all()->count();
            $totalClients = Client::all()->count();
            $totalBudgets = Budget::all()->count();
            $amountBudgets = Budget::sum('amount');
            $totalOders = Order::all()->count();
            $months = [__('January'), __('Febuary'), __('March'),
                        __('April'), __('May'), __('June'), __('July'),
                        __('August'), __('September'), __('October'),
                        __('Novevember'), __('December')];
            $label = __('# of budgets');
            $totalBbudgetMonthTemp = Budget::all()
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('m');
            });

            $totalBbudgetMonth = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($totalBbudgetMonthTemp as $key => $value) {
                $totalBbudgetMonth[$key - 1] = $value->count();
            }

            return view('admin.home', compact('totalClients', 'totalUsers', 'totalBudgets', 'amountBudgets',
                                              'totalOders', 'months', 'label', 'totalBbudgetMonth'));
        }
        else {
            $totalBudgets = Budget::whereIn('client_id', User::getClientsId())->count();
            $totalOders = Order::whereIn('client_id', User::getClientsId())->count();
            $totalBillings = Billing::whereIn('client_id', User::getClientsId())->count();

            return view('user.home', compact('totalBudgets', 'totalOders', 'totalBillings'));
        }
    }
}
