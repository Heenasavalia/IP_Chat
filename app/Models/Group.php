<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable=[
        'group_name',
        'members',
        'group_admin',
        'type',
    ];

    protected $appends=['group_create_date'];
    public function getGroupCreateDateAttribute(){
        return date('d-m-Y',strtotime($this->created_at));
    }
}
