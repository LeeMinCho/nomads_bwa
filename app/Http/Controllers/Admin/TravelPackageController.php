<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TravelPackageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\TravelPackage;
use Yajra\DataTables\DataTables;

class TravelPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = TravelPackage::all();
        return view('pages.admin.travel-package.index', [
            'items' => $items
        ]);
    }

    public function travelPackageDatatable()
    {
        $travelPackage = TravelPackage::query();
        return DataTables::of($travelPackage)
            ->addColumn('action', function ($travelPackage) {
                return '<button id="show-travel-package" data-id="' . $travelPackage->id . '" class="btn btn-primary" title="Show Detail"><i class="fas fa-eye"></i></button> <button id="edit-travel-package" data-id="' . $travelPackage->id . '" class="btn btn-info" title="Edit"><i class="fas fa-edit"></i></button>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.travel-package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TravelPackageRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        TravelPackage::create($data);
        return response(['message' => 'Success create new data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $travelPackage = TravelPackage::findOrFail($id);
        return response($travelPackage);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.admin.travel-package.edit', [
            'item' => TravelPackage::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TravelPackageRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $item = TravelPackage::findOrFail($id);
        $item->update($data);

        return response(['message' => 'Success update data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = TravelPackage::findOrFail($id);
        $item->delete();

        return redirect()->route('travel-package.index');
    }
}
