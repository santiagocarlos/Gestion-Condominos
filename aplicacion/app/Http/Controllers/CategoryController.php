<?php

namespace App\Http\Controllers;

use Alert;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request)  {
            Category::create($request->all());
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $category = Category::findOrFail($id_decrypt);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request, $id)  {
            $category = Category::findOrFail($id);
            $category->update($request->all());
        });

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id)->delete();
        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.categories.index');
    }
}
