<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use ZipArchive;
use Illuminate\Support\Facades\Artisan;
use App\Traits\InstallerManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SystemUpdateController extends Controller
{
    
    use InstallerManager;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!$this->_isPurchased()){
                return redirect()->route('invalid.puchase');
            }
            return $next($request);
        });
    }


    public function init() :View {

        return view('admin.system_update',[
            "title" => translate("Update System")
        ]);
    }

    /**
     * Update the system.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse | array
    {

       
        ini_set('memory_limit', '-1');
        ini_set('max_input_time', '300'); 
        ini_set('max_execution_time', '300');
        ini_set('upload_max_filesize', '1G'); 
        ini_set('post_max_size', '1G'); 
    
        $request->validate([
            'updateFile' => ['required', 'mimes:zip'],
        ], [
            'updateFile.required' => translate('File field is required')
        ]);

        try {
            if ($request->hasFile('updateFile')) {

                $zipFile = $request->file('updateFile');
                $basePath = base_path('/storage/app/public/temp_update/');
                
                if (!file_exists($basePath)) {
                    mkdir($basePath, 0777, true);
                }

                // Move the uploaded zip file to the temp directory
                $zipFile->move($basePath, $zipFile->getClientOriginalName());

                // Open the zip file
                $zip = new ZipArchive;
                $res = $zip->open($basePath . $zipFile->getClientOriginalName());

                if (!$res) {
                    $this->removeDirectory($basePath );
                    return [
                        'status'  => false,
                        'message' => translate('Error! Could not open File'),
                    ];
                } 

                $zip->extractTo($basePath);
                $zip->close();

                // Read configuration file
                $configFilePath = $basePath.'config.json';
                $configJson = json_decode(file_get_contents($configFilePath), true);

                if (empty($configJson) || empty($configJson['version'])) {
                    $this->removeDirectory($basePath );
                    return [
                        'status'  => false,
                        'message' => translate('Error! No Configuration file found'),
                    ];
                }

                $newVersion = (double) $configJson['version'];
                $currentVersion = (double) site_settings(key: "app_version", default: 1.0);

                $src = storage_path('app/public/temp_update');
                $dst = dirname(base_path());

                if ($newVersion > $currentVersion) {

                    // Copy files from temp directory to destination directory
                    $this->copyDirectory($src, $dst);

                    //Run migrations, seeders & shell commands
                    $this->_runMigrations($configJson);
                    $this->_runSeeder($configJson);
                    $this->_runShellcommands($configJson);

                    // Update application version and installation date
                    Settings::updateOrInsert(['key' => "app_version"], ['value' => $newVersion]);
                    Settings::updateOrInsert(['key' => "system_installed_at"], ['value' => Carbon::now()]);
                    optimize_clear();
                    $this->removeDirectory($basePath );
                    return [
                        'status'  => true,
                        'message' => translate('Your system updated successfully'),
                    ];
                }
            }

            // Delete temp directory

        } catch (\Exception $ex) {
            $this->removeDirectory($basePath );
            return [
                'status'  => false,
                'message' => strip_tags($ex->getMessage()),
            ];
        }

        optimize_clear();
        $this->removeDirectory($basePath );
        return [
            'status'  => false,
            'message' => translate('Your system is currently running the latest version.'),
        ];
        

    }


    private function _runShellcommands(array $json) :void{

        $commands = Arr::get($json , 'shell_commands' ,[]);
        if(count($commands) > 0){
            foreach ($commands as $command) {
                $res = shell_exec($command);
                sleep(1);
            }
        }
    }

    public function removeDirectory($basePath) {
        
        if (File::exists($basePath)) {
            File::deleteDirectory($basePath);
        }
    }


    private function _runMigrations(array $json) :void{

        $migrations = Arr::get($json , 'migrations' ,[]);
        if(count($migrations) > 0){
            $migrationFiles = $this->_getFormattedFiles($migrations);
            foreach ($migrationFiles as $migration) {
                Artisan::call('migrate',
                    array(
                        '--path' => $migration,
                        '--force' => true));
            }
        }
    }

    private function _runSeeder(array $json) :void{
        $seeders = Arr::get($json , 'seeder' ,[]);
        if(count($seeders) > 0){
            $seederFiles = $this->_getFormattedFiles($seeders);
            foreach ($seederFiles as $seeder) {
                Artisan::call('db:seed',
                    array(
                        '--class' => $seeder,
                        '--force' => true));
            }
        }
    }

    private function _getFormattedFiles (array $files) :array{

        $currentVersion  = (double) site_settings(key : "app_version",default :1.0);
        $formattedFiles = [];
        foreach($files as $version => $file){
           if(version_compare($version, (string)$currentVersion, '>')){
              $formattedFiles [] =  $file;
           }
        }

        return array_unique(Arr::collapse($formattedFiles));

    }

    

    /**
     * Copy directory
     *
     * @param string $src
     * @param string $dst
     * @return boolean
     */
    public function copyDirectory(string $src, string $dst) :bool {

        try {
            $dir = opendir($src);
            @mkdir($dst);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        $this->copyDirectory($src . '/' . $file, $dst . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        } catch (\Exception $e) {
           return false;
        }

        return true;
    }


    
    /**
     * delete directory
     *
     * @param string $dirname
     * @return boolean
     */
    public function deleteDirectory(string $dirname) :bool {

        try{
            if (!is_dir($dirname)){
                return false;
            }
            $dir_handle = opendir($dirname);

            if (!$dir_handle)
                return false;
            while ($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname . "/" . $file))
                        unlink($dirname . "/" . $file);
                    else
                        $this->deleteDirectory($dirname . '/' . $file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
    

}
