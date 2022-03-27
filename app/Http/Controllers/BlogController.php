<?php
namespace App\Http\Controllers;

use App\Blog;
use App\BlogComment;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('blog.view'),403,__(__('User does not have the right permissions.')));

        $blogs = Blog::all();
        return view('admin.blog.index', compact('blogs'));
    }

    public function search(Request $request)
    {

        
        $search = $request->search;
        $result = array();
        $query = Blog::where('heading', 'LIKE', '%' . $search . '%')->get();
        $infourl = url('images');
        $imageurl = url('images/blog');
        if (count($query) > 0) {

            foreach ($query as $key => $q) {
                $result[] = ['slug' => $q->slug, 'img' => $imageurl . '/' . $q->image, 'value' => $q->heading];
            }

        } else {

            $result[] = ['slug' => '#', 'img' => $infourl . '/info.png', 'value' => 'No Result found'];

        }

        return response()->json($result);

    }

    public function frontindex()
    {
        require_once 'price.php';
        $blogs = Blog::orderBy('id', 'DESC')->where('status', '1')
            ->paginate(5);

        $popularpost = collect();

        $allposts = Blog::orderByUniqueViews()->get();

        foreach ($allposts as $key => $post) {

            if (views($post)->unique()
                ->count() > 500) {

                $popularpost->push($post);

            }

        }

        return view('front.blogindex', compact('blogs', 'conversion_rate', 'popularpost'));

    }

    public function show($slug)
    {
        require_once 'price.php';

        $value = Blog::where('slug', '=', $slug)->where('status', '=', '1')->first();

        

        $popularpost = collect();

        $allposts = Blog::orderByUniqueViews()->get();

        foreach ($allposts as $key => $post) {

            if (views($post)->unique()->count() > 500) {

                $popularpost->push($post);

            }

        }

        if (isset($value)) {

            views($value)->record();

            return view('front.blog', compact('value', 'conversion_rate', 'popularpost'));

        } else {
            notify()->error(__('Blog post not found or not active'));
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('blog.create'),403,__('User does not have the right permissions.'));
        return view("admin.blog.add");
    }

    public function loadcommentsOneditpost(Request $request, $id)
    {

        $post = Blog::findorfail($id);

        $comments = $post->comments;

        if ($request->ajax()) {
            return DataTables::of($comments)->addIndexColumn()->addColumn('comment', function ($row) {
                $html = '';
                $html .= str_limit(strip_tags($row->comment), 100);
                if (strlen(strip_tags($row->comment)) > 100) {
                    $html .= '...';
                }

                return $html;
            })->editColumn('action', 'admin.blog.commentaction')
                ->rawColumns(['comment', 'action'])
                ->make(true);
        }

    }

    public function deletecomment($id)
    {
        $comment = BlogComment::find($id);

        if (isset($comment)) {
            $comment->delete();
            return back()
                ->with('deleted', __('Comment deleted successfully !'));
        } else {
            return back()
                ->with('warning', __('Comment not found !'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('blog.create'),403,__('User does not have the right permissions.'));

        $request->validate([

            "heading" => "required", 'user' => 'required|not_in:0',

            'image' => 'required | max:1000'], [

            "heading.required" => __("Slider heading is required"), "user.required" => __("User name is required"),

        ]);

        $blog = new Blog;

        $input = array_filter($request->all());

        $input['des'] = clean($request->des);

        $input['slug'] = Str::slug($request->heading, '-');

        if ($request->image != null) {

            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for blog')
                ]);

            }

            $input['image'] = $request->image;

        }

        $blog->create($input);

        return back()->with("added", __("Blog has been created !"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('blog.edit'),403,__('User does not have the right permissions.'));

        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('blog.edit'),403,__('User does not have the right permissions.'));

        $slider = Blog::findOrFail($id);
        $input = array_filter($request->all());

        if ($request->image != null) {

            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for blog')
                ]);

            }

            $input['image'] = $request->image;

        }

        $input['des'] = clean($request->des);
        $input['slug'] = Str::slug($request->heading, '-');

        $slider->update($input);

        return redirect('admin/blog')->with('updated', __('Blog post has been updated !'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('blog.delete'),403,__('User does not have the right permissions.'));

        $cat = Blog::find($id);
        $value = $cat->delete();
        
        if ($value) {
            session()->flash("deleted", __("Blog has been deleted !"));
            return redirect("admin/blog");
        }
    }
}
