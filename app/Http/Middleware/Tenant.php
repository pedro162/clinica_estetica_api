<?php

namespace App\Http\Middleware;

use Closure;
use App\Tenant as TenantModel;
use App\Rca;

class Tenant
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
        $host = $request->headers->get('host');
        $tenent = TenantModel::where('domain','=', trim($host))->first(); //'larave.wip'
        if(!$tenent){
            return redirect()->route('site.home');
        }

        if($request->session()->has('tenant')){

            $sessionTenent = $request->session()->get('tenant');

            if(\Auth::check()){

                if(trim($sessionTenent->domain) !== trim($tenent->domain)){
                    \Auth::logout();
                    //$request->session()->forget('tenant');
                    //return redirect()->url('admin.login');
                }
            }

            if(trim($sessionTenent->domain) !== trim($tenent->domain)){               
                $request->session()->forget('tenant');
                return redirect()->route('admin.login');
            }

            /*
            *   Falta aldicionar mais regras para um tenant não acessar o domíno de outro
            */
            //dd(\Auth::User());
            
        }else{
            $request->session()->put('tenant', $tenent);
        } 

        $retorno = $tenent->configure();
        //dd($retorno);
        
        return $next($request);
    }
}
