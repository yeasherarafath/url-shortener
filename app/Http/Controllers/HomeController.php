<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Trait\RepoResponse;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Validator;

class HomeController extends Controller implements HasMiddleware
{
    use RepoResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    static function middleware(){
        return [
            new Middleware('auth')
        ];
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        Paginator::useBootstrapFour();
        $urls = Url::paginate(25);
        return view('home',compact('user','urls'));
    }


    public function store(Request $request, $isApi=false){
        
        $validationRule = [
            'url' => 'required|url|max:255'
        ];
        if($isApi){
            $validator = Validator::make($request->all(),$validationRule);
            if($validator->fails()){
                return $this->errorResponse($validator->errors()->first(),null,null,self::BAD_REQUEST);
            }
            $userID = auth('api')->id();
        }else{
            $userID = auth()->id();
            $request->validate($validationRule);
        }

        $url_trim = trim($request->url);

        

        

        
        try {
            $urlCheck = Url::where('long_url',$url_trim)->where('user_id',$userID);
            
            if($urlCheck->exists()){
                $errMsg = 'Short URL already generate for this url';
                if($isApi){
                    return $this->errorResponse($errMsg,null,null,self::BAD_REQUEST);
                }else{
                    return back()->withError($errMsg)->withInput();
                }
            }
            
            do {
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                $rand_str = str_shuffle($str);
                $hashids = new Hashids(Str::random(70),6,$rand_str);
                $uid = $hashids->encode(Url::max('id')+1);
            } while (Url::where('short_code',$uid)->exists());

            $url = new URL;
            $url->long_url = $url_trim;
            $url->short_code = $uid;
            $url->user_id = $userID;
            $url->save();
            $shortURL = route('short.url',['url' => $uid]);
            if($isApi){
                // return response(['success' => true,'short_url' => $shortURL]);
                return $this->successReponse('new url shorted',[
                    'short_url' => $shortURL
                ]);
            }else{
                return back()->with([
                    'short_url' => $shortURL
                ])->withSuccess('URL Shorted Successfully');
            }
        } catch (\Throwable $th) {
            // throw $th;
            $errMsg = 'Failed to Short URL';
            if($isApi){
                return $this->errorResponse($errMsg,null,null,self::BAD_REQUEST);
            }else{
                return back()->withError($errMsg);
            }
        }
    }
}
