Route::get('/bill', [BillController::class, 'index']);


Route::get('/', function () {
    $customer_name = request('customer_name');
    $customer_type = request('customer_type');
    $consumption_kwh = request('consumption_kwh');
    return view('bill', compact('customer_name', 'customer_type', 'consumption_kwh'));
});
