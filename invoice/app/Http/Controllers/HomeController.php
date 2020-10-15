<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('invoice.create');
    }

    public function info()
    {
        $params = [
            'user' => Auth::user()
        ];
        return view('account.info', $params);
    }

    public function password_change(Request $request)
    {
        if ($request->new_password) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'old_password' => ['required', 'string', 'max:255'],
                'new_password' => ['required', 'string', 'max:255'],
                'confirm_password' => ['required', 'same:new_password'],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'old_password' => ['required', 'string', 'max:255'],
            ]);
        }

        $user = Auth::user();
        if (!password_verify($request->old_password, $user->password)) {
            return back()->with('failed', 'Credential didn\'t Match.');
        }
        $user->name = $request->name;
        if ($request->new_password) {
            $user->password = bcrypt($request->new_password);
        }
        $user->save();
        return back()->with('success', 'Modified Successfully.');
    }

    public function customer(Invoice $invoice)
    {
        return view('invoice.customer', ['invoice' => $invoice]);
    }

    public function customer_store(Invoice $invoice, Request $request)
    {
        $invoice->crew_initial   = $request->crew_initial;
        $invoice->inspected_by  = $request->inspected_by;
        $invoice->customer_initial       = $request->customer_initial;
        $invoice->operation_details     = $request->operation_details;
        $invoice->comment_instruction   = $request->comment_instruction;

        $invoice->sign     = $request->sign;
        if (!$invoice->save()) {
            return back()->withInput()->with('failed', __('Invoice modification request failed!'));
        }
        return back()->with('success', 'Invoice Modified Successfully.');
    }
}
