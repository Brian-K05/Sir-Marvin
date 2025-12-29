<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'client_name',
        'client_email',
        'document_path',
        'instructions',
        'deadline',
        'status',
        'initial_payment_status',
        'final_payment_status',
        'corrected_file_path',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function initialPayment()
    {
        return $this->hasOne(Payment::class)->where('phase', 'initial');
    }

    public function finalPayment()
    {
        return $this->hasOne(Payment::class)->where('phase', 'final');
    }

    public function canDownload()
    {
        return $this->final_payment_status === 'approved' && $this->corrected_file_path !== null;
    }

    public function scopePendingInitial($query)
    {
        return $query->where('status', 'pending_initial');
    }

    public function scopeAwaitingFinal($query)
    {
        return $query->where('status', 'awaiting_final');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
