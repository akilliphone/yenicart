<?php

namespace App\Http\Controllers;

use App\Api\Models\Category;
use App\Api\Models\Product;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SearchController extends Controller {
    public function search(Request $request, $category='0'){

        $parts = explode('-', $category);

        $data['idCategory'] = array_pop($parts);
        $data['idCategory'] = $request->input('category', (int)$data['idCategory']);
        $data['selectedFilter'] = $data['idCategory'] ;

        $data['selectedCategory'] = Category::getCategory($data['idCategory']);

        if($data['selectedCategory'] && isset($data['selectedCategory']->filter)){
            $data['selectedFilter'] = $data['selectedCategory']->filter;
        }
        $data['selectedOrderby'] = $request->input('orderby');
        $data['selectedDir'] = $request->input('dir');
        $data['provider'] = $request->input('provider');
        $data['custom'] = $request->input('custom');
        $data['text'] = $request->input('text');
        $filters = $request->all();
        $data['filter'] = Search::fixPropductFilter($filters);
        View::share('searchCategory',$data['idCategory']);
        return view('search.index',$data);
    }
}
