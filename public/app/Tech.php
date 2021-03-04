<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Categories;

class Tech extends Model
{
    protected $fillable = ['photo','tech','model','category_id'];
    protected $primaryKey = "id";
    
    public static function allTechnics(){
        return DB::select('SELECT * FROM teches LEFT JOIN remains ON teches.id=remains.tech_id ORDER BY category_id');
    }
    
    public static function allCategories() {
        return Categories::all();
    }
    
    public static function allTechWithCategory() {
        return DB::select('SELECT * FROM categories LEFT JOIN teches ON categories.id=teches.category_id ORDER BY categories.id');
    }
    
    public static function getTechsAndRemains() {
        return DB::select('SELECT teches.id as id, teches.photo, teches.tech, teches.model, teches.category_id, remains.count, categories.category FROM teches LEFT JOIN remains ON teches.id=remains.tech_id LEFT JOIN categories ON teches.category_id=categories.id ORDER BY teches.category_id');
    }
    
    public static function destroy($ids) {
        parent::destroy($ids);
    }
}
