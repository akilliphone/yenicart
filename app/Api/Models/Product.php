<?php

namespace App\Api\Models;

use App\Helpers\CurrencyCodes;
use App\Helpers\MemberTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\TextUI\Help;


class Product extends Model{
    use HasApiTokens, HasFactory, Notifiable;

    const LIST_LIMIT = 25;
    protected $table = 'product';
    private static $fields = [
        'id',
        'productCode',
        'productName',
        'idProvider',
        'idCurrency',
        'salePrice',
        'salePrice2',
        'productDescription',
        'visitCount',
        'visitCount_new',
        'saleCount',
        'saleCount_new',
        'active',
        'oldPrice',
        //'nethesap_id',
        //'orderNumber',
        //'idProductCategory',
        //'idBrand',
        //'idProductSet',
        //'useColor',
        //'productTicketName',
        //'accountCode',
        //'productProviderCode',
        //'idUnit',
        'oldPriceDate',
        //'purchasePrice',
        //'marketPrice',
        //'idTax',
        //'includeTax',
        //'categoryOrderNumber',
        //'brandOrderNumber',
        //'salePrice3',
        //'salePrice4',
        //'salePrice5',
        //'discount2',
        //'discount3',
        //'discount4',
        //'discount5',
        //'discount2Type',
        //'discount3Type',
        //'discount4Type',
        //'discount5Type',
        //'profitType',
        //'profitMargin',
        //'salePriceLast',
        //'salePriceLast2',
        //'salePriceLast3',
        //'salePriceLast4',
        //'salePriceLast5',
        //'picture1',
        //'picture2',
        //'picture3',
        //'picture4',
        //'picture5',
        //'picture6',
        //'picture7',
        //'picture8',
        //'orderDescription',
        //'label1',
        //'label2',
        //'label3',
        //'label4',
        //'label5',
        //'label6',
        //'label7',
        //'label8',
        //'label9',
        //'label10',
        //'productType',
        //'guaranty',
        //'cargoDeci',
        //'giftPacket',
        //'giftPacketPrice',
        //'tags',
        //'seoTitle',
        //'seoKeywords',
        //'seoDescription',
        //'idProductProperties',
        //'discount',
        //'discountType',
        //'stockAmount',
        //'cargoType',
        //'cargoPrice',
        //'insertDate',
        //'categoryOrder',
        //'wareHouse',
        //'multiProduct',
        //'mainProduct',
        //'searchTerms',
        //'label1Order',
        //'label2Order',
        //'label3Order',
        //'label4Order',
        //'label5Order',
        //'label6Order',
        //'label7Order',
        //'label8Order',
        //'label9Order',
        //'label10Order',
        //'brands',
        //'brands_eski_sil',
        //'idNetHesap',
        //'updateNetHesap',
        //'kampanya_price',
        //'kampanya_limit',
        //'nethesap_aciklama',
        //'hb_image',
        //'gg_code',
        //'gg_path',
        //'gg_spec',
        //'n11secenek',
        //'n11name',
        //'ozel_uyari',
        //'yayinla_site',
        //'yayinla_n11',
        //'yayinla_gg',
        //'yayinla_hb',
        //'yayinla_amz',
        //'ureticikodu',
        //'n11_rate',
        //'gg_rate',
        //'hb_rate',
        //'amazon_rate',
        //'trendyol_rate',
        //'hejatek_urun'
    ];
    private static $variantFields = [
        'id',
        'idProduct',
        'idColor',
        'amount',
        'barcode',
    ];
    protected $fillable = [
    ];

    protected $hidden = [
    ];

    public static  function getFilteredProducts($filters, $withDescription, $byfilter){
        $filters = self::fixPropductFilter($filters);
        $query = DB::table('search_table');
        $query->whereRaw(DB::raw("`active` = 1 "));
        /**
         * Ad ve kod Filtresi
         */
        if($filters['id']){
            $where = DB::raw("`idProduct` = ".(int)$filters['id']);
            $query->whereRaw($where);
            $filters['variyantasproduct'] = false;
        }
        $match_order = '1 AS match_order';
        if($filters['text']){

            $parts = explode(' ', $filters['text']);
            $textwhere = [];
            $words =[];
            foreach($parts as $parttext){
                if(strlen($parttext)>2){
                    $text = DB::connection()->getPdo()->quote($parttext);
                    $liketext = DB::connection()->getPdo()->quote('%'.$parttext.'%');
                    $textwhere[] = "`productCode`=$text OR `barcode`=$text OR `productProviderCode`=$text OR `productName` LIKE $liketext";
                    $words[] = "productName LIKE $liketext";
                }
            }
            if($textwhere){
                $CASES[] = 'WHEN '.implode(' AND ', $words).' THEN 1 ';
                $CASES[] = 'WHEN '.implode(' OR ', $words).' THEN 2 ';
                $match_order = "(CASE ".implode(' ', $CASES)."ELSE 3 END) AS match_order";
                $where = DB::raw(implode(' OR ', $textwhere));
                $query->whereRaw($where);
            }
        }
        /**
         * Kategori Filtresi
         */
        $categories = [];
        if($filters['category']){
            if($loop = explode(',', $filters['category'])){
                foreach($loop as $idCategory){
                    if((int)$idCategory){
                        $categories[(int)$idCategory] = (int)$idCategory;
                    }
                }
            }
            if($categories){
                $where = DB::raw("`idCategory` IN (".implode(',', $categories).")");
                $query->whereRaw($where);
            }
            $idCategory = current($categories);
            $result['category'] = Category::getCategory($idCategory);
        } else {
            $result['category'] = [
                "id"=> 0,
                "idTop"=> 0,
                "categoryName"=> "Tüm Kategoriler",
                "logo"=> "",
                'children'=>Category::getCategories()
            ];
        }
        /**
         * Üretici Filtresi
         */
        $providers = [];
        if($filters['provider']){
            if($loop = explode(',', $filters['provider'])){
                foreach($loop as $idProvider){
                    if((int)$idProvider){
                        $providers[(int)$idProvider] = (int)$idProvider;
                    }
                }
            }
            if($providers){
                $where = DB::raw("`idProvider` IN (".implode(',', $providers).")");
                $query->whereRaw($where);
            }
        }
        /**
         * Renk Filtresi
         */
        $colors = [];
        if($filters['color']){
            if($loop = explode(',', $filters['color'])){
                foreach($loop as $idColor){
                    if((int)$idColor){
                        $colors[(int)$idColor] = (int)$idColor;
                    }
                }
            }
            if($colors){
                $where = DB::raw("`idColor` IN (".implode(',', $colors).")");
                $query->whereRaw($where);
            }
        }
        /**
         * Min Fiyat Filtresi
         */
        if($filters['pricemin'] && (int)$filters['pricemin']){
            $usdPrice = (self::tlToUsd($filters['pricemin']))/1.20;
            //echo "//".$filters['pricemin'].'|'.$usdPrice;
            $where = DB::raw("`salePrice` >= ".$usdPrice);
            $query->whereRaw($where);
        }
        /**
         * Max Fiyat Filtresi
         */
        if($filters['pricemax'] && (int)$filters['pricemax']){
            $usdPrice = (self::tlToUsd($filters['pricemax']))/1.20;
            //echo "//".$filters['pricemax'].'|'.$usdPrice;
            $where = DB::raw("`salePrice` <= ".$usdPrice);
            $query->whereRaw($where);
        }

        if($filters['custom'] =='onsale'){
            $where = DB::raw("`salePrice`>0 AND `oldPrice`>0 AND `salePrice`<`oldPrice` AND `oldPriceDate`>'".\Amele::birAyOncekiTarih()."'");
            $query->whereRaw($where);
        }

        $query->select('idProduct');
        if($filters['variyantasproduct']){
            $query->distinct('idProduct', 'idColor');
        } else{
            $query->distinct('idProduct');
            $query->groupBy('idProduct'); // total 1 geliyor ama tek ürün için gerekli
        }

        $result['total'] = $query->count();
        $result['count'] = 0;
        if($byfilter){
            $result['filter']['colors']=self::getFilterColors($query);
            $result['filter']['providers']=self::getFilterProviders($query);
        } else {
            $result['filter']['colors']=[];
            $result['filter']['providers']=[];
        }

        $query->select('idProduct', 'idColor', 'amount', 'productName', DB::raw($match_order));
        $query->orderBy( DB::raw("CASE WHEN amount > 0 THEN 0 ELSE 1 END"), 'ASC' );

        if($filters['orderby'] && in_array($filters['orderby'], ['idProduct', 'productName', 'newStockDate', 'saleCount', 'salePrice', 'visitCount'])){
            if($filters['dir']=='desc'){
                $query->orderBy( $filters['orderby'], 'DESC' );
            } else {
                $query->orderBy( $filters['orderby'], 'ASC' );
            }
            if($filters['orderby']=='visitCount'){
                //$query->whereRaw( DB::raw("`saleCount`>0") );
            }
        } else{
            if($match_order != '1 AS match_order'){
                $query->orderBy( 'match_order', 'ASC' );
            } else{
                $query->orderBy( 'idProduct', 'DESC' );
            }
        }
        $query->offset($filters['offset']);
        $query->limit($filters['limit']);
//echo $query->toSql()."\r\n";
        $rows = $query->get();
        //dd($filters);
        $result['items']=[];
        if($rows){
            foreach($rows as $row){
                $product = self::productDetail($row->idProduct, $row->idColor, $withDescription, $filters['variyantasproduct']);
                if($product){
                    $product->idColor = $row->idColor;
                    $product->color = self::getColor( $row->idColor );
                    $product->varyantAmount = $row->amount;
                    $result['items'][] =$product;
                }
            }
        }
        $result['count'] = count($result['items']);
        return $result;
    }
    public static function productDetail( $idProduct, $idColor=0 , $withDescription=false, $variyantasproduct=true){
        $product = Product::select(self::$fields)->find($idProduct);
        if($product){
            if($product->salePrice>0){
                $discountRate = ($product->oldPrice - $product->salePrice)/$product->oldPrice;
            } else {
                $discountRate = 0;
            }
            $discountRate = max(0, $discountRate);
            $product->discountRate = number_format($discountRate*100, 0);
            $product->url = \Amele::getProductUrl($product);
            $product->thumb = '';
            $calculated_prices = self::calculatePrice($product);
            $product->sale_price = $calculated_prices['sale_price'];
            $product->old_price = $calculated_prices['old_price'];
            $product->formatted_sale_price = $calculated_prices['formatted_sale_price'];
            $product->formatted_old_price = $calculated_prices['formatted_old_price'];
            $product->formula = $calculated_prices['formula'];
            $product->commentAble = self::productCommentAble($product->id);

            if($product->salePrice<$product->oldPrice){
                $product->discounted = true;
            } else {
                $product->discounted = false;
            }
            $product->hasStock = self::productHasStock($idProduct );
            if($idColor && $variyantasproduct){
                $variants[] = self::variyantDetail( $idProduct, $idColor );
            } else{
                $variants = self::productVariants( $idProduct );
            }

            if($variants){
                if(isset($variants[0]->images[0])){
                    if(isset($variants[0]->images[0]['thumb'])){
                        $product->thumb = $variants[0]->images[0]['thumb'];
                    }
                }
            }
            $product->variants = $variants;
            if(!$withDescription){
                $product->productDescription = null;
            }
        }
        return $product;
    }
    private static function productCommentAble($idProduct){
        return !DB::table('product_reviews')
            ->where(['idMember'=>Member::getLoggedMemberId(), 'idProduct'=>$idProduct ])
            ->exists();
    }
    private static function productHasStock($idProduct ){
        $query = DB::table('product_amount');
        $query->select(['idProduct']);
        $query->where([['idProduct', '=', $idProduct],['amount', '>', 0]]);
        return $query->exists();
    }
    private static function productVariyantImages($idProduct, $idColor ){
        $query = DB::table('product_pictures');
        $query->select('picture');
        $query->where(['idProduct'=>$idProduct, 'idColor'=>$idColor]);
        $query->offset(0);
        $query->limit(10);

        $rows = $query->get();
        if($rows){
            $images = [];
            foreach($rows as $row){
                $images[] =[
                    'thumb' => \Amele::getCdnImageUrl($row->picture, 160,160),
                    'url' => \Amele::getCdnImageUrl($row->picture, 350,380),
                ];
            }
        }
        return $images;
    }
    private static function productVariants( $idProduct ){
        $query = DB::table('product_amount');
        $query->select(['idProduct', 'idColor']);
        $query->where(['idProduct'=>$idProduct]);
        $rows = $query->get();
        if($rows){
            foreach($rows as $row){
                $variant = self::variyantDetail($row->idProduct, $row->idColor);
                $variants[] = $variant;
            }
            return $variants;
        }
        return [];
    }
    public static function variyantDetail( $idProduct, $idColor ){
        $variant = [];
        $query = DB::table('product_amount');
        $query->select(self::$variantFields);
        $query->where(['idProduct'=>$idProduct, 'idColor'=>$idColor]);
        $row = $query->first();
        if($row){
            $row->images = self::productVariyantImages($row->idProduct, $row->idColor);
            $row->color = self::getColor($row->idColor);
            $variant = $row;
        }
        return $variant;
    }
    private static function getColor( $idColor ){
        $query = DB::table('product_sets');
        $query->where(['id'=>$idColor]);
        $row = $query->first();
        if($row){
            $groupKey =  \Help::getPermalink($row->color_group);
            $row->style = self::getColorStyle($groupKey);
            return $row;
        }
        return [];
    }
    public static function fixPropductFilter($filters){
        $filters['id'] = isset($filters['id'])?$filters['id']:false;
        $filters['text'] = isset($filters['text'])?$filters['text']:'';
        $filters['category'] = isset($filters['category'])?$filters['category']:0;
        $filters['provider'] = isset($filters['provider'])?$filters['provider']:0;
        $filters['color'] = isset($filters['color'])?$filters['color']:'';
        $filters['pricemin'] = isset($filters['pricemin'])?$filters['pricemin']:'';
        $filters['pricemax'] = isset($filters['pricemax'])?$filters['pricemax']:'';
        $filters['variyantasproduct'] = isset($filters['variyantasproduct'])?$filters['variyantasproduct']:0;
        $filters['offset'] = isset($filters['offset'])?$filters['offset']:0;
        $filters['limit'] = isset($filters['limit'])?$filters['limit']:self::LIST_LIMIT;
        $filters['orderby'] = isset($filters['orderby'])?$filters['orderby']:false;
        $filters['dir'] = isset($filters['dir'])?$filters['dir']:false;
        $filters['custom'] = isset($filters['custom'])?$filters['custom']:false;
        return $filters;
    }
    private static function getFilterColors(\Illuminate\Database\Query\Builder $query){
        /**
         * filtre içimnde bulunan renkler
         */
        $whereIn = $query->toSql();
        $query = DB::table('product_amount');
        $where = DB::raw("`idProduct` IN ($whereIn) ");
        $query->whereRaw($where);
        $query->select('idColor');
        $query->distinct('idColor');
        $whereIn = $query->toSql();
        /**
         * Renk bilgileri
         */
        $query = DB::table('product_sets');
        $where = DB::raw("`id` IN ($whereIn) ");
        $query->whereRaw($where);

        $query->select(['id', 'color_group']);
        $rows = $query->get();
        $result = [];
        if($rows){
            foreach($rows as $row){
                $groupName = !empty($row->color_group)?$row->color_group:'Diğer';
                $groupKey =  \Help::getPermalink($groupName);
                $result[$groupKey]['name'] = $groupName;
                $result[$groupKey]['key'] = $groupKey;
                $result[$groupKey]['style'] = self::getColorStyle($groupKey);
                $result[$groupKey]['children'][] = $row->id;
            }
        }
        foreach($result as $groupKey=>$row){
            $row['value'] = implode(',', $row['children']);
            $result[$groupKey] = $row;

        }
        return $result;
    }
    static function getColorStyle($colorkey){
        $colors = [
            'renksiz'=>'#cdcdcd',
            'siyah'=>'#000000',
            'mavi'=>'#2b47b6',
            'beyaz'=>'#FFFFFF',
            'pembe'=>'#ffa4a4',
            'kirmizi'=>'#b62b2b',
            'kahverengi'=>'#2f0f03',
            'sari'=>'#b6a32b',
            'turuncu'=>'#ffa000',
            'yesil'=>'#44b62b',
            'bordo'=>'#2d0226',
            'gri'=>'#8a8a8a',
            'mor'=>'#2f0f03',
            ];
        return isset($colors[$colorkey])?$colors[$colorkey]:'#000000';
    }
    private static function getFilterProviders(\Illuminate\Database\Query\Builder $query){
        /**
         * filtre içimnde bulunan Üreticiler
         */
        $whereIn = $query->toSql();
        $query = DB::table('product');
        $where = DB::raw("`id` IN ($whereIn) ");
        $query->whereRaw($where);
        $query->select('idProvider');
        $query->distinct('idProvider');
        $whereIn = $query->toSql();
        /**
         * Üretici bilgileri
         */
        $query = DB::table('provider');
        $where = DB::raw("`id` IN ($whereIn) ");
        $query->whereRaw($where);
        $query->select(['id', 'providerName', 'logo']);
        return $query->get();
    }
    private static function calculatePrice( $product ){
        if(!defined('MEMBER_TYPE')) define('MEMBER_TYPE',0);
        if(isset($product->calculated)) return $product->sale_price;
        if($product["idCurrency"]== CurrencyCodes::TL){
            $multipy = 1;
        } else {
            $multipy = self::getCurrencyValue($product["idCurrency"]);
        }
        $ziyaretciKatsayi = 1;
        $basepricetype = '';
        if(MEMBER_TYPE==MemberTypes::BAYI){
            $basepricetype = 'salePrice2';
            $basePrice =  $product["salePrice2"];
        } else if(MEMBER_TYPE==MemberTypes::UYE){
            $basepricetype = 'salePrice';
            $basePrice =  $product["salePrice"];
        } else {
            $ziyaretciKatsayi = self::getZiyaretciKatsayi();
            if(empty($ziyaretciKatsayi)) $ziyaretciKatsayi = 1.05;
            $basePrice =  $product["salePrice"];
            $basepricetype = 'salePrice';
        }
        $oldPrice = $product->oldPrice;
        $taxRate = self::getTaxValue($product["idTax"]);
        $salePrice = ($basePrice*$multipy*$ziyaretciKatsayi);
        $salePrice = $salePrice + ($salePrice*($taxRate/100));
        $oldPrice = ($oldPrice*$multipy*$ziyaretciKatsayi);
        $oldPrice = $oldPrice + ($oldPrice*($taxRate/100));

        $product->calculated = true;
        $product->sale_price = $salePrice;
        $product->old_price = $oldPrice;
        return [
            'sale_price'=>$salePrice,
            'old_price'=>$oldPrice,
            'formatted_sale_price'=>number_format($salePrice, 2, ',', '.').'₺',
            'formatted_old_price'=>number_format($oldPrice, 2, ',', '.').'₺',
            'formula'=>"sale_price(".number_format($salePrice,2).")=($basePrice*$multipy*$ziyaretciKatsayi)+%$taxRate KDV, alan: $basepricetype"
        ];
    }
    private static function tlToUsd($tl){
        $multipy = self::getCurrencyValue(\CurrencyCodes::USD);
        return ($tl/$multipy);
    }
    public static function getZiyaretciKatsayi() {
        if(defined('ZiyaretciKatsayi')) return ZiyaretciKatsayi;
        $ziyaretciKatsayi = 1;
        $query = DB::table('settings_general');
        $query->select('ziyaretciKatsayi');
        $query->offset(0);
        $query->limit(1);
        $row = $query->first();
        if($row && (float)$row->ziyaretciKatsayi>0){
            define('ZiyaretciKatsayi', $row->ziyaretciKatsayi);
            $ziyaretciKatsayi = $row->ziyaretciKatsayi;
        }
        return $ziyaretciKatsayi;
    }
    public static function getTaxValue($idTax = 0) {
        $taxValue = 0;
        $query = DB::table('tax_settings');
        $query->select('taxValue');
        $query->offset(0);
        $query->limit(1);
        $query->where(['id'=>$idTax]);
        $row = $query->first();
        if($row && (float)$row->taxValue>0){
            $taxValue = $row->taxValue;
        }
        if(empty($taxValue))$taxValue = 20;
        return $taxValue;
    }
    public static function getCurrencyValue($idCurrency = 0) {
        if(defined('CurrencyValue')) return CurrencyValue;
        $currencyValue = 1;
        $query = DB::table('settings_general');
        $query->select('sabitKur');
        $query->offset(0);
        $query->limit(1);
        $row = $query->first();
        if($row && (float)$row->sabitKur>0)
        {
            define('CurrencyValue', $row->sabitKur);
            $currencyValue = $row->sabitKur;
        } else {
            $sql = "SELECT `value1` FROM currency_values where idCurrency=? order by date desc LIMIT 1";
            $query = DB::table('currency_values');
            $query->select('value1');
            $query->where(['idCurrency'=>$idCurrency]);
            $query->offset(0);
            $query->limit(1);
            $query->orderBy('date', 'DESC');
            $row = $query->first();
            if($row && (float)$row->value1>0){
                define('CurrencyValue', $row->value1);
                $currencyValue = $row->value1;
            }
        }
        return $currencyValue;
    }
    public static function getProviders(){
        $result = [];
        $query = DB::table('provider');
        $query->where(['show_footer'=>1]);
        $rows = $query->get();
        if($rows){
            foreach ($rows as $item) {
                $item->logo = \Amele::getCdnImageUrl($item->logo, 100,100);
                $result['items'][] = $item;
            }
        }
        return $result;

    }
    public static function getBreadCramps($idProduct){
        $query = DB::table('product_categories');
        $query->select('idCategory');
        $query->where(['idProduct'=>$idProduct]);
        $query->orderByDesc('idCategory');
        $row = $query->first();
        if($row){
            $category = Category::getCategory($row->idCategory);
            if($category && $category->bread_cramps){
                $bread_cramps = [];
                foreach($category->bread_cramps as $bread_cramp){
                    $bread_cramps[] = '<li>'.$bread_cramp.'</li>';
                }
                return implode('', $bread_cramps);
            }
        }
        return '';

    }
    public static function getReviews($idProduct){
        $query = DB::table('product_reviews');
        $query->orderByDesc('date');
        $query->where(['idProduct'=>$idProduct, 'isQuestion'=>0, 'active'=>1]);
        return $query->get();
    }
    public static function getReviewsCount($idProduct){
        $query = DB::table('product_reviews');
        $query->where(['idProduct'=>$idProduct, 'isQuestion'=>0, 'active'=>1]);
        return $query->count();
    }
    public static function getReviewsAverage($idProduct){
        $query = DB::table('product_reviews');
        $query->select('reviewPoint');
        $query->where(['idProduct'=>$idProduct, 'isQuestion'=>0, 'active'=>1]);
        return $query->average('reviewPoint');
    }
    public static function getQuestions($idProduct){
        $query = DB::table('product_reviews');
        $query->orderByDesc('date');
        $query->where(['idProduct'=>$idProduct, 'isQuestion'=>1]);
        return $query->get();
    }
    public static function getQuestionCount($idProduct){
        $query = DB::table('product_reviews');
        $query->where(['idProduct'=>$idProduct, 'isQuestion'=>1]);
        return $query->count();
    }
    /*
        private static function getFilterCategories(\Illuminate\Database\Query\Builder $query){
            /-**
             * filtre içimnde bulunan kategoriler
             *-/
            $whereIn = $query->toSql();
            $query = DB::table('product_categories');
            $where = DB::raw("`idProduct` IN ($whereIn) ");
            $query->whereRaw($where);
            $query->select('idCategory');
            $query->distinct('idCategory');
            $whereIn = $query->toSql();
            /-**
             * Kategori bilgileri
             *-/
            $query = DB::table('category');
            $where = DB::raw("`id` IN ($whereIn) ");
            $query->whereRaw($where);
            $query->select(['id', 'idTop', 'categoryName', 'logo']);
            $rows = $query->get();
            $result = Category::getChildCategories($rows, 0);
            return $result;
        }*/
}
