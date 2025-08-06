<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'tax',
        'total'
    ];
    // In InvoiceItem.php
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
