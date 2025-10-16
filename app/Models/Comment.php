<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //use	HasFactory;	
    protected	$fillable	=	[	
        'news_id',	
        'title',	
        'content',	
        'author_id',	
];	
public	function	news()	
{	
    return	$this->belongsTo(News::class);	
}	
public	function	author()	
{	
    return	$this->belongsTo(User::class,	'author_id');	
}
}
