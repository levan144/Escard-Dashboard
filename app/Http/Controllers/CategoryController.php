<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Company;
class CategoryController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->color = $request->color;
        if($request->file('icon')){
            $file= $request->file('icon');
            $extension = $file->getClientOriginalExtension();
            $filename= date('YmdHi').time() . '.' . $extension;
            $file-> move(public_path('/icons'), $filename);
            $category->icon = 'https://dashboard.escard.ge'. '/icons/' . str_replace(' ', '%20', $filename);
        }
        
        if($request->file('icon_hover')){
            $file= $request->file('icon_hover');
            $extension = $file->getClientOriginalExtension();
            $filename= date('YmdHi').time() . '.' . $extension;
            $file-> move(public_path('/icons_hover'), $filename);
            $category->icon_hover = 'https://dashboard.escard.ge'. '/icons_hover/' . str_replace(' ', '%20', $filename);
        }
        $category->save();
        
         return redirect()->route('categories')->with('success','Category Created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);
        
        
        return view('categories.edit', compact('category','categories'));
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
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->color = $request->color;
        if($request->file('icon')){
            $file= $request->file('icon');
            $extension = $file->getClientOriginalExtension();
            $filename= date('YmdHi').time() . '.' . $extension;
            $file-> move(public_path('/icons'), $filename);
            $category->icon = 'https://dashboard.escard.ge'. '/icons/' . str_replace(' ', '%20', $filename);
        }
        
        if($request->file('icon_hover')){
            $file= $request->file('icon_hover');
            $extension = $file->getClientOriginalExtension();
            $filename= date('YmdHi').time() . '.' . $extension;
            $file-> move(public_path('/icons_hover'), $filename);
            $category->icon_hover = 'https://dashboard.escard.ge'. '/icons_hover/' . str_replace(' ', '%20', $filename);
        }
        $category->save();
        return redirect()->route('categories')->with('success','Category Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

    // Check if any company is associated with this category
    $associatedCompaniesCount = Company::where('category_id', $id)->count();
    if ($associatedCompaniesCount > 0) {
        // If there are associated companies, show an error and redirect back
        return redirect()->route('categories')
                         ->with('error', 'Cannot delete category.  '. $associatedCompaniesCount .' Companies are associated with it.');
    }

    // If no associated companies, proceed with category deletion
    $category->delete();

    return redirect()->route('categories')
                     ->with('success', 'Category deleted successfully.');
    }
}
