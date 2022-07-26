<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
     * Form: Log a new transaction
     */
    public function create(Account $account, Category $category)
    {
        $sub_categories = $category->subCategories()->get();
        return view('transaction.create', [
            'account' => $account,
            'category' => $category,
            'sub_categories' => $sub_categories
        ]);
    }
    /**
     * Log new transaction
     */
    public function store()
    {
        $data = request()->validate([
            'transaction_amount' => ['required', 'integer'],
            'account_id' => ['required', 'exists:accounts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'], //need to check if sub category exist for only that category also
            'third_party' => ['required', 'string', 'max:50'],
            'transaction_description' => ['required', 'max:100']
        ]);
        $acc_id = $data['account_id'];
        $sub_cat = $data['sub_category_id'];
        $cat = $data['category_id'];
        auth()->user()->accounts()->findOrFail($acc_id);
        Category::findorFail($cat)->subCategories()->findorFail($sub_cat);
        // dd($data['account_id']);

        Transaction::create($data);
        return (redirect()->route('account.show', $acc_id)->with('success', "Transaction logged successfully!"));
    }
}
