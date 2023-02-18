<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxonomyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('backend.content.category.index');
  }



  public function create()
  {
    return view('backend.content.category.index');
  }


  public function store(Request $request)
  {
    $data = $this->validateTaxonomies();

    Taxonomy::create($data);

    return redirect()->route('admin.category.index')->withFlashSuccess('Category updated successfully');
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $taxonomy = Taxonomy::findOrFail($id);
    $parents = Taxonomy::where('id', '!=', $id)->pluck('name', 'magento_id');
    return view('backend.content.category.edit', compact('taxonomy', 'parents'));
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
    $data = $this->validateTaxonomies($id);

    Taxonomy::find($id)->update($data);

    return redirect()->route('admin.category.index')->withFlashSuccess('Category updated successfully');
  }





  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $taxonomy = Taxonomy::withTrashed()->find($id);
    if ($taxonomy->trashed()) {
      $taxonomy->forceDelete();
      return \response([
        'status' => true,
        'icon' => 'success',
        'msg' => 'Taxonomy permanently deleted',
      ]);
    } else if ($taxonomy->delete()) {
      return \response([
        'status' => true,
        'icon' => 'success',
        'msg' => 'Taxonomy moved to trashed successfully',
      ]);
    }

    return \response([
      'status' => false,
      'icon' => 'error',
      'msg' => 'Delete failed',
    ]);
  }


  public function validateTaxonomies($update_id = 0)
  {
    // id, is_active, name, slug, description, parent_id, icon, picture, magento_id, position, level, product_count, user_id, created_at, updated_at, deleted_at
    $data =  request()->validate([
      'is_active' => 'nullable|date_format:Y-m-d H:i:s',
      'name' => "required|string|max:255",
      'description' => 'nullable|string|max:1800',
      'parent_id' => 'nullable|string|max:255|exists:taxonomies,magento_id',
      'icon' => 'nullable|max:1800|mimes:jpeg,jpg,png,gif,webp',
      'picture' => 'nullable|max:1800|mimes:jpeg,jpg,png,gif,webp',
    ]);

    unset($data['icon'], $data['picture']);

    $slug = Str::slug(request('name'));
    $data['slug'] = $slug;
    $data['is_active'] = request('is_active', null);

    if (!$update_id) {
      $data['user_id'] = auth()->id();
    }

    if (request()->hasFile('picture')) {
      $file = request()->file('picture');
      $fileName = $slug . '-' . time();
      $data['picture'] = store_picture($file, 'taxonomy/', $fileName);
    }
    if (request()->hasFile('icon')) {
      $file = request()->file('icon');
      $fileName = $slug . '-' . time();
      $data['icon'] = store_picture($file, 'taxonomy/icon/', $fileName);
    }

    return $data;
  }
}
