<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/Core/Env.php';
require_once __DIR__ . '/../app/Core/Auth.php';
require_once __DIR__ . '/../app/Core/SupabaseClient.php';

require_once __DIR__ . '/../app/Services/AuthService.php';
require_once __DIR__ . '/../app/Services/ApplicantService.php';
require_once __DIR__ . '/../app/Services/JobService.php';
require_once __DIR__ . '/../app/Services/PlacementService.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/ApplicantController.php';
require_once __DIR__ . '/../app/Controllers/JobController.php';
require_once __DIR__ . '/../app/Controllers/PlacementController.php';
require_once __DIR__ . '/../app/Controllers/PublicApplicantController.php';

use App\Core\Env;
use App\Core\SupabaseClient;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ApplicantController;
use App\Controllers\JobController;
use App\Controllers\PlacementController;
use App\Services\AuthService;
use App\Services\ApplicantService;
use App\Services\JobService;
use App\Services\PlacementService;
use App\Controllers\PublicApplicantController;

Env::load(__DIR__ . '/../.env');

$supabaseConfig = require __DIR__ . '/../config/supabase.php';
$supabaseClient = new SupabaseClient($supabaseConfig);

$authService = new AuthService();
$applicantService = new ApplicantService($supabaseClient);
$jobService = new JobService($supabaseClient);
$placementService = new PlacementService($supabaseClient);

$authController = new AuthController($authService);
$dashboardController = new DashboardController($applicantService, $jobService, $placementService);
$applicantController = new ApplicantController($applicantService);
$jobController = new JobController($jobService, $applicantService);
$placementController = new PlacementController($placementService, $applicantService, $jobService);
$publicApplicantController = new PublicApplicantController($applicantService);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($path === '/apply' && $method === 'GET') {
    $publicApplicantController->showForm();
    exit;
}

if ($path === '/apply' && $method === 'POST') {
    $publicApplicantController->submit();
    exit;
}

if ($path === '/') {
    header('Location: /login');
    exit;
}

if ($path === '/login' && $method === 'GET') {
    $authController->showLogin();
    exit;
}

if ($path === '/login' && $method === 'POST') {
    $authController->login();
    exit;
}

if ($path === '/logout' && $method === 'POST') {
    $authController->logout();
    exit;
}

if ($path === '/dashboard' && $method === 'GET') {
    $dashboardController->index();
    exit;
}

if ($path === '/applicants' && $method === 'GET') {
    $applicantController->index();
    exit;
}

if ($path === '/applicants/profile' && $method === 'GET') {
    $applicantController->profile();
    exit;
}

if ($path === '/jobs' && $method === 'GET') {
    $jobController->index();
    exit;
}

if ($path === '/jobs/matches' && $method === 'GET') {
    $jobController->matches();
    exit;
}

if ($path === '/post-job/upload' && $method === 'POST') {
    $jobController->uploadFlyer();
    exit;
}

if ($path === '/post-job' && $method === 'GET') {
    $jobController->create();
    exit;
}

if ($path === '/post-job' && $method === 'POST') {
    $jobController->store();
    exit;
}

if ($path === '/placements' && $method === 'GET') {
    $placementController->index();
    exit;
}

if ($path === '/placements/create' && $method === 'GET') {
    $placementController->create();
    exit;
}

if ($path === '/placements/store' && $method === 'POST') {
    $placementController->store();
    exit;
}

if ($path === '/placements/export' && $method === 'GET') {
    $placementController->export();
    exit;
}

if ($path === '/placements/edit' && $method === 'GET') {
    $placementController->edit();
    exit;
}

if ($path === '/placements/update' && $method === 'POST') {
    $placementController->update();
    exit;
}

if ($path === '/settings' && $method === 'GET') {
    echo 'Settings page placeholder';
    exit;
}

header('HTTP/1.1 404 Not Found');
echo '404 Not Found';   