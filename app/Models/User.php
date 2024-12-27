<?php

namespace App\Models;

use App\Casts\StatusCast;
use App\Casts\StatusIdCast;
use App\Interfaces\Mediaable;
use App\Interfaces\Statusable;
use App\Traits\HasMedia;
use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Mediaable, Statusable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, softDeletes, HasApiTokens, HasMedia, HasRoles, HasSearch, HasStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'family',
        'email',
        'password',
        'mobile',
        'status_id',
        'is_sejami',
        'is_private_investor',
        'bio',
        'type'
    ];

    protected $perPage = 20;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $with = ['status', 'userInfos.userInfoTitle', 'medias'];

    public static array $persianTypes = [
        'real' => 'حقیقی',
        'legal' => 'حقوقی'
    ];

    // ==============================================================================================================================================
    //
    //  Relations
    //
    // ==============================================================================================================================================

    public function userInfos(): HasMany
    {
        return $this->hasMany(UserInfoValue::class, 'user_id');
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Order::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // ==============================================================================================================================================
    //
    //  Scopes
    //
    // ==============================================================================================================================================


    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            return $query->whereRaw("CONCAT(name, ' ', family) LIKE ?", ["%{$search}%"])
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%")
                ->orWhereHas('userInfos', function ($query) use ($search) {
                    return $query->where('value', 'LIKE', "%$search%");
                });
        });
    }

    // ==============================================================================================================================================
    //
    //  Accessors
    //
    // ==============================================================================================================================================



    public function getInfo($title)
    {
        return $this->userInfos()->whereTitle($title)->first()?->value;
    }
    public function nationalId(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('national_id'));
    }

    public function privateInvestor(): Attribute
    {
        return Attribute::make(fn () => $this->is_private_investor ? 'خصوصی است' : 'خصوصی نیست');
    }

    public function economicCode(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('economic_code'));
    }

    public function managerName(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('manager_name'));
    }

    public function managerNationalId(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('manager_national_id'));
    }

    public function postalCode(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('postal_code'));
    }

    public function companyName(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('company_name'));
    }

    public function fatherName(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('father_name'));
    }

    public function tradingCode(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('trading_code'));
    }

    public function sheba(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('sheba'));
    }

    public function bankName(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('bank_name'));
    }

    public function accountType(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('account_type'));
    }

    public function accountNumber(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('account_number'));
    }

    public function serialNumber(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('serial_number'));
    }

    public function address(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('address'));
    }

    public function placeOfBirth(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('place_of_birth'));
    }

    public function placeOfIssue(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('place_of_issue'));
    }

    public function phoneNumber(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('phone_number'));
    }

    public function fax(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('fax'));
    }

    public function birthDate(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('birth_date'));
    }

    public function getShebaExceptAyandehBank(): Attribute
    {
        return Attribute::make(fn () => $this->bank_name != 'بانک آینده' ? $this->sheba : $this->accountNumber);
    }

    public function sejamStatus(): Attribute
    {
        return Attribute::make(fn () => $this->is_sejami ? 'سجامی' : 'ندارد');
    }

    public function persianStatus(): Attribute
    {
        return Attribute::make(fn () => $this->status?->persianTitle);
    }

    public function persianType(): Attribute
    {
        return Attribute::make(fn () => self::$persianTypes[$this->type]);
    }

    public function mediasUrl(): Attribute
    {
        return Attribute::make(fn () => $this->medias?->url);
    }

    public function userName(): Attribute
    {
        return Attribute::make(fn () => $this->type == 'real' ? $this->name . ' ' . $this->family : $this->company_name);
    }

    public function gender(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('gender'));
    }

    public function genderName(): Attribute
    {
        return Attribute::make(fn () => $this->gender == 'male' ? 'مرد' : 'زن');
    }

    public function registerCode(): Attribute
    {
        return Attribute::make(fn () => $this->getInfo('register_code'));
    }

}
