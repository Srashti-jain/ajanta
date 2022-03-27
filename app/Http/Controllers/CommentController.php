<?php
namespace App\Http\Controllers;

use App\Comment;
use App\Subcomment;
use Illuminate\Http\Request;
use View;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:100',
            'email' => 'required|email|max:250',
            'comment' => 'required|min:5|max:2000',
        ));

        $comment = new Comment();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = clean($request->comment);
        $comment->approved = 1;
        $comment->pro_id =  $request->simple_product ? 0 : $request->id;
        $comment->simple_pro_id =  $request->simple_product ?? NULL;

       $comment->save();

       notify()->success(__('Comment has been posted !'));

       return back();

    }

    public function loadmore(Request $request)
    {

        $output = '';
        $id = $request->id;
        $proid = $request->proid;

        if($request->simpleproduct){

            $type = 'simple';

            $comments = Comment::where('simple_pro_id', $proid)->where('id', '<', $id)->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        }else{

            $type = 'variant';

            $comments = Comment::where('pro_id', $proid)->where('id', '<', $id)->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
        }
        

        if (count($comments)) {
            return response()->json(['cururl' => View::make('front.loadmorecomments', compact('comments','proid','type'))->render()]);
        }else{
            return response()->json(__("No comments found !"));
        }

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $this->validate($request, array(
            'comment' => 'required',
        ));

        $comment->comment = clean($request->comment);
        $comment->save();

        Session::flash('success', __('Comment updated successfully'));
        return redirect()
            ->route('posts.show', $comment
                    ->post
                    ->id);
        }

        public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        Session::flash('success', __('Comment deleted'));
        $post_id = $comment
            ->post->id;
        return redirect()
            ->route('posts.show', $post_id);
    }

    public function ajex_submit(Request $request)
    {

        $comment = new Subcomment();
        $comment->comment_id = $request->id;
        $comment->comment = clean($request->comment);
        $comment->approved = 1;
        $check = $comment->save();

        $arr = array(
            'success' => __('Something goes to wrong. Please try again lator'),
            'status' => false,
        );
        if ($check) {
            $arr = array(
                'success' => __('Successfully submit form using ajax'),
                'status' => true,
                'msg' => $request->comment,
            );

        }

        return Response()
            ->json($arr);

    }

}
