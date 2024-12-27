<?php

namespace App\Models;

use App\Enums\Statuses;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table ='statuses';
    protected $fillable = [
        'model',
        'title'
    ];

    public static array $persianStatuses = [
        'active' => 'فعال',
        'inactive' => 'غیر فعال',
        'answered'=>'پاسخ داده شده',
        'pending' => 'در حالت انتظار',
        'unknown'=>'ناشناخته',
        'awaiting_agent_approval'=>'در انتظار تایید عامل',
        'awaiting_financial_approval'=>'در انتظار تایید مالی',
        'awaiting_symbol_approval'=>'در انتظار تایید نماد',
        'rejection_plan'=>'رد طرح',
        'start_fundraising'=>'شروع جمع اوری وجوه',
        'fundraising_succeed'=>'موفقیت جمع اوری وجوه',
        'cleared'=>'تسویه شده',
        'fundraising_failed'=>'عدم جمع اوری وجوه',
        'returned' => 'برگشت خورده',
        'cancelled' => 'لغو شده',
        'rejected' => 'تایید نشده',
        'paid' => 'برداخت شده',
        'stopped'=>'متوقف شد',
        'closed'=>'بسته شده',
    ];

    public function scopeWhereTitle($query, $title)
    {
        return $query->where('title', $title);
    }
    public function persianTitle():Attribute
    {
        return Attribute::make(function (){
            return self::$persianStatuses[$this->title];
        });
    }

    public function scopeWhereTitleIn($query, $statuses)
    {
        return $query->whereIn('title', $statuses);
    }

    public function scopeWhereType($query, $type)
    {
        return $query->where('model', $type);
    }
}
