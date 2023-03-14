<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use App\Providers\GiwuService;
use App\Models\Associeragent;

class GiwuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        GiwuService::BrowserControl();
        ///Application en cours de maintenance
        // if(trans('data.maintenance') == "oui"){
        //     return Redirect::to('webmaint');
        // }
        
        ///Controle sur les sessions
        if(!session('InfosAgent')){
            Session()->forget('InfosAgent');  
            return Redirect::to('/');
        }elseif(session('DateCnx') != date('Y-m-d') ){
            Session()->forget('InfosAgent');  
            return Redirect::to('/');
        }
        $assCh = Associeragent::where('agent_id',session('InfosAgent')->id_ag)->get()->count();
        if($assCh == 0){
            Session()->forget('InfosAgent');  
            return Redirect::to('/');
        }
        return $next($request);
    }
}
