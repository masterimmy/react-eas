<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Inertia\Inertia;

class SupportController extends Controller
{
    public function index()
    {
        return inertia('Support/Index', [
            'tickets' => Ticket::orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }
}
