<?php

namespace SushiMarket\Sbertips\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SushiMarket\Sbertips\Services\SbertipsService\ModelFactory;

class RiderTip extends Model
{

    protected $table = 'rider_tips';

    protected $fillable = [
        "id",
        "uuid",
        "access_token",
        "courier_id",
        "qrcode_id"
    ];

    /**
     * @return BelongsTo
     */
    public function rider()
    {
        return $this->belongsTo(ModelFactory::getRiderModel()::class, 'courier_id');
    }
}
