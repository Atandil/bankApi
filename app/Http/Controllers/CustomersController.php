<?php
namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CustomersController extends Controller {

    public function add(Request $request)
    {
        $this->validate($request, Customer::$rules);
        $customer=Customer::create($request->all());
        return response()->json(array('customerId' => $customer->id), 200);

    }

}
