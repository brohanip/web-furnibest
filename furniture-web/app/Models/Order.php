<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'notes',
        'payment_method',
        'bank_account_id',
        'transfer_note',
        'payment_type',
        'dp_percent',
        'subtotal',
        'amount_to_pay',
        'remaining_amount',
        'status',
        'snap_token',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'midtrans_transaction_status',
        'paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'amount_to_pay' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function isTransfer(): bool
    {
        return $this->payment_method === 'transfer';
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return $this->payment_method === 'transfer' ? 'Transfer bank' : 'Bayar online';
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function belongsToUser(?int $userId): bool
    {
        return $this->user_id === null || $this->user_id === $userId;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isDp(): bool
    {
        return $this->payment_type === 'dp';
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->subtotal, 0, ',', '.');
    }

    public function getFormattedAmountToPayAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount_to_pay, 0, ',', '.');
    }

    public function getFormattedRemainingAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->remaining_amount, 0, ',', '.');
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        if ($this->payment_type === 'dp' && $this->dp_percent) {
            return 'DP ' . $this->dp_percent . '%';
        }

        return 'Bayar penuh';
    }

    public static function generateOrderNumber(): string
    {
        do {
            $number = 'FB-' . now()->format('ymd') . '-' . strtoupper(substr(uniqid(), -6));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }
}
