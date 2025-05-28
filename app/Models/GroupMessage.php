<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;
    protected $fillable=[
        'group_id',
        'user_id',
        'message',
        'like',
        'is_delete',
    ];

    protected $appends=['message_create_date','message_create_time'];
    public function getMessageCreateDateAttribute(){
        return date('d-m-Y',strtotime($this->created_at));
    }
    public function getMessageCreateTimeAttribute(){
        return date('g:i A',strtotime($this->created_at));
    }
}
