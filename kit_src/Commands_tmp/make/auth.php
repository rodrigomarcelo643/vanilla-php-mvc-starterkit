<?php
Output::info('Generating Auth Scaffolding...');

$controllerPath = KIT_ROOT . "/app/controllers/auth/AuthController.php";
$modelPath = KIT_ROOT . "/app/models/User.php";
$viewsDir = KIT_ROOT . "/app/views/auth";

if (!is_dir(dirname($controllerPath))) mkdir(dirname($controllerPath), 0755, true);
if (!is_dir(dirname($modelPath))) mkdir(dirname($modelPath), 0755, true);
if (!is_dir($viewsDir)) mkdir($viewsDir, 0755, true);

if (!file_exists($controllerPath)) {
    $stub = <<<PHP
<?php
class AuthController extends Controller
{
    public function login(): void { \$this->auth('auth/login', ['title' => 'Login']); }
    public function register(): void { \$this->auth('auth/register', ['title' => 'Register']); }
    public function logout(): void { session_destroy(); header('Location: /'); exit; }
}
PHP;
    file_put_contents($controllerPath, $stub);
    Output::success("Created AuthController.");
}

if (!file_exists($modelPath)) {
    $stub = <<<PHP
<?php
class User extends Model
{
    protected string \$table = 'users';
}
PHP;
    file_put_contents($modelPath, $stub);
    Output::success("Created User Model.");
}

if (!file_exists("$viewsDir/login.php")) {
    file_put_contents("$viewsDir/login.php", "<h1>Login</h1><form method='POST' action='/login'><button>Login</button></form>");
    file_put_contents("$viewsDir/register.php", "<h1>Register</h1><form method='POST' action='/register'><button>Register</button></form>");
    Output::success("Created Auth Views.");
}

Output::line();
Output::info("Done! Don't forget to add routes for /login and /register.");
