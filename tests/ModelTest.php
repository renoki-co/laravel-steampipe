<?php

namespace RenokiCo\LaravelSteampipe\Test;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RenokiCo\LaravelSteampipe\Test\Aws\AwsRegion;

class ModelTest extends TestCase
{
    public function test_retrieve()
    {
        $this->assertInstanceOf(Collection::class, DB::table('aws_region')->get());

        foreach (AwsRegion::all() as $region) {
            $this->assertInstanceOf(AwsRegion::class, $region);
        }

        $this->assertNotNull(AwsRegion::where('name', 'eu-central-1')->first());
    }

    public function test_model_generation()
    {
        $this->artisan('steampipe:make:model', ['name' => 'aws_region']);

        $this->assertTrue(class_exists(\App\Steampipe\Aws\AwsRegion::class));
        $this->assertInstanceOf(Collection::class, \App\Steampipe\Aws\AwsRegion::all());
    }
}
