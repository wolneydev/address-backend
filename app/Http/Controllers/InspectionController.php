<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\InspectionRequest;
use App\Services\InspectionService;

class InspectionController extends Controller
{
    protected $inspection_service;
    public function __construct(InspectionService $inspection_service){
        $this->inspection_service = $inspection_service;        
    } 

    public function index(Request $request)
    {    
         return $this->inspection_service->index($request);              
    }

    public function store(InspectionRequest $request)
    {        
        return $this->inspection_service->store($request);   
    }

    public function show($id)
    {
        return $this->inspection_service->show($id);       
    }

    public function update(InspectionRequest $request, $id)
    { 
        return $this->inspection_service->update($request,$id);           
    }

    public function destroy($id)
    {
        return $this->inspection_service->destroy($id);              
    }    
    
}
