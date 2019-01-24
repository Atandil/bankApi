<?php
namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * Class CustomersController
 *
 * @package App\Http\Controllers
 */
class CustomersController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function add(Request $request)
    {
        try {
            $this->validate($request, Customer::$rules);
            $customer = Customer::create($request->all());

            return response()->json(array('customerId' => $customer->id), 200);

        } catch (\Exception $e) {
            return response(
                array('status' => $e->getMessage()),
                421
            );
        }

    }
}
