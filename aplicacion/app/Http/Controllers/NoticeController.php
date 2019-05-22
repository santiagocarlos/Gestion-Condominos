<?php

namespace App\Http\Controllers;

use Alert;
use App\Category;
use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = Notice::with('category')->get();
        return view('admin.news.index',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cant_categories = Category::all()->count();
        $categories = Category::all();
        return view('admin.news.create', compact('cant_categories','categories'));
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
            'title' => 'required|string',
            'category_id' => 'required|not_in:0',
            'description' => 'required',
        ],
        [
            'title.required' => 'Este campo es obligatorio',
            'category_id.required' => 'Este campo es obligatorio',
            'category_id.not_in' => 'Debes seleccionar una categoría',
            'description.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request) {
            $notice = Notice::create($request->all());
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $notice = Notice::with('category')->where('id','=',$id_decrypt)->first();

        return view('admin.news.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $cant_categories = Category::all()->count();
        $categories = Category::all();
        $category = Category::where('id','=',$id_decrypt)->select('name')->first();
        $notice = Notice::with('category')->where('id','=',$id_decrypt)->first();
        return view('admin.news.edit',compact('notice','cant_categories','categories','category'));
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
            'title' => 'required|string',
            'category_id' => 'required|not_in:0',
            'description' => 'required',
        ],
        [
            'title.required' => 'Este campo es obligatorio',
            'category_id.required' => 'Este campo es obligatorio',
            'category_id.not_in' => 'Debes seleccionar una categoría',
            'description.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request, $id) {
            Notice::findOrFail($id)->update($request->all());
        });

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id)->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.news.index');
    }

    public function index_owner()
    {
        $news = Notice::with('category')->get();
        return view('owners.billboard.index', compact('news'));
    }

    public function show_owner($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $notice = Notice::with('category')->where('id','=',$id_decrypt)->first();
        return view('owners.billboard.show', compact('notice'));
    }
}
