<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo 'tes';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $name = $request->input('name');
        $description = $request->input('description');
        $rating = $request->input('rating');

        $this->registerCustomValidation();

        // validate the input
        $validator = Validator::make(
            array('page_name'    => $pageName,
                  'page_content' => $pageContent),
            array('page_name'    => 'required|max:25|slug.exist',
                  'page_content' => 'required'),
            array('slug.exist'   => 'page already exist!')
        );

        // validation fail
        if ($validator->fails()) {
            return redirect('admin/page/create')
                    ->withErrors($validator)
                    ->withInput();
        }

        $newPage = new Page();
        $newPage->page_name = $pageName;
        $newPage->page_type = 'main_page';
        $newPage->slug = $slug;
        $newPage->status = 'active';
        $newPage->content = $pageContent;
        $newPage->parent_id = null;
        $newPage->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function registerCustomValidation()
    {
        // check slug exist or not
        Validator::extend('slug.exist', function ($attribute, $value, $parameters) {
            $slug = str_slug($value);
            $page = Film::where('slug', $slug)
                        ->first();

            if (empty($page)) {
                return TRUE;
            }

            return FALSE;
        });

        // check slug exist or not
        Validator::extend('page.exist', function ($attribute, $value, $parameters) {
            $page = Page::where('page_id', $value)
                        ->first();

            if (empty($page)) {
                return FALSE;
            }

            return TRUE;
        });
    }
}
