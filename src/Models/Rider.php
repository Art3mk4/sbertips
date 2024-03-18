<?php

namespace SushiMarket\Sbertips\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTips;

class Rider extends Model
{

    protected $table = 'riders';

    protected $fillable = [
        "id",
        "shift_status",
        "city_id",
        "shop_id",
        "displayname",
        "online",
        "name",
        "famil",
        "otchestvo",
        "login",
        "password",
        "online_start",
        "online_end",
        "CoordinateX",
        "CoordinateY",
        "last_time_coord",
        "firebase_token",
        "token",
        "inn",
        "app_version",
        "shift_number",
        "routeType",
        "routeLatitude",
        "routeLongitude",
        "routeTypeId",
        "routeType",
        "bearer_token",
        "phone_dop2",
        "phone_dop3",
        "phone_dop4",
        "sex",
        "phone",
        "phone_model",
        "phone_os",
        "phone_os_version",
        "push_notification",
        "shift_id",
        "location_latitude",
        "location_longitude",
        "location_time",
        "photo_check",
        "corporateSim",
        "birthday_d",
        "birthday_m",
        "birthday_y",
        "country",
        "callToOktell",
        "self_employed",
        "not_auto_delete",
        'pasport_number',
        'pasport_date',
        'pasport_address_reg',
        'self_employed_reg_number',
        'self_employed_reg_date',
        'pasport_dep_code',
        'pasport_issued',
        'is_valid_docs_self_employed'
    ];

    /**
     * @return HasOne
     */
    public function tip()
    {
        return $this->hasOne(RegisterTip::class);
    }
}
