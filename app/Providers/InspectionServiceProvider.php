<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Inspection;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class InspectionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }
    public function boot()
    {
        try {
            Event::listen(['eloquent.created: *', 'eloquent.updated: *', 'eloquent.deleted: *'], function ($origem, $model) {
                $tableName = $model[0]->getTable();
                if ($tableName != 'inspection') {
                    $originalData = $model[0]->getOriginal();
                    $newData = $model[0]->getAttributes();
                    Inspection::create([
                        "user_id" => 1, //temporary // request()->user_key
                        "event_type" => explode('.', explode(':', $origem)[0])[1],
                        "old_value" => json_encode($originalData),
                        "table_name" => Str::singular($tableName),
                        "new_value" => json_encode($newData),
                        "url" => request()->server('HTTP_HOST'),
                        "ip_address" => request()->ip(),// temporary request()->ip(),
                        "user_agent" => request()->server('HTTP_USER_AGENT'),
                    ]);
                }
            });
        } catch (Exception $e) {
            Log::error(['cod'=>'aud','error'=>$e]);
        }
    }
}