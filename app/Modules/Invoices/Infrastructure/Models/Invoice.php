<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';

    public function company(){
        return $this->belongsTo(Company::class, 'company_id','id');
    }
    public function invice_products(){
        return $this->hasMany(InvoiceProductLine::class, 'invoice_id','id');
    }
}
