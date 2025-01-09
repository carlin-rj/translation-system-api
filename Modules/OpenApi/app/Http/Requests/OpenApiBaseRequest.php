<?php

namespace Modules\OpenApi\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Translation\Models\Project;

class OpenApiBaseRequest extends BaseRequest
{
	public function project(): Project
	{
		/** @phpstan-ignore-next-line  */
		return Auth::guard('api_project')->user();
	}

}
