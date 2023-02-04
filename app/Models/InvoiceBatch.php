<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceBatch extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_batches';

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
    protected $fillable = ['batch_number', 'file_path', 'created_by'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the invoices that belongs to this model.
     */
    public function invoices(){
        return $this->hasMany('App\Models\Invoice', 'batch_id');
    }

    /**
     * Get the invoices that belongs to this model.
     */
    public function downloads(){
        return $this->hasMany('App\Models\InvoiceBatchDownload', 'batch_id');
    }
}