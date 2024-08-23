<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Imports\CategoriesImport;
use Auth;
use Validator;
use Carbon\Carbon;
use DataTables;
use Response;
use Excel;
use DB;
use Image;


class CategoryController extends Controller
{
    public function index($catId="")
    {
        $catId = isset($_GET['catId']) ? $_GET['catId'] : "";
        $catTitle = [];

        if(!empty($catId))
        {
            $category = Category::findOrFail($catId);
            if(!empty($category))
            {
                $catIds = explode(',',$category->category_path);

                foreach($catIds as $categoryId)
                {
                    $catDetails = Category::select('title','id as category_id')
                                            ->where('id',$categoryId);
                    $catDetails = $catDetails->first();
                    array_push($catTitle,$catDetails);
                }
            }
        }//pre($catTitle);
        $baseUrl=$this->getBaseUrl();
        return view("admin.category.index", compact('catId','baseUrl','catTitle'));
    }

    public function list(Request $request)
    {
        $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_edit');
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_delete');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', '', 'title','slug','','','sort_order'];
        if(isset($req['catId']) && $req['catId']!='')
        $total = Category::selectRaw('count(*) as total')->where('parent_id',$req['catId'])->whereNull('deleted_at')->first();
        else
        $total = Category::selectRaw('count(*) as total')->where('parent_id',0)->whereNull('deleted_at')->first();
        $query = Category::whereNull('deleted_at');
        if(isset($req['catId']) && $req['catId']!=''){
        $query = Category::where('parent_id',$req['catId']);
        $filteredq = Category::where('parent_id',$req['catId']);
        }
        else{
        $query = Category::where('parent_id',0);
        $filteredq = Category::where('parent_id',0);
        }
        $filteredq = Category::whereNull('deleted_at');
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('title', 'like', '%' . $search . '%');
                $query2->orWhere('slug', 'like', '%' . $search . '%');
            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('title', 'like', '%' . $search . '%');
                $query2->orWhere('slug', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $isActive = '';
            $action = '';
            $editUrl = route('editCategory', $value->id);
            if ($value->status == 1) {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle active toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="true" autocomplete="off"><div class="handle"></div></button>';
            } else {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div></button>';
            }
            $edit = '<li class="nav-item">'
            .'<a class="nav-link" href="' . $editUrl . '">Edit</a>'
        .'</li>';
            $activeInactive = ($isEditable)?'<li class="nav-item">'
                .'<a class="nav-link active-inactive-link" >Mark as '.(( $value->status == '1')?'Inactive':'Active').'</a>'
            .'</li>':'';

            $delete = ($isDeletable)?'<li class="nav-item">'
                        .'<a class="nav-link category_delete" data-id="' . $value->id . '">Delete</a>'
                    .'</li>':'';
            if ($activeInactive || $delete) {
                $action .= '<div class="d-inline-block dropdown">'
                    .'<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                        .'<span class="btn-icon-wrapper pr-2 opacity-7">'
                            .'<i class="fa fa-cog fa-w-20"></i>'
                        .'</span>'
                    .'</button>'
                    .'<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                        .'<ul class="nav flex-column">'
                        .$edit.$activeInactive.$delete
                        .'</ul>'
                    .'</div>'
                .'</div>';
            }
            $baseUrl=$this->getBaseUrl();
            $titleLink='<a href="'.url(config('app.adminPrefix').'/category/index/?catId='.$value->id).'">'.$value->title.'</a>';
            $image = '<img width="50" height="50" src='.Category::getCategoryIcon($value->id).'/>';
            $classRow = $value->status?"":"row_inactive";
            $data[] = [$classRow,$action,$titleLink,$value->slug,$image, $isActive,$value->sort_order];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }


    public function add($catId = null)
    {
        $model = new Category;
        $catId = isset($_GET['catId']) ? $_GET['catId'] : "";
        $catTitle=[];
        if(!empty($catId))
        {
            $category = Category::findOrFail($catId);
            if(!empty($category))
            {
                $catIds = explode(',',$category->category_path);

                foreach($catIds as $categoryId)
                {
                    $catDetails = Category::select('title','id as category_id')->where('id',$categoryId);
                    $catDetails = $catDetails->first();
                    array_push($catTitle,$catDetails);
                }
            }
        }//dd($catTitle);
        $model->sort_order = Category::getSortOrder();

        return view('admin.category.form', compact('model','catId','catTitle'));
    }

    public function store(Request $request)
    { //dd($request);
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'title' => 'required',
                'sort_order' => 'required',
                'icon' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]
        );

        if ($validator->fails())
        {
            $notification = array(
                'message' => 'Validation Required!',
                'alert-type' => 'error'
            );
            return redirect(config('app.adminPrefix').'/category/index')->with($notification);

        }
        else
        {
            $cat = new Category();
            $cat->title = $request->title;
            if(!empty($request->catId))
                $cat->parent_id = $request->catId;
            else
                $cat->parent_id = 0;
            $string=$request->slug;
            $cat->slug = getSlug($string,"",'categories','slug');
            $cat->description = $request->description;
            $cat->sort_order = $request->sort_order;

            if ($request->hasFile('icon')) {
                $fileObject = $request->file('icon');
                $image = Category::uploadAndSaveImage($fileObject);
                // $input['image'] = $image;
                $cat->icon = $image;
            }else{
                if (isset($input['icon'])) {
                    unlink($input['icon']);
                }
            }
            // if ($request->hasFile('image')) {
            //     $photo = $request->file('image');
            //     $ext = $photo->extension();
            //     $filename = rand().'_'.time().'.'.$ext;
            //     $filePath = public_path().'/admin/music_category/';
            //     $img = Image::make($photo->path());
            //     $width = config('app.musicCategoryIconDimension.width');
            //     $height = config('app.musicCategoryIconDimension.height');
            //     if($img->width() == $width && $img->height() == $height){
            //         $photo->move($filePath.'/', $filename);
            //     }else{
            //         $img->resize($width, $height)->save($filePath.'/'.$filename);
            //     }
            //     $cat->image = $filename;
            // }
            $cat->status = $request->status;
            if($cat->save()){
              if(!empty($request->catId))
              {
                  $catPath = Category::findOrFail($request->catId);
                  $cat->category_path = $cat->id.','.$catPath->category_path;
                  //$catPath->flag_category = 1;
                  $catPath->save();
              }
              else
                  $cat->category_path = $cat->id;
            }
            $cat->update();

            $notification = array(
                'message' => 'Category added successfully!',
                'alert-type' => 'success'
            );
            if(!empty($request->catId))
            return redirect(config('app.adminPrefix').'/category/index?catId='.$request->catId)->with($notification);
            else
            return redirect(config('app.adminPrefix').'/category/index')->with($notification);
        }
    }

    public function edit($id)
    {
        $model = Category::findOrFail($id);
        $catId = $id;
        $catTitle=[];
        if(!empty($catId))
        {
            $category = Category::findOrFail($catId);
            if(!empty($category))
            {
                $catIds = explode(',',$category->category_path);

                foreach($catIds as $categoryId)
                {
                    $catDetails = Category::select('title','id as category_id')
                                            ->where('id',$categoryId);
                    $catDetails = $catDetails->first();
                    array_push($catTitle,$catDetails);
                }
            }
        }//pre($catTitle);
        $icon=Category::getCategoryIcon($id);
        $baseUrl=$this->getBaseUrl();
        return view('admin.category.form', compact('model','baseUrl','catTitle','catId','icon'));
    }

    public function update(Request $request, $id)
    {
       /* try {
            $model = Category::findOrFail($id);
            $input = $request->all();
            $model->update($input);
            $notification = array(
                'message' => 'Music category updated successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix').'/music-categories/index')->with($notification);
        } catch (\Exception $e) {
            return redirect(config('app.adminPrefix').'/music-categories/index');
        }*/
        $home = Category::findOrFail($id);
        if (!empty($home)) {
            $home->title = $request->title;
            $home->slug = $request->slug;
            $home->description = $request->description;
            $home->sort_order = $request->sort_order;
            if ($request->hasFile('icon')) {
                $fileObject = $request->file('icon');
                $image = Category::uploadAndSaveImage($fileObject,$id);
                // $input['image'] = $image;
                $home->icon = $image;
            }else{
                if (isset($input['icon'])) {
                    unlink($input['icon']);
                }
            }
            // if ($request->hasFile('image')) {
            //     $photo = $request->file('image');
            //     $ext = $photo->extension();
            //     $filename = rand().'_'.time().'.'.$ext;
            //     $filePath = public_path().'/admin/music_category/';
            //     $img = Image::make($photo->path());
            //     $width = config('app.musicCategoryIconDimension.width');
            //     $height = config('app.musicCategoryIconDimension.height');
            //     if($img->width() == $width && $img->height() == $height){
            //         $photo->move($filePath.'/', $filename);
            //     }else{
            //         $img->resize($width, $height)->save($filePath.'/'.$filename);
            //     }
            //     $home->image = $filename;
            // }
            //$home->sort_order = $request->sortOrder;
            $home->status = $request->status;
            $home->save();

            $notification = array(
                'message' => 'Category updated successfully!',
                'alert-type' => 'success'
            );

            if(!empty($request->catId))
            return redirect(config('app.adminPrefix').'/category/index?catId='.$home->parent_id)->with($notification);
            else
            return redirect(config('app.adminPrefix').'/category/index')->with($notification);
        }
    }

    public function activeInactive(Request $request)
    {
        try {
            $model = Category::where('id', $request->categories_id)->first();
            if ($request->status == 1) {
                $model->status = $request->status;
                $msg = "Category Activated Successfully!";
            } else {
                $model->status = $request->status;
                $msg = "Category Deactivated Successfully!";
            }
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = $msg;
            return $result;
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }

    public function delete(Request $request)
    {
        $model = Category::where('id', $request->categories_id)->first();
        if (!empty($model)) {
            $model->deleted_at = Carbon::now();
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = "Category Deleted Successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
    /* ###########################################
    // Function: exportCategory
    // Description: Display import form for category
    // Parameter: No parameter
    // ReturnType: view
    */ ###########################################
    public function getimportCategoryForm($catId = null)
    {
        $catId = isset($_GET['catId']) ? $_GET['catId'] : "";
        //$catId = isset($_GET['catId']) ? $_GET['catId'] : "";
        $catTitle=[];
        if(!empty($catId))
        {
            $category = Category::findOrFail($catId);
            if(!empty($category))
            {
                $catIds = explode(',',$category->category_path);

                foreach($catIds as $categoryId)
                {
                    $catDetails = Category::select('title','id as category_id')->where('id',$categoryId);
                    $catDetails = $catDetails->first();
                    array_push($catTitle,$catDetails);
                }
            }
        }
        return view('admin.category.import',compact('catId','catTitle'));
    }

    /* ###########################################
    // Function: importCategory
    // Description: Display import form for category
    // Parameter:  File
    // ReturnType: view
    */ ###########################################
    public function importCategory(Request $request)
    {
        try{
            if($request->hasFile('import_category_file'))
            {
                $import = new CategoriesImport;
                Excel::import($import, $request->file('import_category_file'));
                $collection = $import->getCommon();

                $counter = 0;
                $errors = [];
                $suc_uploaded = [];
                $fail_uploaded = [];
                foreach($collection as $row)
                {
                    $counter++;
                    $flag = 'true';
                    if($row[0] == "" ||  $row[2]=="")
                    {
                        $errors[] = "Record is incomplete for Row - ".$counter.". Please try again.";
                        $flag = 'false';
                    }
                    if($flag == 'true')
                    {
                        $category = new Category;
                        if ($row[2] == 'active') {
                            $category->status =1;
                        }
                        else
                        $category->status =0;
                        $category->title =  $row[0];
                        $category->description = $row[1];
                        if(!empty($request->catId))
                            $category->parent_id = $request->catId;
                        else
                            $category->parent_id = 0;
                            $category->slug = strtolower(trim(preg_replace('/[\s-]+/', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $row[0]))))), '-'));
                            $category->sort_order = Category::getSortOrder();
                            if($category->save())
                            {
                                $category->slug = getSlug($category->slug,"",'categories','slug',$category->id);
                                if(!empty($request->catId))
                                {
                                    $catPath = Category::findOrFail($request->catId);
                                    $category->category_path = $category->id.','.$catPath->category_path;
                                    //$catPath->flag_category = 1;
                                    $catPath->save();
                                }
                                else
                                    $category->category_path = $category->id;
                                $category->update();
                                $suc_uploaded[] = $counter;
                            }
                    }
                    else
                    {
                        $fail_uploaded[] = $counter;
                    }
                }
                return redirect()->back()->with('msg', $errors)->with('success', $suc_uploaded)->with('faile', $fail_uploaded);
            }
        } catch(\Maatwebsite\Excel\Validators\ValidationException $ex) {
            return view('errors.500');
        }

    }
}
