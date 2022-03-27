<?php
namespace App\Http\Controllers;

use App\BlogComment;
use Illuminate\Http\Request;
use View;


class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadmore(Request $request)
    {
        $id = $request->id;
        $proid = $request->proid;

        $comments = BlogComment::where('post_id', $proid)->where('id', '<', $id)->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        if (!$comments->isEmpty())
        {

            return View::make('front.blogmorecomment', compact('comments'))
                ->render();

        }
        else
        {
            $comments = NULL;
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $input = $request->all();
        $newcomment = new BlogComment;
        $input['comment'] = clean($request->comment);
        $input['post_id'] = $id;
        $newcomment->create($input);
        notify()->success(__('Comment added successfully !'));
        return back();

    }
}

