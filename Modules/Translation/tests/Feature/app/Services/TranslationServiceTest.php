<?php

namespace Modules\Translation\Tests\Feature\app\Services;

use Modules\Translation\Enums\ExportTypeEnum;
use Modules\Translation\Http\Requests\ExportTranslationRequest;
use Modules\Translation\Services\TranslationService;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    protected TranslationService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new TranslationService();
    }


    public function testLaravelExportTranslation()
    {
        $request = new ExportTranslationRequest();
        $request->type = ExportTypeEnum::LARAVEL;
        $request->project_key = 'wms';
        $result = $this->service->exportTranslation($request);
        $this->assertFileExists($result);
    }


    public function testVueExportTranslation()
    {
        $request = new ExportTranslationRequest();
        $request->type = ExportTypeEnum::VUE_I18N;
        $request->project_key = 'wms';
        $result = $this->service->exportTranslation($request);
        $this->assertFileExists($result);
    }

	public function testAndroidExportTranslation()
	{
		$request = new ExportTranslationRequest();
		$request->type = ExportTypeEnum::ANDROID;
		$request->project_key = 'wms';
		$result = $this->service->exportTranslation($request);
		$this->assertFileExists($result);
	}
}
