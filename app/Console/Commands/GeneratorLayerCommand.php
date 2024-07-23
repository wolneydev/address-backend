<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GeneratorLayerCommand extends Command
{
    protected $signature = 'crud:generator
    {name : Class (singular) for example User} {--fields=*}';

    protected $description = 'Create crud operations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');        
        $fields = $this->option('fields');
        $this->controller($name);
        $this->service($name,$fields); 
        $this->testService($name,$fields);        
        $this->model($name, $fields);
        $this->request($name);
        $nameController = $name . "Controller";
        File::append(base_path('routes/api.php'), "\n \n Route::apiResource('" . Str::plural(strtolower($name)) . "'" . str_replace(".", "", ",App\Http\Controllers\.$nameController.::class)") . "->middleware(['transaction']);");
        Artisan::call(command: 'make:migration create_' . strtolower($name) . '_table --create=' . strtolower($name));
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{classe}}',
                '{{pluralminusculaclasse}}',
                '{{singularminusculaclasse}}'        
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower(Str::snake($name))
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }
    protected function service($name,$fields)
    {
        $fields = '"' . implode('","', $fields) . '"';
        $serviceTemplate = str_replace(
            [
                '{{classe}}',
                '{{pluralminusculaclasse}}',
                '{{singularminusculaclasse}}'                               
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Service')
        );
        $serviceTemplate = str_replace(
            ['{{fillable}}'],
            [$fields],
            $serviceTemplate
        );        
        if (!file_exists($path = app_path('/Services'))) {
            mkdir($path, 0775, true);
        }
       
        file_put_contents(app_path("/Services/{$name}Service.php"), $serviceTemplate);
    }   
    protected function model($name, $fields)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
        $fields = '"' . implode('","', $fields) . '"';
        $modelTemplate = str_replace(
            ['{{fillable}}'],
            [$fields],
            $modelTemplate
        );

        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if (!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0775, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    protected function testService($name,$fields)
    {
        $fields = '"' . implode('","', $fields) . '"';
        $serviceTestTemplate = str_replace(
            [
                '{{classe}}',
                '{{pluralminusculaclasse}}',
                '{{singularminusculaclasse}}'                               
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Test')
        );
        $serviceTestTemplate = str_replace(
            ['{{fillable}}'],
            [$fields],
            $serviceTestTemplate
        );        
        if (!file_exists($path = app_path('./tests/Unit'))) {
            mkdir($path, 0775, true);
        }
       
        file_put_contents(base_path("tests/Unit/{$name}Test.php"), $serviceTestTemplate);
    }    


    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
}
