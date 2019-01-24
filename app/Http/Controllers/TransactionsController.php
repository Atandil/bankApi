<?php

namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;
use App\Transaction;


class TransactionsController extends Controller {

    public function get($customerId,$transactionId)
    {
        try {
            $transaction = Transaction::where('customer_id',$customerId)->findOrFail($transactionId);
            $out['transactionId'] = $transaction->id;
            $out['amount'] = $transaction->amount;
            $out['date'] = $transaction->date->format('d.m.Y');;
        } catch (\Exception $e) {
            $transaction = null;
            $out=null;
            $statusCode = 404;
        }
        return response(
            $out, $statusCode ?? 201
        );
    }

    public function add(Request $request)
    {

        try {
            $this->validate(
                $request, [
                    'customerId' => 'required',
                    'amount' => 'required|numeric'
                ]
            );

            Customer::findOrFail($request->input('customerId'));

            $data['customer_id']=$request->input('customerId');
            $data['date']=date('Y-m-d');
            $data['amount']=$request->input('amount');

            $transaction=Transaction::create($data);
            $statusCode = 200;
        } catch(\Exception $e) {
            $transaction = $e->getMessage();
            $statusCode = 422;
        }

        return response()->json(self::jsonArray($transaction), $statusCode);
    }

    public function updateAmount(Request $request, $transactionId)
    {
        try {
            $this->validate(
                $request, [
                    'amount' => 'required|numeric'
                ]
            );
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->update($request->only('amount'));
        } catch(\Exception $e) {
            $transaction = $transaction = $e->getMessage();
            $statusCode = 404;
        }
        return response(
            self::jsonArray($transaction), $statusCode ?? 200
        );
    }

    public function remove($transactionId)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->delete();
        } catch(\Exception $e) {
            $transaction = null;
            $statusCode = 404;
        }
        return response(
                ["status" => $transaction ? "success" : "fail"]
            , $statusCode ?? 200
        );
    }



    public function getFilter(Request $request)
    {

        try {
                $transactions = Transaction::when($request->has('customerId'), function ($query) use ($request) {
                        return $query->where('customer_id',$request->input('customerId'));
                    })
                    ->when($request->has('amount'), function ($query) use ($request) {
                        return $query->whereAmount($request->input('amount'));
                    })
                    ->when($request->has('date'), function ($query) use ($request) {
                        return $query->where('date',$request->input('date'));
                    })
                    ->when($request->has('offset'), function ($query) use ($request) {
                        return $query->offset($request->input('offset'));
                    })
                    ->when($request->has('limit'), function ($query) use ($request) {
                        return $query->limit($request->input('limit'));
                    })
                    ->get();

            $out=collect($transactions)->map(function($x){ return  self::jsonArray($x); })->toArray();

            return response(

                $out,  count($out) ? 201 : 404
            );

        } catch (\Exception $e) {
            return response(
                array('status'=>$e->getMessage()),  404
            );
        }

    }

    protected static function jsonArray($transaction) {
        if (!is_object($transaction))
        {
            return array('status'=> $transaction ? $transaction : 'fail');
        } else {
            return array(
                'transactionId' => $transaction->id,
                'customerId'    => $transaction->customer_id,
                'amount'        => $transaction->amount,
                'date'          => $transaction->date->format('d.m.Y')
            );
        }
    }

}
