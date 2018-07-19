<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Film;
use App\FilmGenre;
use App\Genre;

class FilmAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::get();

        return response()->json([
            'code' => 200,
            'message' => 'Request Ok',
            'data' => $films
        ]);
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
        $ticket_price = $request->input('ticket_price');
        $country = $request->input('country');
        $photo = $request->input('photo');
        $slug = str_slug($name);

        $this->registerCustomValidation();

        // validate the input
        $validator = Validator::make(
            array('name'         => $name,
                  'description'  => $description,
                  'rating'       => $rating,
                  'ticket_price' => $ticket_price,
                  'country'      => $country,
                  'photo'        => $photo
                 ),
            array('name'         => 'required|slug.exist',
                  'description'  => 'required',
                  'rating'       => 'required',
                  'ticket_price' => 'required',
                  'country'      => 'required',
                  'photo'        => 'required'
                 ),
            array('slug.exist'   => 'film already exist!')
        );

        // validation fail
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();
            return response()->json([
                'code' => 200,
                'message' => $errorMessage,
                'data' => NULL
            ]);
        }

        $new_film = new Film();
        $new_film->name = $name;
        $new_film->description = $description;
        $new_film->slug = $slug;
        $new_film->rating = $rating;
        $new_film->ticket_price = $ticket_price;
        $new_film->country = $country;
        $new_film->photo = $photo;
        $new_film->save();

        return response()->json([
            'code' => 200,
            'message' => 'Request Ok',
            'data' => $new_film
        ]);
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
        $film_id = $id;
        $name = $request->input('name');
        $description = $request->input('description');
        $rating = $request->input('rating');
        $ticket_price = $request->input('ticket_price');
        $country = $request->input('country');
        $photo = $request->input('photo');
        $slug = str_slug($name);

        $this->registerCustomValidation();

        // validate the input
        $validator = Validator::make(
            array('film_id'      => $film_id,
                  'name'         => $name,
                  'description'  => $description,
                  'rating'       => $rating,
                  'ticket_price' => $ticket_price,
                  'country'      => $country,
                  'photo'        => $photo
                 ),
            array('film_id'      => 'required|film.exist',
                  'name'         => 'required',
                  'description'  => 'required',
                  'rating'       => 'required',
                  'ticket_price' => 'required',
                  'country'      => 'required',
                  'photo'        => 'required'
                 ),
            array('slug.exist'   => 'film already exist!')
        );

        // validation fail
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();
            return response()->json([
                'code' => 200,
                'message' => $errorMessage,
                'data' => NULL
            ]);
        }

        $update_film = Film::where('film_id', '=', $pageId)->first();
        $update_film->name = $name;
        $update_film->description = $description;
        $update_film->slug = $slug;
        $update_film->rating = $rating;
        $update_film->ticket_price = $ticket_price;
        $update_film->country = $country;
        $update_film->photo = $photo;
        $update_film->save();

        return response()->json([
            'code' => 200,
            'message' => 'Request Ok',
            'data' => $update_film
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_film = Film::where('film_id', '=', $id);
        if ($delete_film->delete()) {
            return response()->json([
                'code' => 200,
                'message' => 'Request Ok',
                'data' => $delete_film
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Request Failed',
                'data' => null
            ]);
        }
    }

    protected function registerCustomValidation()
    {
        // check slug exist or not
        Validator::extend('slug.exist', function ($attribute, $value, $parameters) {
            $slug = str_slug($value);
            $film = Film::where('slug', $slug)
                        ->first();

            if (empty($film)) {
                return TRUE;
            }

            return FALSE;
        });

        // check film exist or not
        Validator::extend('film.exist', function ($attribute, $value, $parameters) {
            $film = Film::where('film_id', $value)
                        ->first();

            if (empty($film)) {
                return FALSE;
            }

            return TRUE;
        });
    }
}
