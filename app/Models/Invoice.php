<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'tax_amount',
        'grand_total'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // In Invoice.php
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
