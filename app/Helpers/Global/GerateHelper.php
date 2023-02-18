<?php

use App\Models\Backend\Banner;
use App\Models\Backend\Taxonomy;

if (!function_exists('generate_categories')) {

  function generate_categories()
  {
    $categories = Taxonomy::with(['parent', 'children' => function ($children) {
      $children->with('children');
    }])
      ->whereNull('parent_id')
      ->whereNotNull('is_active')
      ->orderBy('position')->get()->toArray();


    array_walk_recursive($categories, function (&$v, $k) {
      if ($k == 'icon') {
        $v = $v ? asset($v) : null;
      } elseif ($k == 'picture') {
        $v = $v ? asset($v) : null;
      }
    });
    return $categories;
  }
}


if (!function_exists('generate_banners')) {

  function generate_banners()
  {
    $banners = Banner::whereNotNull('is_active')
      ->where('status', 'publish')
      ->where('type', 'banner')
      ->latest()
      ->get()
      ->toArray();

    array_walk_recursive($banners, function (&$v, $k) {
      if ($k == 'picture') {
        $v = $v ? asset($v) : null;
      }
    });
    return $banners;
  }
}
