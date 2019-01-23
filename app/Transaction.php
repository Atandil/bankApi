<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    protected $fillable = ["date", "amount", "customer_id"];

    protected $dates = ["date"];

    public static $rules = [
        "customer_id" => "required,numeric",
        "date" => "date",
        "amount" => "numeric"
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo("App\Customer");
    }

    public function getDateFormat()
    {
        return 'd.m.Y';
    }

    protected $hidden = ['user_id'];

}
