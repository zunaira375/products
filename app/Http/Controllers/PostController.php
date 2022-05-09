<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function addPost()
    {
        $post = new Post();
        $post->title = 'second post title';
        $post->body = 'second post body';
        $post->save();
        return "post has been created successfully";
    }

    public function addComment($id)
    {
        $post = Post::find($id);
        $comment = new Comment();
        $comment->comment = 'this is my second comment';
        $post->comments()->save($comment);
        return "comment has been added";
    }

    public function getCommentsByPost($id)
    {
        $comments = Post::find($id)->comments;
        return $comments;
    }
}
