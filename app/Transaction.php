<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    protected $fillable = ["date", "ammount", "customer_id"];

    protected $dates = ["date"];

    public static $rules = [
        "customer_id" => "required,numeric",
        "date" => "date",
        "ammount" => "numeric"
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo("App\Customer");
    }


}
