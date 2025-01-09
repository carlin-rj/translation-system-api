<?php

declare(strict_types=1);

namespace Modules\Translation\Services;

use App\Helpers\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Translation\Http\Requests\ProjectCreateRequest;
use Modules\Translation\Http\Requests\ProjectUpdateRequest;
use Modules\Translation\Models\Project;

class ProjectService
{
    /**
     * @return Collection<int, Project>
     */
    public function all(): Collection
    {
        //获取待翻译和已翻译的数量
        return Project::query()->withCount(['translations', 'translatedTranslations'])->get();
    }

    public function create(ProjectCreateRequest $request): Project
    {
		/** @var Project $project */
		$project = DB::transaction(function () use ($request) {
			/** @var Project $project */
			$project =  Project::query()->create([
				'key' => $request->key,
				'name' => $request->name,
				'description' => $request->description,
				'status' => 1
			]);

			//生成token
			$token = $project->createToken($project->key);
			$project->api_token = $token->plainTextToken;
			$project->save();
			return $project;
		});

        return $project;
    }

    public function update(ProjectUpdateRequest $request): void
    {
        $project = Project::findOrFail($request->id);
        $project->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
    }

    public function delete(int $id): void
    {
        Project::findOrFail($id)->delete();
    }
}
