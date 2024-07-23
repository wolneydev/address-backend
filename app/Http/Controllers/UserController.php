<?php
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\UserService;


class UserController extends Controller { 

    protected $user_service;
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function index(Request $request){
        return $this->user_service->index($request);
    }
    public function store(Request $request)
    {        
        return $this->user_service->store($request);   
    }

    public function show($id)
    {
        return $this->user_service->show($id);       
    }

    public function update(Request $request, $id)
    { 
        return $this->user_service->update($request,$id);           
    }

    public function destroy($id)
    {
        return $this->user_service->destroy($id);              
    }       
}
