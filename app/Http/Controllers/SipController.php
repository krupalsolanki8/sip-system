<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sip;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSipRequest;
use Yajra\DataTables\DataTables;
use App\Events\SipCreated;
use App\Events\SipCancelled;
use App\Events\InvoiceCancelled;

class SipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sips.index');
    }

    /**
     * Return SIPs as JSON for DataTables.
     */
    public function datatable(Request $request)
    {
        $query = Sip::where('user_id', Auth::id());
        return DataTables::of($query)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSipRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        
        $data['user_id'] = $user->id;
        $today = now()->toDateString();

        if ($today < $data['start_date'] || $today > $data['end_date']) {
            $data['status'] = 'inactive';
        } else {
            $data['status'] = 'active';
        }
        $sip = Sip::create($data);

        event(new SipCreated($user, $sip));
        
        return redirect()->route('sips.index')->with('success', 'SIP created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Cancel the specified SIP (set status to inactive).
     */
    public function cancel(Sip $sip)
    {
        $user = Auth::user();

        if ($sip->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        $sip->status = 'inactive';
        $sip->save();

        // Cancel all future pending invoices for this SIP and dispatch InvoiceCancelled event for each
        $now = now();
        $cancelledInvoices = $sip->invoices()
            ->where('status', 'pending')
            ->where('scheduled_date', '>', $now)
            ->get();
        foreach ($cancelledInvoices as $invoice) {
            $invoice->status = 'cancelled';
            $invoice->save();
            event(new InvoiceCancelled($sip->user, $invoice));
        }

        event(new SipCancelled($user, $sip));

        return response()->json([
            'status' => true,
            'message' => 'SIP cancelled successfully.' . ($cancelledInvoices->count() ? " {$cancelledInvoices->count()} pending invoice(s) cancelled." : ''),
        ]);
    }

}
