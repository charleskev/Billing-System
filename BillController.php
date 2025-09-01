<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

class BillController extends Controller
{
    public function index(Request $request)
    {
        
        $customerName = $request->query('customer_name', 'Charles Kevin Sevilla');
        $customerType = $request->query('customer_type', 'Lifeline'); // lifeline, regular household, commercial
        $consumptionKwh = $request->query('consumption_kwh', 500);

        $rates = [
            'Lifeline' => ['rate_per_kwh' => 5.00, 'fixed_charge' => 0, 'discount' => 0.20],
            'Regular Household' => ['rate_per_kwh' => 9.50, 'fixed_charge' => 50, 'discount' => 0],
            'Commercial' => ['rate_per_kwh' => 12.00, 'fixed_charge' => 200, 'discount' => 0.05],
        ];

        if (!isset($rates[$customerType])) {
            return response()->json(['error' => 'Invalid customer type'], 400);
        }

        $ratePerKwh = $rates[$customerType]['rate_per_kwh'];
        $fixedCharge = $rates[$customerType]['fixed_charge'];
        $discountRate = $rates[$customerType]['discount'];

        $baseBill = $consumptionKwh * $ratePerKwh;
        $discountAmount = $baseBill * $discountRate;
        $totalBill = $baseBill + $fixedCharge - $discountAmount;

        $baseBillFormatted = number_format($baseBill, 2);
        $totalBillFormatted = number_format($totalBill, 2);

        return response()->json([
            'customer_name' => $customerName,
            'customer_type' => $customerType,
            'consumption_kwh' => $consumptionKwh,
            'base_bill' => $baseBillFormatted,
            'total_bill' => $totalBillFormatted,
            'status' => 'success'
        ]);
    }

    public function store(Request $request)
    {
        $customerName = "Charles Kevin Sevilla";
        return response()->json([
            'customername' => $customerName,
            'status' => 'success'
        ], 201);
    }
}
