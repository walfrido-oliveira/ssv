<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
	 * @var ProductCategory
	 */
    private $category;

    /**
     * create a new instance of controll
     */
	public function __construct(ProductCategory $category)
	{
        $this->category = $category;

        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = trim($request->q);

        if (!empty($term)) {
            $categories = $this->category
            ->where('id', '=', $term )
            ->orwhere('name', 'like', '%' . $term . '%')
            ->paginate(10);
        } else {
            $categories = $this->category->paginate(10);
        }

        return view('admin.categories.index', compact('categories'));
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
        $request->validate($this->roles($this->category));

        $this->category->create($request->all());

        flash('success', 'Category added successfully!');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = $this->category->where('slug',$slug)->first();

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category = $this->category->where('slug',$slug)->first();

        return view('admin.categories.edit', compact('category'));
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
        $category = $this->category->find($id);

        $request->validate($this->roles($category));

        $category->update($request->all());

        flash('success', 'Category updated successfully!');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);

        $products = Product::where('product_category_id', $id);

        if ($products->count() > 0)
        {
            flash('error', 'Category don\'t removed! There is a product with this category. Before the to remove, remove the especifics custome, or change this category.');
            return redirect(route('admin.categories.index'));
        }

        $category->delete();

        flash('success', 'Category removed successfully!');

        return redirect(route('admin.categories.index'));
    }

    /**
     * Get rules of validation
     *
     * @param Activity $activity
     * @return array
     */
    public function roles($activity)
    {
        return
        [
            'name' => 'required|max:255|unique:product_categories,name,' . $activity->id
        ];
    }
}
