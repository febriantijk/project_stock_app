<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class barangkeluar extends Model
{
    /**
     * Get the user that owns the barangkeluar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getstok(): BelongsTo
    {
        return $this->belongsTo(stok::class, 'barang_id', 'id');
    }
    /**
     * Get the user that owns the barangkeluar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getpelanggan(): BelongsTo
    {
        return $this->belongsTo(pelanggan::class, 'pelanggan_id', 'id');
    }

    /**
     * Get the user that owns the barangkeluar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getuser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
