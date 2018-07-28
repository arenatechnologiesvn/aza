<?php

namespace App;

//use Illuminate\Support\Facades\Auth;
use App\Dto\UserDto;
use App\Observers\ByUserObserver;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Plank\Mediable\Mediable;

//use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    // use HasApiTokens, Notifiable;
    use Notifiable;
    use Mediable;

//    virtual property
    protected $appends = ['full_name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'phone',
        'two_factor',
        'is_active',
        'avatar'
    ];

    public static function boot()
    {
        User::observe(new ByUserObserver());

        parent::boot();
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
//    protected $appends = [
//        'photo_url',
//    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }

    public function getFullNameAttribute () {
        return $this->first_name . ' ' . $this->last_name;
    }
    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function userDetail() {
        return $this->hasOne(UserDetail::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function detail($user)
    {
//        return self::with(['role.permissions' => function ($query) {
//            $query->where('parent_id', '0');
//        }, 'role.permissions.children' => function ($query) use ($user) {
//            $query->whereIn('id',
//                RolePermission::query()
//                    ->where('role_id', $user->role_id)
//                    ->get(['permission_id'])
//                    ->toArray());
//        }, 'role.permissions.children.children' => function ($query) use ($user) {
//            $query->whereIn('id',
//                RolePermission::query()
//                    ->where('role_id', $user->role_id)
//                    ->get(['permission_id'])
//                    ->toArray());
//        }])->find($user->id);
        return UserDto::toDto($user);
    }
}
