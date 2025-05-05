<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use SoftDeletes;

    CONST TICKET_NAME = "EAS";
    CONST PADDING_LENGTH = 4;
    CONST PADDING_STR = "0";

    protected $fillable = ['title', 'tenant_id', 'ticket_status_id'];

    public $incrementing = false;
    protected $keyType = 'string';

    public function getTicketDisplayIdAttribute($value)
    {
        return self::TICKET_NAME.str_pad($value, self::PADDING_LENGTH, self::PADDING_STR, STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->id)) {
                $ticket->id = (string) Str::uuid();
            }

            $lastTicket = static::withTrashed()
                ->where('tenant_id', $ticket->tenant_id)
                ->orderBy('ticket_display_id', 'desc')
                ->first();

            $ticket->ticket_display_id = $lastTicket ? $lastTicket->ticket_display_id + 1 : 1;
        });
    }

}
