<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryBimbingan extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal', 'topik', 'hasil', 'tanggal2', 'jumlah'];
    protected $table = 'history_bimbingan';
    public $timestamps = false;
}
