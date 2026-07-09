<?php

namespace App\Http\Controllers\Installer;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;

class InstallerController extends Controller
{
    public function index()
    {
        if (file_exists(storage_path('app/installer_completed'))) {
            return redirect('/admin');
        }

        return view('installer.index');
    }

    public function store(Request $request)
    {
        if (file_exists(storage_path('app/installer_completed'))) {
            return response()->json(['success' => false, 'message' => 'Installation already completed.'], 400);
        }

        $request->validate([
            'db_host' => 'required|string',
            'db_name' => 'required|string',
            'db_user' => 'required|string',
            'db_password' => 'nullable|string',
            'website_url' => 'required|url',
            'admin_email' => 'required|email|unique:users,email',
            'admin_username' => 'required|string|min:3|unique:users,name',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // 1. Test database connection
            $this->testDatabaseConnection($request);

            // 2. Create .env file
            $this->createEnvFile($request);

            // 3. Generate application key
            Artisan::call('key:generate', ['--force' => true]);

            // 4. Run migrations
            Artisan::call('migrate', ['--force' => true]);

            // 5. Seed the database
            Artisan::call('db:seed', ['--force' => true]);

            // 6. Create admin account
            User::create([
                'name' => $request->admin_username,
                'email' => $request->admin_email,
                'password' => bcrypt($request->admin_password),
                'is_active' => true,
            ]);

            // 7. Mark installation as completed
            File::ensureDirectoryExists(storage_path('app'));
            File::put(storage_path('app/installer_completed'), 'true');

            return response()->json(['success' => true, 'message' => 'Installation completed successfully!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Installation failed: ' . $e->getMessage()], 500);
        }
    }

    private function testDatabaseConnection($request)
    {
        try {
            DB::connection('test')->getPdo();
        } catch (Exception $e) {
            $config = [
                'driver' => 'mysql',
                'host' => $request->db_host,
                'database' => $request->db_name,
                'username' => $request->db_user,
                'password' => $request->db_password,
            ];

            config(['database.connections.test' => $config]);
            DB::setDefaultConnection('test');
            DB::connection('test')->getPdo();
        }
    }

    private function createEnvFile($request)
    {
        $envContent = "APP_NAME=\"Loan Management System\"
";
        $envContent .= "APP_ENV=production
";
        $envContent .= "APP_KEY=
";
        $envContent .= "APP_DEBUG=false
";
        $envContent .= "APP_URL={$request->website_url}
";
        $envContent .= "\nLOG_CHANNEL=stack
";
        $envContent .= "LOG_LEVEL=debug
";
        $envContent .= "\nDB_CONNECTION=mysql
";
        $envContent .= "DB_HOST={$request->db_host}
";
        $envContent .= "DB_PORT=3306
";
        $envContent .= "DB_DATABASE={$request->db_name}
";
        $envContent .= "DB_USERNAME={$request->db_user}
";
        $envContent .= "DB_PASSWORD={$request->db_password}
";
        $envContent .= "\nBROADCAST_DRIVER=log
";
        $envContent .= "CACHE_DRIVER=file
";
        $envContent .= "FILESYSTEM_DISK=local
";
        $envContent .= "QUEUE_CONNECTION=sync
";
        $envContent .= "SESSION_DRIVER=file
";
        $envContent .= "SESSION_LIFETIME=120
";
        $envContent .= "\nMAIL_MAILER=smtp
";
        $envContent .= "MAIL_HOST=smtp.mailtrap.io
";
        $envContent .= "MAIL_PORT=2525
";
        $envContent .= "MAIL_USERNAME=
";
        $envContent .= "MAIL_PASSWORD=
";
        $envContent .= "MAIL_ENCRYPTION=tls
";
        $envContent .= "MAIL_FROM_ADDRESS=\"hello@example.com\"
";
        $envContent .= "MAIL_FROM_NAME=\"Loan Management System\"
";
        $envContent .= "\nOCR_ENABLED=false
";
        $envContent .= "OCR_PROVIDER=tesseract
";
        $envContent .= "OCR_API_KEY=
";
        $envContent .= "\nINSTALLER_COMPLETED=true
";

        File::put(base_path('.env'), $envContent);
    }
}
