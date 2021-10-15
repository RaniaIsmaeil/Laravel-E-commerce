<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\Item;
use App\Http\Requests\AddItemRequest;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $items = Item::with('category')->orderBy('item_name', 'ASC')->get();
            if($items){
                return response()->json([
                    'data'=> $items
                ],200);
            }
            return response()->json([
                'item'=>"empty"
            ],404);
        }
        catch(\Exception $e){
            return response()->json([
                'message'=>'internal error'
            ],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddItemRequest $request)
    {
        $item = new Item();
        $item->fill($request->all());//because we used fillable
        if($image=$request->file('image'))
        {
          $image=$request->image;
            $image->store('public/images/'. $request->category_id);
            $item->image = $image->hashName();
        }
        if($item->save()){ //returns a boolean
            return response()->json([
                'data'=> $item
            ],200);
        }
        else
        {
            return response()->json([
                'item'=>'item could not be added'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = Item::find($id);
        if($item)
        {
            return response()->json([
                'data'=> $item
            ],200);
        }
        return response()->json([
            'item'=>'item could not be found'
        ],500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
    $item = Item::find($id);
        if($item){
            $item->update($request->all());//because we used fillable
            if($image=$request->file('image'))
            {

                if($this->imageDelete($item->image,$item->category_id)){

                    $image=$request->image;
                    $cat =  is_null($request->category_id)? $item->category_id: $request->category_id;
                    $image->store('public/images/'. $cat);
                    $item->image = $image->hashName();
                }
                else
                {
                    $image=$request->image;
                    $cat =  is_null($request->category_id)? $item->category_id: $request->category_id;
                    $image->store('public/images/'. $cat);
                    $item->image = $image->hashName();
                }
            }
            if($item->save()){ //returns a boolean
                return response()->json([
                    'data'=> $item
                ],200);
            }
            else
            {
                return response()->json([
                    'item'=>'item could not be updated'
                ],500);
            }
        }
        return response()->json([
            'item'=>'item could not be found'
        ],500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if($item->delete()){ //returns a boolean
            if($this->imageDelete($item->image,$item->category_id)){
                var_dump('got deleted');
            }
            else
            {
                var_dump('didnt delete');
            }
            return response()->json([
                'item'=> "good for you"
            ],200);
        }
        else
        {
            return response()->json([
                'item'=>'item could not be deleted'
            ],500);
        }
    }
        public function imageDelete($oldImage, $cat_id)
    {
        if(File::exists(public_path('storage/images/'. $cat_id .'/'. $oldImage)))
        {
            File::delete(public_path('storage/images/'. $cat_id . '/' . $oldImage));
            return true;
        }
        else
        {
            return false;
        }
    }
    }

