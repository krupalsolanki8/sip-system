<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sip;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSipRequest;
use App\Events\InvoiceCancelled;

class SipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sips = Sip::where('user_id', Auth::id())->get();
        return response()->json([
            'status' => true,
            'message' => 'SIPs fetched successfully.',
            'data' => $sips,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSipRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $sip = Sip::create($data);

        // Send SIP creation mail (queued, with try-catch)
        try {
            \Mail::to(Auth::user()->email)->queue(new \App\Mail\SipCreatedMail(Auth::user(), $sip));
        } catch (\Exception $e) {
            \Log::error('Failed to send SIP creation mail (API): ' . $e->getMessage());
        }

        return response()->json([
            'status' => true,
            'message' => 'SIP created successfully.',
            'data' => $sip,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sip = Sip::where('user_id', Auth::id())->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'SIP fetched successfully.',
            'data' => $sip,
        ]);
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

    public function cancel($id)
    {
        $sip = Sip::where('user_id', Auth::id())->find($id);
        if (!$sip) {
            return response()->json([
                'status' => false,
                'message' => 'No SIP found!.',
            ], 404);
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

        return response()->json([
            'status' => true,
            'message' => 'SIP cancelled successfully.' . ($cancelledInvoices->count() ? " {$cancelledInvoices->count()} pending invoice(s) cancelled." : ''),
            'data' => $sip,
        ]);
    }
}
