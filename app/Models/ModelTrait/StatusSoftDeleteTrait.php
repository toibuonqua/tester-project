<?php

namespace App\Models\ModelTrait;

use Illuminate\Support\Facades\Log;

trait StatusSoftDeleteTrait
{
    private static $deleteStatus = 'STATUS_DELETED';
    private static $isSetDeleteStatus = False;

    public function setDeleteStatus($deleteMarkValue)
    {
        $this->deleteStatus = $deleteMarkValue;
        $this->isSetDeleteStatus = True;
    }

    public function softDelete($willBeSaved = True)
    {
        if (!self::$isSetDeleteStatus) {
            Log::warning("No specific delete Status, using default behavior: set status = self::STATUS_DELETE");
            Log::info("You can set defaultStatus by using setDeleteStatus(\$deleteMarkValue)");
        }

        $deleteStatusTag = self::$deleteStatus;

        // PHP Trait does not have better way to access constant in the classes
        // using this Trait. 
        $this->status = constant("self::$deleteStatusTag");

        if ($willBeSaved) {
            $this->save();
        }
    }
}
