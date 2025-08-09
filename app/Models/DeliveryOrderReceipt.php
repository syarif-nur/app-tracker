<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderReceipt extends Model
{
    protected $table = 'delivery_order_receipts';
    protected $guarded = [];

    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }
}
