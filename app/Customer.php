<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    /**
     * @var array
     */
    protected $fillable = ["name", "cnp"];

    /**
     * @var array
     */
    protected $dates = [];

    /**
     * @var array
     */
    public static $rules = [
        "name" => "required|min:3",
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany("App\Transaction");
    }


}
