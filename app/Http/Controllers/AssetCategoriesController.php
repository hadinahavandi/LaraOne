<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetCategory;
use App\Http\Controllers\Controller;
use Exception;

class AssetCategoriesController extends Controller
{

    /**
     * Display a listing of the asset categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $assetCategories = AssetCategory::paginate(25);

        return view('asset_categories.index', compact('assetCategories'));
    }

    /**
     * Show the form for creating a new asset category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('asset_categories.create');
    }

    /**
     * Store a new asset category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            AssetCategory::create($data);

            return redirect()->route('asset_categories.asset_category.index')
                             ->with('success_message', 'Asset Category was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified asset category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $assetCategory = AssetCategory::findOrFail($id);

        return view('asset_categories.show', compact('assetCategory'));
    }

    /**
     * Show the form for editing the specified asset category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $assetCategory = AssetCategory::findOrFail($id);
        

        return view('asset_categories.edit', compact('assetCategory'));
    }

    /**
     * Update the specified asset category in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $assetCategory = AssetCategory::findOrFail($id);
            $assetCategory->update($data);

            return redirect()->route('asset_categories.asset_category.index')
                             ->with('success_message', 'Asset Category was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified asset category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $assetCategory = AssetCategory::findOrFail($id);
            $assetCategory->delete();

            return redirect()->route('asset_categories.asset_category.index')
                             ->with('success_message', 'Asset Category was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'string|min:1|max:255|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'is_active' => 'boolean|nullable',
     
        ];

        
        $data = $request->validate($rules);


        $data['is_active'] = $request->has('is_active');


        return $data;
    }

}
