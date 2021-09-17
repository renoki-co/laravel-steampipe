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
}
