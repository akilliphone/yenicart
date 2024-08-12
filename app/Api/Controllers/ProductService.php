<?php

namespace App\Api\Controllers;


use App\Api\Models\Category;
use App\Api\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductService extends Controller {
    const SLIDER_LIST_COUNT = 10;
    const CACHE_DURATIN=120;
    public function list( Request $request){

        $filter['text'] = $request->input('text' );
        $filter['category'] = $request->input('category' );
        $filter['provider'] = $request->input('provider' );
        $filter['color'] = $request->input('color' );
        $filter['pricemin'] = $request->input('pricemin' );
        $filter['pricemax'] = $request->input('pricemax' );
        $filter['orderby'] = $request->input('orderby' );
        $filter['dir'] = $request->input('dir' );
        $filter['variyantasproduct'] = $request->input('variyantasproduct' );
        $filter['custom'] = $request->input('custom' );
        $filter['offset'] = $request->input('offset' );
        return $this->getFilteredProducts($filter, false, true);
    }
    private function getFilteredProducts($filter, $withDescription, $byfilter){
        $start = new \DateTime();
        $products = Product::getFilteredProducts($filter, $withDescription, $byfilter);
        return \Amele::successResponse($products, 'Başarılı', number_format(date_diff(new \DateTime(), $start)->f, 6));
    }
    public function autocomplate(Request $request){
        $cacheKey = 'autocomplate.'.md5( json_encode($request->all()));
        $result = Cache::get($cacheKey, null);
        if($result){
            return $result;
        }
        $filter= [];
        $text = $request->input('text', '');
        if($text){
            $filter['text']=$text;
        }
        $response = Product::getFilteredProducts($filter, false, false);
        $result = [
            'query'=> "Unit",
            'html'=>''
        ];
        if(isset($response['items']) && $response['items']){
            $result['html'] .= '<ul class="ajax-search" >';
            foreach($response['items'] as $product){
                $result['html'] .= $this->autoComplateLine($product, $text);
            }
            $result['html'] .= '<li style="text-align: center"><hr><a href="'.route('product.search').'?text='.$text.'">Daha Fazla Sonuç İçin Tıklayınız</a></li>';
            $result['html'] .= '</ul>';
        }
        Cache::put($cacheKey, $result, self::CACHE_DURATIN);
        return($result);
    }
    private function autoComplateLine($product, $search){
        $productName = $product->productName;
        foreach(explode(' ', $search) as $text){
            $productName = str_replace([$text, ucfirst($text), strtoupper($text), strtolower($text)], ['<strong>'.$text.'</strong>','<strong>'.ucfirst($text).'</strong>','<strong>'.strtoupper($text).'</strong>','<strong>'. strtolower($text).'</strong>'], $productName);
        }
        if($product['thumb']){
            $image = '<img style="width:20px" src="'.$product->thumb.'">' ;
        } else {
            $image = '';
        }
        return '<li style="clear: both"><a href="'.\Amele::getProductUrl($product).'">'.$image.$productName.'</a></li>';
    }
    public function cat_section( Request $request, $idCategory){
        $category = Category::getCategory($idCategory);
        $filter['category'] = $category->filter;
        $filter['orderby'] = 'id';
        $filter['dir'] = 'desc';
        $filter['offset'] = 0;
        $filter['limit'] = self::SLIDER_LIST_COUNT;
        return $this->getFilteredProducts($filter, false, false);
    }
    public function onsale( Request $request){
        $filter['category'] = $request->input('category' );
        $filter['orderby'] = 'oldPriceDate';
        $filter['dir'] = 'desc';
        $filter['offset'] = 0;
        $filter['custom'] = 'onsale';
        $filter['limit'] = self::SLIDER_LIST_COUNT;
        return $this->getFilteredProducts($filter, false, false);
    }
    public function restock( Request $request){
        $filter['category'] = $request->input('category' );
        $filter['orderby'] = 'newStockDate';
        $filter['dir'] = 'desc';
        $filter['offset'] = 0;
        $filter['limit'] = self::SLIDER_LIST_COUNT;
        return $this->getFilteredProducts($filter, false, false);
    }
    public function bestseller( Request $request){
        $filter['category'] = $request->input('category' );
        $filter['orderby'] = 'saleCount';
        $filter['dir'] = 'desc';
        $filter['offset'] = 0;
        $filter['limit'] = self::SLIDER_LIST_COUNT;
        return $this->getFilteredProducts($filter, false, false);
    }
    public function newly( Request $request){
        $filter['category'] = $request->input('category' );
        $filter['orderby'] = 'idProduct';
        $filter['dir'] = 'desc';
        $filter['offset'] = 0;
        $filter['limit'] = self::SLIDER_LIST_COUNT;
        return $this->getFilteredProducts($filter, false, false);
    }
    public function detail( Request $request, $idProduct){
        $filter['id'] = $idProduct;
        $products = Product::getFilteredProducts($filter, true, false);
        return \Amele::successResponse($products['items'], 'Başarılı');
    }

    public function category( Request $request, $idCategory){
        if($idCategory){
            $product = Category::getCategory($idCategory);
        } else{
            $product = Category::getCategories();
        }
        return \Amele::successResponse($product, 'Başarılı');
    }

}
