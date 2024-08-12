<?php

namespace App\Http\Controllers;

use App\Api\Models\Category;
use App\Api\Models\Product;
use App\Api\Models\Provider;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ProductController extends Controller {
    public function detail(Request $request, $slug){

        $parts = explode('-', $slug);
        $lastItem = array_pop($parts);

        if(is_numeric($lastItem) && strpos($lastItem, '.')===false){
            $data['idProduct'] = $lastItem;
            $data['selectedIdColor'] = false;
        } else{
            $parts = explode('.', $lastItem);
            $data['idProduct'] = array_shift($parts);
            $data['selectedIdColor'] = array_pop($parts);
        }
        $data['product'] = Product::productDetail($data['idProduct'], $data['selectedIdColor'], true, false);
        if(empty($data['product'])){
            return view('product.notfound',$data);
        }

        $data['selectedVariant'] = [];
        foreach($data['product']->variants as $variant){
            if($variant->idColor==$data['selectedIdColor']){
                $data['selectedVariant'] = $variant;
                break;
            }
        }
        if(empty($data['selectedVariant'])){
            $data['selectedVariant'] = current($data['product']->variants);
        }

        $data['selectedIdColor'] = $data['selectedVariant']->idColor;

        $data['product']->bread_cramps = Product::getBreadCramps($data['idProduct']);
        $data['product']->reviewsAverage = Product::getReviewsAverage($data['product']->idProvider);
        $data['product']->provider = Provider::getProvider($data['product']->idProvider);
        $data['product']->reviews = [
            'count'=>Product::getReviewsCount($data['product']->id),
            'items'=>Product::getReviews($data['product']->id)
        ];
        $data['product']->questions = [
            'count'=>Product::getQuestionCount($data['product']->id),
            'items'=>Product::getQuestions($data['product']->id)
        ];
        \BasketService::setLastViewed($data['product']);
        return view('product.detail',$data);
    }
    public function reviewAdd(Request $request){
        $result = [
            'status'=>0,
            'message'=>'',
        ];

        $review = [
            'idProduct'=>$request->input('idProduct'),
            'idMember'=>member_logged(),
            'reviewCaption'=>$request->input('reviewCaption'),
            'reviewText'=>$request->input('reviewText'),
            'reviewPoint'=>$request->input('reviewPoint'),
            'isQuestion'=>0,
            'active'=>0,
            'showName'=>0,
            'reviewName'=>member_get('name'),
            'reviewSurname'=>member_get('surName'),
            'reviewAnswer'=>'',
            'reviewEmail'=>member_get('email'),
        ];

        $reviewId = DB::table('product_reviews')->insertGetId($review);
        if($reviewId){
            $result['status'] = 1;
            $result['message'] = 'Yorumunuz için teşekkür ederiz. Yorumunuz kontrol edildikten sonra yayınlanacaktır.';
        } else {
            $result['message'] = 'Yorumunuz kaydedilemedi. Lütfen daha sonra tekrar deneyiniz';
        }
        return $result;
    }
}
