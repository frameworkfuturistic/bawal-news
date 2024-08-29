<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BreakingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreakingRequest;
use App\Models\{Breaking, Language, Term};
use App\Services\BreakingService;
use Illuminate\Http\{JsonResponse, Request, Response};
use Illuminate\Support\Facades\{Auth, Gate, Validator};
use Illuminate\Validation\Rule;


class BreakingController extends Controller
{
   private $breakingService;
    
   /**
    * __construct
    *
    * @param  mixed $termService
    * @return void
    */
   public function __construct(BreakingService $breakingService)
   {
       $this->breakingService = $breakingService;

      //  $this->middleware('permission:read-tags', ['except' => ['ajaxSearch']]);
      //  $this->middleware('permission:add-tags', ['only' => ['store']]);
      //  $this->middleware('permission:update-tags', ['only' => ['update']]);
   }
   
   /**
    * ajaxSearch
    *
    * @return void
    */
   public function ajaxSearch(){
       $language = request('lang');
      //  $data = $this->termService->showTermForSelectOption(10, $language, 'tag');
      //  return response()->json($data);
      $data = $this->breakingService->showTermForSelectOption(10, $language, 'tag');
      return response()->json($data);
   }
   
   /**
    * ajaxCategorySearch
    *
    * @return void
    */
   public function ajaxCategorySearch()
   {
      //  if(request()->filled('q')) {
      //      $data = Term::select('name','id')->tag()->where('language_id', request('lang'))->searchName(request()->get('q'))->limit(5)->get();
      //  } else {
      //      $data = Term::select('name','id')->tag()->where('language_id', request('lang'))->limit(5)->get();
      //  }

      //  return response()->json($data);

      $records = $this->breakingService->getBreakingNews();
      return response()->json($records);
   }

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index(BreakingDataTable $dataTable)
   {
       $language = Auth::user()->language;
       $languages = Language::whereActive('y')->get();
       return $dataTable->render( 'admin.breaking.index', compact('language', 'languages'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param TagRequest $request
    * @return JsonResponse
    */
   public function store(Request $request)
   {
       $validator = Validator::make($request->all(), [
         //   'name'  => ['required', 'min:3', Rule::unique('terms', 'name')->where(function ($query) use ($request) {
         //       return $query->whereTaxonomy('tag')->where('language_id', $request->language);
         //   })]
         // 'name'  => ['required', 'min:3'],
         'description'  => ['required', 'min:3'],
       ]);

       $resp = [];

       if ($validator->fails()) {
           $resp[] = ['trans' => $validator->errors()];
       }

       return $this->breakingService->save($request, $resp);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param TagRequest $request
    * @param Term $tag
    * @return JsonResponse
    */
   public function update(Request $request, $id)
   {
      //  $term = Term::tag()->find($id);

      //  $validator = Validator::make(request()->all(), [
      //      'name' => ['required','min:3', Rule::unique('terms', 'name')->where(function ($query) use ($request) {
      //          return $query->whereTaxonomy('tag')->where('language_id', $request->language);
      //      })->ignore($term->id)]
      //  ]);

      //  $resp = [];

      //  if ($validator->fails()) {
      //      $resp[] = [ 'trans' => $validator->errors() ];
      //  }

      //  return $this->termService->modify($request, $term, 'tag', $resp);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param Term $tag
    * @return JsonResponse
    */
   public function destroy($id)
   {
      //  if (!Gate::allows('delete-tags')) {
      //      return response()->json(['error' => __('message.dont_have_permission')]);
      //  }

       $record = Breaking::tag()->find($id);

       $this->breakingService->remove($record);

       return response()->json(['success' => __('message.deleted_successfully')]);
   }
   
   /**
    * massdestroy
    *
    * @return void
    */
   public function massdestroy()
   {
      //  if (! Gate::allows('delete-tags')) {
      //      return response()->json(['error' =>  __('message.dont_have_permission')]);
      //  }

      //  $tags  = $this->termService->massRemove('tag');

      //  if($tags->delete()) {
      //      return response()->json(['success' =>  __('message.deleted_successfully')]);
      //  } else {
      //      return response()->json(['error' =>  __('message.deleted_not_successfully')]);
      //  }
   }
}
