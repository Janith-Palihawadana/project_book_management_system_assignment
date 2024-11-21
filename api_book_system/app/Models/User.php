<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'is_active',
        'role_id',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAuthors(array $all, bool $count): \Illuminate\Database\Eloquent\Collection|int|array
    {
        $all_author = User::query()
            ->select("users.*")
            ->where('users.role_id','=', 2);

        if(!empty($all['keyword'])){
            $all_author->where(function ($query) use ($all){
                $query->where('users.name', 'LIKE', '%' . $all['keyword'] . '%');
            });
        }

        if ($all['is_active'] === true || $all['is_active'] === false) {
            $all_author->where('users.is_active', $all['is_active']);
        }

        if ($count) {
            return $all_author->count();
        }
        $page_no = $all['page_no'];
        $page_size = $all['page_size'];
        $start_no = ($page_no - 1) * $page_size;

        return $all_author->orderBy('users.id', 'desc')
            ->offset($start_no)
            ->limit($page_size)
            ->get();
    }

}
