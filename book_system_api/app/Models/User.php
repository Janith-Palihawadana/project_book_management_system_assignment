<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts =[
        'role_id' => 'int',
        'is_active' => 'bool',
        'created_user_id' => 'int',
        'updated_user_id' => 'int'
    ];

    protected $fillable = [
        'user_ref',
        'name',
        'email',
        'password',
        'role_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
    ];

    public static function getAuthors(array $all, bool $count): \Illuminate\Database\Eloquent\Collection|int|array
    {
        $all_author = User::query()
            ->select("users.*")
            ->where('users.role_id','=', 2)
            ->where('users,is_active', true);

           if(!empty($all['keyword'])){
               $all_author->where(function ($query) use ($all){
                   $query->where('users.name', 'LIKE', '%' . $all['keyword'] . '%');
               });
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
