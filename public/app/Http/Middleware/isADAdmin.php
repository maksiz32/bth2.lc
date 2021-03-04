<?php
namespace App\Http\Middleware;

use Closure;
use Adldap\Laravel\Facades\Adldap;

class isADAdmin
{
    public function handle($request, Closure $next)
    {
        $userName = getenv('REMOTE_USER');
        $userADName = Adldap::search()->users()->where('samaccountname', '=', $userName)->first();
        $adGroups = $userADName->getGroupNames($recursive = true);
        if (in_array('bryansk_portal_admins', $adGroups)) {
        return $next($request);
        }
        
        return redirect('/sorry');
    }
}
