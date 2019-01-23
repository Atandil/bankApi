<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $fillable = ["name", "cnp"];

    protected $dates = [];

    public static $rules = [
        "name" => "required|min:3",
    ];

    public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany("App\Transaction");
    }


}
