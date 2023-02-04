<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 
        'factoring_id', 
        'load_id', 
        'invoice_number', 
        'batch_id', 
        'total_amount', 
        'total_balance',
        'total_w_factoring',
        'factoring_fee',
        'include_factoring',
        'date',
        'due_date',
        'paid_date', 
        'is_deleted', 
        'status'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the load planner associated with the this invoice.
     */
    public function loadPlanner(){
        return $this->belongsTo('App\Models\LoadPlanner', 'load_id');
    }

    /**
     * Get the customer associated with this invoice.
     */
    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    /**
     * Get the factoring company associated with this invoice.
     */
    public function factoring(){
        return $this->belongsTo('App\Models\FactoringCompany', 'factoring_id');
    }

    /**
     * Get the batch associated with this invoice.
     */
    public function batch(){
        return $this->belongsTo('App\Models\InvoiceBatch', 'batch_id');
    }
}