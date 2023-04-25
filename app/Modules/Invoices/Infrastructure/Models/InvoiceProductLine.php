<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProductLine extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public function product(){
        return $this->belongsTo(product::class, 'product_id','id');
    }
}
