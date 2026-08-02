<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopRequest extends Model
{
    protected $fillable = [
        'shop_name',
        'shop_slug',
        'phone',
        'address',
        'currency',
        'about_text',
        'banner_image',
        'user_name',
        'user_email',
        'user_password',
        'status',
        'admin_note',
        'package_id',
    ];

    protected $hidden = [
        'user_password',
    ];

    // رابطه با پکیج
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // هلپرها
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}