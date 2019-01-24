<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    /**
     * @var array
     */
    protected $fillable = ["date", "amount", "customer_id"];

    /**
     * @var array
     */
    protected $dates = ["date"];

    /**
     * @var array
     */
    public static $rules = [
        "customer_id" => "required,numeric",
        "date" => "date",
        "amount" => "numeric"
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo("App\Customer");
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return 'd.m.Y';
    }

    /**
     * @var array
     */
    protected $hidden = ['user_id'];

}
