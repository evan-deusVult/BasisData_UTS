<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'user_id',
        'code',
        'status',
        'total_amount'
    ];
    const STATUS = ['UNPAID','PAID','CANCELLED','EXPIRED'];

    public function student(){ return $this->belongsTo(Student::class); }
    public function lecturer(){ return $this->belongsTo(Lecturer::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function items(){ return $this->hasMany(OrderItem::class); }
    public function orderItems(){ return $this->hasMany(OrderItem::class); }
    public function payment(){ return $this->hasOne(Payment::class); }
    public function tickets(){ return $this->hasMany(Ticket::class); }

}

