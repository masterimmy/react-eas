<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    const TYPE = [
        "SUBSCRIBER" => 1,
        "TRIAL" => 2
    ];
    const WEB_ACCESS = [
        "ENABLED" => 1,
        "DISABLED" => 0
    ];
    const APP_ACCESS = [
        "ENABLED" => 1,
        "DISABLED" => 0
    ];
    const TRIAL_DAYS = 28;

    const EXPIRE_REMINDER = [30, 15, 7, 3, 2, 1];

    const REMINDER_DAY_COUNT = 7;

    const SECRET = '9THT3FpioCSU7ZSC';

    public function checkExpiry(){
        $validTill = Carbon::parse($this->valid_till);
        $currentDate = Carbon::now();
        $daysDifference = $validTill->diffInDays($currentDate);
        return in_array(($daysDifference+1), SELF::EXPIRE_REMINDER);
    }

    public function configure()
    {
        config(['database.connections.mysql.database' => $this->tenancy_db_name,]);
        DB::purge('mysql');
        DB::reconnect('mysql');
        Schema::connection('mysql')->getConnection()->reconnect();
        return $this;
    }

    public function use()
    {
        app()->forgetInstance('mysql');
        app()->instance('mysql', $this);
        return $this;
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'tenant_name',
            'tenancy_db_email',
            'license_user_count',
            'valid_from',
            'valid_till',
            'color_code',
            'web_access',
            'tenant_logo',
            'is_fr_enabled',
            'app_access',
            'base_timezone',
            'tenant_type',
            'created_by',
            'tenant_contact_name',
            'tenant_contact_number',
            'final_activity_mail_sent',
            'created_at'
        ];
    }

    public function reseller()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}