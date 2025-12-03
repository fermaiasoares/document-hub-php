<?php
namespace Versatecnologia\DocumentHub\Facades;

use Illuminate\Support\Facades\Facade;

class DocumentHub extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'document-hub';
    }
}