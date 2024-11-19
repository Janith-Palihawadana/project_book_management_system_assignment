<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $casts =[
        'author_id' => 'int',
        'is_active' => 'bool',
        'created_user_id' => 'int',
        'updated_user_id' => 'int'
    ];

    protected $fillable = [
        'book_ref',
        'title',
        'description',
        'cover_image',
        'is_active'
    ];

    public static function getAllBooks(array $all, $count): \Illuminate\Database\Eloquent\Collection|int|array
    {

        $allBooks = Books::query()
            ->select('books.*','users.name As author_name')
            ->join('users','books.author_id','=','users.id')
            ->where('books.is_active',true)
            ->where('users.is_active',true);

        return self::extracted($all, $allBooks, $count);
    }

    public static function getAllBooksByAuthor(array $all, $count): \Illuminate\Database\Eloquent\Collection|array|int
    {
        $allBooks = Books::query()
            ->select('books.*','users.name As author_name')
            ->join('users','books.author_id','=','users.id')
            ->where('books.is_active',true)
            ->where('users.is_active',true)
            ->where('users.user_ref',$all['author_ref']);

        return self::extracted($all, $allBooks, $count);
    }

    public static function extracted(array $all, $allBooks, $count): int|array|\Illuminate\Database\Eloquent\Collection
    {
        if (!empty($all['keyword'])) {
            $allBooks->where(function ($query) use ($all) {
                $query->where('users.name', 'LIKE', '%' . $all['keyword'] . '%')
                    ->where('books.title', 'LIKE', '%' . $all['keyword'] . '%');
            });
        }

        if ($count) {
            return $allBooks->count();
        }
        $page_no = $all['page_no'];
        $page_size = $all['page_size'];
        $start_no = ($page_no - 1) * $page_size;

        return $allBooks->orderBy('books.id', 'desc')
            ->offset($start_no)
            ->limit($page_size)
            ->get();
    }

}
