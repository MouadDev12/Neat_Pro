<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::withCount('orders')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('crm.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load('orders', 'transactions');
        return view('crm.show', compact('customer'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers',
            'phone'   => 'nullable|string',
            'company' => 'nullable|string',
            'country' => 'nullable|string',
            'status'  => 'required|in:active,inactive,lead',
        ]);
        Customer::create($data);
        return back()->with('success', 'Customer created.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Customer deleted.');
    }
}
