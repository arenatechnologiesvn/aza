<?php

namespace App;

//use Illuminate\Support\Facades\Auth;
use App\Dto\UserDto;
use App\Observers\ByUserObserver;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

//use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;
    use Mediable;

//    virtual property
    protected $appends = ['full_name'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean'
    ];

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
        'is_verified',
        'address'
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

    public function getDateFormat()
    {
        return 'U';
    }

    public function getFullNameAttribute () {
        return $this->last_name . ' ' . $this->first_name;
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

    public function avatar() {
        return $this->morphToMany('Plank\Mediable\Media', 'mediable','mediables', 'mediable_id')
        ->withPivot('mediable_type', 'tag')
        ->select([
            'id',
            \DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
        ])
        ->where([
            ['mediable_type', '=', 'App\User'],
            ['tag', '=', 'user']
        ]);
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
        return UserDto::toDto($user);
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
}
