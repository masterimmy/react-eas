<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    const IS_ACTIVE    = [
        'active'   => 1,
        'inactive' => 0,
    ];
    const ACCESS = [
        'access'  => 1,
        'denined' => 0,
    ];
    const KIOSK_MODULE_NAME      = 'kiosk';
    const TRACKER_KM_MODULE_NAME = 'tracker-km';
    public $timestamps           = false;

    // get related feature list
    public function features()
    {
        return $this->belongsToMany(Feature::class)->withPivot(['value', 'type', 'access_to', 'is_active']);
    }
}
