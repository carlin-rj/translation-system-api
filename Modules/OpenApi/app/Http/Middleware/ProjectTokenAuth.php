<?php

declare(strict_types=1);

namespace Modules\OpenApi\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Modules\Translation\Models\Project;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ProjectTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();

        if (!$bearerToken) {
            throw new UnauthorizedHttpException('Bearer', '项目令牌不能为空');
        }

		$project = Auth::guard('api_project')->user();
        if (!$project) {
            throw new UnauthorizedHttpException('Bearer', '授权失败');
        }

        return $next($request);
    }
}
