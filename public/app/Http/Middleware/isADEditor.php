<?php
namespace App\Http\Middleware;

use Closure;
use Adldap\Laravel\Facades\Adldap;

class isADEditor
{
    public function handle($request, Closure $next)
    {
        $userName = getenv('REMOTE_USER');
        $userADName = Adldap::search()->users()->where('samaccountname', '=', $userName)->first();
        $adGroups = $userADName->getGroupNames($recursive = true);
        if (in_array('bryansk_portal_editors', $adGroups)) {
        return $next($request);
        }
        return redirect('/sorry');
    }
}
