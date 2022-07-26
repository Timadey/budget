<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Category;
use App\Models\SubCategory;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the current list of accounts
     */
    public function index()
    {
        $accounts = auth()->user()->accounts()->get();

        $last_update = [];

        foreach ($accounts as $account) {
            $last_updated = new \Datetime ($account->transactions()->get()->first()->updated_at ?? null);//->last()->updated_at);
            $now = new \Datetime (now());
            $interval = $now->diff($last_updated);
            $last_updated_hm = $interval->format('%d'). " Day(s) ".$interval->format('%h'). " hour(s) ".$interval->format('%i')." min ago";
            $account->updated_at = $last_updated;
            $last_update ["$account->updated_at"] = $last_updated_hm;

            $account->transaction_count = $account->transactions()->count();
        }
        return view('account.index', [
            'accounts' => $accounts,
            'last_updated' => $last_update
        ]);
    }

    /**
     * Form: Create new account
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store new account
     */
    public function store()
    {
        $data = request()->validate([
            "account_name" => ["required", "min:10", "max:30"],
            "account_description" => ["required", "min:10", "max:200"]
        ]);
        auth()->user()->accounts()->create($data);

        return redirect('/account');
        
    }

    /**
     * show detail view of a particualar account
     */
    public function show(Account $account)
    {
        $transactions = $account->transactions()->get();
        $totalIncome = 0;
        $totalExpense = 0;
        $netProfit = 0;
        foreach ($transactions as $trans)
        {
            $sub_cat = SubCategory::find($trans['sub_category_id']);
            $cat = Category::find($trans['category_id']);
            $trans->category = $cat;
            $trans->sub_category = $sub_cat;
            $trans->color = $trans->category_id === "1"? 'success' : 'danger';

            if ($trans->category_id == "1")
                $totalIncome += $trans->transaction_amount;
            else
                $totalExpense += $trans->transaction_amount;
        }
                    // dd($transactions);

        $netProfit = $totalIncome - $totalExpense;
        // dd($totalIncome, $totalExpense, $netProfit);
        $categories = (Category::all());
        return view ('account.show', [
            'account' => $account,
            'categories' => $categories,
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit
        ]);
    }

    /**
     * Form: Edit an account
     */
    public function edit (Account $account)
    {
        return view('account.edit', [
            'account' => $account
        ]);
    }
    /**
     * Edit an account
     */
    public function update(Account $account)
    {
        
    }
}
