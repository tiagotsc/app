<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['origin','destiny'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet_log';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))->format('d/m/y h:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))->format('d/m/y h:i:s');
    }

    public function origin()
    {
        return $this->belongsTo(User::class,'user_id', 'id')->select('id','users.name');
    }

    public function destiny()
    {
        return $this->belongsTo(User::class,'user_id_transfer', 'id')->select('id','users.name');
    }
}
