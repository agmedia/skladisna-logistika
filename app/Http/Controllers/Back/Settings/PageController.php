<?php

namespace App\Http\Controllers\Back\Settings;

use App\Models\Back\Photo;
use App\Models\Back\Settings\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new Page())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        $pages = $query->orderBy('created_at', 'desc')->get();

        return view('back.settings.pages.index', compact('pages'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$page_groups = Page::groups();

        return view('back.settings.pages.edit'/*, compact('page_groups')*/);
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
        $page = Page::store($request);

        if (Bouncer::is(auth()->user())->an('admin')) {
            Cache::forget('ifp');
        }

        if ($page) {
            if ($request->hasFile('image')) {
                $path = Photo::imageUpload($request->file('image'), $page, 'page', 'image');
                Page::updateImagePath($page->id, $path);
            }

            return redirect()->route('pages')->with(['success' => 'Page was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error creating the page.']);
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
        $query = (new Page())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        $page = $query->where('id', $id)->first();

        if ( ! $page) {
            abort(401);
        }

        //$page_groups = Page::groups();

        return view('back.settings.pages.edit', compact('page'/*, 'page_groups'*/));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::renew($request, $id);

        if (Bouncer::is(auth()->user())->an('admin')) {
            Cache::forget('ifp');
        }

        if ($page) {
            if ($request->hasFile('image')) {
                $path = Photo::imageUpload($request->file('image'), $page, 'page', 'image');
                Page::updateImagePath($page->id, $path);
            }

            return redirect()->route('pages')->with(['success' => 'Page was succesfully updated!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error updating the page.']);
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
            if (Bouncer::is(auth()->user())->an('admin')) {
                Cache::forget('ifp');
            }

            return response()->json(
                Page::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
