<?php

namespace App\Http\Controllers\Admin;

use App\Cabang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('payment-access'), 403);

        $payments = Payment::get();
        return view('admin.payment.index', compact('payments'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('payment-create'), 403);

        $payment = new Payment();
        $cabangs = Cabang::get();
        return view('admin.payment.create', compact('payment', 'cabangs'));
    }


    public function store(StorePaymentRequest $request)
    {
        abort_unless(\Gate::allows('payment-create'), 403);

        Payment::create($request->all());

        return redirect()->route('admin.payments.index')->with('success', 'Payment has been added');
    }

    public function show(Payment $payment)
    {
        return response()->json([
            'payment' => $payment
        ], 200);
    }

    public function edit(Payment $payment)
    {
        abort_unless(\Gate::allows('payment-edit'), 403);
        $cabangs = Cabang::get();

        return view('admin.payment.edit', compact('payment', 'cabangs'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        abort_unless(\Gate::allows('payment-edit'), 403);

        $payment->update($request->all());

        return redirect()->route('admin.payments.index')->with('success', 'Payment has been updated');
    }

    public function destroy(Payment $payment)
    {
        abort_unless(\Gate::allows('payment-delete'), 403);

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment has been deleted');
    }
}
