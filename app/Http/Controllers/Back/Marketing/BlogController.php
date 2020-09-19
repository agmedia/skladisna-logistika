<?php

namespace App\Http\Controllers\Back\Marketing;

use App\Models\Back\Category;
use App\Models\Back\Marketing\Blog\Blog;
use App\Models\Back\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Bouncer;

class BlogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Blog())->newQuery();

        if ($request->has('group')) {
            $query->where('category_id', $request->input('group'));
        }

        if ($request->has('from')) {
            $query->whereDate('created_at', '>=', Carbon::createFromFormat('d.m.Y.', $request->input('from')));
        }

        if ($request->has('to')) {
            $query->where('created_at', '<=', Carbon::createFromFormat('d.m.Y.', $request->input('to')));
        }

        $blogs = $query->orderBy('created_at', 'desc')->get();

        $cats = Category::adminList('blog');

        return view('back.marketing.blog.index', compact('blogs', 'cats'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::adminList('blog');

        return view('back.marketing.blog.edit', compact('cats'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $blog   = new Blog();
        $stored = $blog->validateRequest($request)->storeBlog();

        if ($stored) {
            if ($request->has('main_image') && $request->input('main_image')) {
                $blog->resolveMainImage($stored->id);
            }

            if ($request->has('gallery_images') || $request->has('new_gallery_images')) {
                $blog->resolveGallery($stored->id);
            }

            if ($request->has('blocks_docs')) {
                $blog->resolveDocuments($stored->id,
                    $request->block_doc_files ? $request->block_doc_files : null
                );
            }

            return redirect()->route('blogs')->with(['success' => 'Blog je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem bloga.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = (new Blog())->newQuery();

        $blog = $query->where('id', $id)->first();

        if ( ! $blog) {
            abort(401);
        }

        $tags = Tag::all();
        $arr  = [];

        /*if ( ! empty($blog->tags)) {
            foreach ($blog->tags as $tag) {
                $arr[] = $tag->id;
            }
        }*/

        //dd($blog->blocks->groupBy('type')['pdf']);

        $blog_tags = collect($arr)->flatten()->all();
        $cats = Category::adminList('blog');

        return view('back.marketing.blog.edit', compact('blog', 'tags', 'blog_tags', 'cats'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Blog                     $blog
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //dd(isset($request->date_published));
        $updated = $blog->validateRequest($request)->updateBlog($blog->id);

        if ($updated) {
            if ($request->has('main_image') && $request->input('main_image')) {
                $blog->resolveMainImage($blog->id);
            }

            if ($request->has('gallery_images') || $request->has('new_gallery_images')) {
                $blog->resolveGallery($blog->id);
            }

            if ($request->has('blocks_docs')) {
                $blog->resolveDocuments($blog->id,
                    $request->block_doc_files ? $request->block_doc_files : null
                );
            }

            return redirect()->route('blogs')->with(['success' => 'Blog je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem bloga.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            return response()->json(
                Blog::destroyAll($request['data']['id'])
            );
        }
    }
}
