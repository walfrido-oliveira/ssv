<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
	 * @var Product
	 */
    private $product;

    /**
     * create a new instance of controll
     */
	public function __construct(product $product)
	{
        $this->product = $product;

        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all()->pluck('name', 'id');

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->product));

        $data = $request->all();

        $data['product_category_id'] = $this->createCategory($data['product_category_id']);

        $product = $this->product->create($data);;

        if (!is_null($request->image))
        {
            $image = $request->image->store('img', ['disk' => 'public']);

            $data['image'] = $image;
            $product->update($data);
        }

        flash('success', 'Product added successfully!');

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = product::find($id);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = ProductCategory::all()->pluck('name', 'id');

        $product = Product::find($id);

        return view('admin.products.edit', compact('product', 'categories'));
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
        $product = Product::find($id);

        $request->validate($this->roles($product));

        $data = $request->all();

        $data['product_category_id'] = $this->createCategory($data['product_category_id']);

        $oldImage = $product->image;

        $product->update($data);

        if (!is_null($request->image))
        {
            Storage::delete('public/' . $oldImage);
            $image = $request->image->store('img', ['disk' => 'public']);

            $data['image'] = $image;
            $product->update($data);
        }

        flash('success', 'Product updated successfully!');

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);

        $budgets = Budget::with('products')->whereHas('products', function ($query) use($product) {
            $query->where('products.id', $product->id);
        });

        if ($budgets->count() > 0)
        {
            flash('error', 'Product don\'t removed! There is a budget with this product. Before the to remove, remove the especifics budget, or remove this product.');
            return redirect(route('admin.products.index'));
        }

        $product->delete();

        flash('success', 'Product removed successfully!');

        return redirect(route('admin.products.index'));
    }

    /**
     * Get rules of validation
     * @param Product $product
     * @return array
     */
    public function roles($product)
    {
        return
        [
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'price' => 'required|numeric',
            'product_category_id' => 'required',
            'description' => 'nullable|max:500',
            'image' => 'nullable|image'
        ];
    }

    /**
     * Create a inexistent category
     * @param $category_id
     */
    private function createCategory($product_category_id)
    {
        $category = ProductCategory::find($product_category_id);

        if (is_null($category))
        {
            $category = ProductCategory::create([
                'name' => $product_category_id
            ]);
        }

        return $category->id;
    }
}
