<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id','bank_id','amount','status','paid_at','transfer_ref','proof_path'];
    const STATUS = ['PENDING','AWAITING_CONFIRMATION','PAID','FAILED'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function bank(){ return $this->belongsTo(Bank::class); }
}
