<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchData;
use App\Http\Resources\SearchResource as SearchResource;
use App\Http\Resources\FetchResource as FetchResource;

class SearchController extends Controller
{
    public function getSearchResult(Request $request)
    {
        $searchResult = SearchData::select('id','name')->where('name', 'like', '%'.$request->searchData.'%');
        if($searchResult->exists())
        {
            $result = array('statuscode'=>200);
            $result ['data'] = SearchResource::collection($searchResult->get());
            return $result;
        }
        else
        {
            $result = array('statuscode'=>404);
            return json_encode($result);
        }
    }
    public function getFetchResult(Request $request)
    {
        $fetchResult = SearchData::where('id',$request->id);
        if($fetchResult->exists())
        {
            $result = array('statuscode'=>200);
            $result ['data'] = FetchResource::collection($fetchResult->get());
            return $result;
        }
        else
        {
            $result = array('statuscode'=>404);
            return json_encode($result);
        }
    }
}
