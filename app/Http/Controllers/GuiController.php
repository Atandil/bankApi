<?php

namespace App\Http\Controllers;
use \App\Transaction;

use Closure;
use Illuminate\Support\Facades\Hash;


use Laravel\Lumen\Routing\Controller as BaseController;

class GuiController extends BaseController
{


    public function index()
    {

        return view('index');

    }

    public function json()
    {
        $transactions=Transaction::all();

        $out=collect($transactions)->map(function($x){ return  self::jsonArray($x); })->toArray();

        return response(

            $out,  count($out) ? 201 : 404
        );

    }

    protected static function jsonArray($transaction) {
        if (!is_object($transaction))
        {
            return array('status'=> $transaction ? $transaction : 'fail');
        } else {
            return array(
                 $transaction->id,
                 $transaction->customer->name,
                 $transaction->amount,
                 $transaction->date->format('d.m.Y')
            );
        }
    }
}
