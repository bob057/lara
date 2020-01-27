<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    public function complete()
    {
        $this->completed_at = now();
        $this->save();
    }

    public function test()
    {
        echo("test");
    }
}
