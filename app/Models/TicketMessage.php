<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TicketMessage extends Model
{
    use SoftDeletes;

    protected $fillable = ['ticket_id', 'message_from', 'sender_id', 'message', 'attachment'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->id)) {
                $ticket->id = (string) Str::uuid();
            }
        });
    }
}
