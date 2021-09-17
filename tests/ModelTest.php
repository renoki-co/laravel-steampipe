<?php

namespace RenokiCo\LaravelSteampipe\Test;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RenokiCo\LaravelSteampipe\Aws\IamRole;

class ModelTest extends TestCase
{
    public function test_retrieve()
    {
        $this->assertInstanceOf(Collection::class, DB::table('aws_iam_role')->get());

        foreach (IamRole::all() as $iam) {
            $this->assertInstanceOf(IamRole::class, $iam);
        }
    }

    public function test_model_generation()
    {
        $this->artisan('steampipe:make:model', ['name' => 'aws_region']);

        $this->assertTrue(class_exists(\App\Steampipe\Aws\AwsRegion::class));
        $this->assertInstanceOf(Collection::class, \App\Steampipe\Aws\AwsRegion::all());
    }
}
