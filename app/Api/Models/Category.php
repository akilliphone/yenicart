<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;


class Category extends Model{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product';
    protected $fillable = [
    ];

    protected $hidden = [
    ];
    public static function getCategory($idCategory){
        $result = [];
        $query = DB::table('category');
        $query->select(['id', 'idTop', 'categoryName', 'logo']);
        $query->where(['id'=>$idCategory]);
        $row = $query->first();
        if($row){
            $query = DB::table('category');
            $query->select(['id', 'idTop', 'categoryName', 'logo']);
            $query->where('active', 1);
            $rows = $query->get();
            $row->children = self::getChildCategories($rows, $idCategory);
            $filters = [$idCategory];
            if($row->children){
                foreach($row->children as $child){
                    $filters[] = $child->filter;
                }
            }
            $row->bread_cramps = self::generateBreadcrumb($rows, $row->id);
            $row->filter = implode(',', $filters);
            $row->logo = \Amele::getCdnImageUrl($row->logo, 100,100);
            $result = $row;
        }
        return $result;
    }

    public static function getCategories($params=[]) {
        $query = DB::table('category');
        $query->select(['id', 'idTop', 'categoryName', 'logo', 'orderNumber']);
        $query->orderBy(DB::raw("`orderNumber` <= 0 "));
        if(isset($params['orderby'])){
            if(isset($params['dir'])){
                $query->orderBy($params['orderby'], $params['dir']);
            } else {
                $query->orderBy($params['orderby'], 'asc');
            }
        }
        $query->where('active', 1);
        $rows = $query->get();
        $result = self::getChildCategories($rows, 0);
        return $result;
    }
    public static function getChildCategories($items, $parentId = 0) {
        $tree = array();
        foreach ($items as $item) {

            if ($item->idTop == $parentId) {
                $ids = [$item->id];
                $children = self::getChildCategories($items, $item->id);
                if ($children) {
                    $item->children = $children;
                    foreach($children as $child){
                        $ids[$child->id] =  $child->id;
                        foreach (explode(',', $child->filter) as $filter){
                            $ids[$filter] =  $filter;
                        }
                    }
                } else {
                    $item->children = [];
                }
                $item->bread_cramps = self::generateBreadcrumb($items, $item->id);
                $item->filter = implode(',', $ids);
                $item->image = \Amele::getCdnImageUrl($item->logo, 100,100);
                $item->url = \Amele::getCategoryUrl($item);
                //$item->bread_cramps = self::generateBreadcrumb($items, $item->id);
                $tree[] = $item;
            }
        }
        return $tree;
    }
    private static function generateBreadcrumb($categories, $categoryId) {
        $breadcrumbs = [];
        $currentCategoryId = $categoryId;
        while ($currentCategoryId != null) {
            $category = null;
            foreach ($categories as $cat) {
                if ($cat->id == $currentCategoryId) {
                    $category = $cat;
                    break;
                }
            }
            if ($category) {
                array_unshift($breadcrumbs, '<a href="'.\Amele::getCategoryUrl($category).'">'.$category->categoryName.'</a>');
                $currentCategoryId = $category->idTop;
            } else {
                break;
            }
        }
        foreach($breadcrumbs as $breadcrumbkey=>$breadcrumb){
            $breadcrumbs[$breadcrumbkey] = $breadcrumb;
        }
        //$breadcrumbString = implode("  ", $breadcrumbs);
        return $breadcrumbs;
    }

}
