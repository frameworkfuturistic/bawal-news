<?php

namespace App\Services;

use App\Models\{Language, Breaking, Theme};
use App\Traits\{ImageTrait, LanguageTrait, TermTrait};
use Cocur\Slugify\Slugify;
use Illuminate\Support\{Arr, Str};
use Psr\Container\{ContainerExceptionInterface, NotFoundExceptionInterface};
use Illuminate\Support\Facades\DB;

Class BreakingService
{
    public function save($request, $resp)
    {
        if ($resp) {
            foreach ($resp as $stat) {
                if ($stat['status'] == 'error') {
                    return response()->json($resp);
                }
            }
        } else {
            $this->insert($request);
        }

        return response()->json(['success' => __('message.saved_successfully')]);        
    }
    
    public function insert($request)
    {
      $record = new Breaking();
      $record->breaking_news = $request->description;
      $record->save();
    }
    
    public function remove($record)
    {
         $record->delete();
    }


    public function getBreakingNews()
    {
      $records = DB::table('breaking_news')->get();
      return $records;
    }
    
}
