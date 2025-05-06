<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_id');
    }
}
