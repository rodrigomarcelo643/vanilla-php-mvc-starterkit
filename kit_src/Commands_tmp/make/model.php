<?php

global $argv;
$args = array_slice($argv, 2);

$modelArg = null;
foreach ($args as $arg) {
    if (!str_starts_with($arg, '--')) {
        $modelArg = $arg;
        break;
    }
}

if (!$modelArg) {
    Output::line();
    echo "\033[36m  What should the model be named? (e.g., User): \033[0m";
    $modelArg = trim(fgets(STDIN));
    if (!$modelArg) {
        Output::line();
        Output::error('Model name is required.');
        Output::line();
        exit(1);
    }
}

$isResource = in_array('--resource', $args);

$name  = ucfirst($modelArg);
$dir   = KIT_ROOT . "/app/models";
$path  = "$dir/{$name}.php";
$table = strtolower($name) . 's';

Output::line();

if (file_exists($path)) {
    Output::error("Model \033[33m$name\033[0m already exists.");
    Output::line();
    exit(1);
}

Output::info("Creating model \033[33m$name\033[0m for table \033[36m$table\033[0m...");

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$stub = <<<PHP
<?php

class {$name} extends Model
{
    protected string \$table = '{$table}';

    public function getAll(): array
    {
        return \$this->db->query("SELECT * FROM {\$this->table} ORDER BY created_at DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int \$id): array|false
    {
        \$stmt = \$this->db->prepare("SELECT * FROM {\$this->table} WHERE id = ? LIMIT 1");
        \$stmt->execute([\$id]);
        return \$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array \$data): int
    {
        \$cols = implode(', ', array_keys(\$data));
        \$vals = implode(', ', array_fill(0, count(\$data), '?'));
        \$stmt = \$this->db->prepare("INSERT INTO {\$this->table} (\$cols) VALUES (\$vals)");
        \$stmt->execute(array_values(\$data));
        return (int) \$this->db->lastInsertId();
    }

    public function update(int \$id, array \$data): void
    {
        \$set  = implode(', ', array_map(fn(\$k) => "\$k = ?", array_keys(\$data)));
        \$stmt = \$this->db->prepare("UPDATE {\$this->table} SET \$set WHERE id = ?");
        \$stmt->execute([...array_values(\$data), \$id]);
    }

    public function delete(int \$id): void
    {
        \$this->db->prepare("DELETE FROM {\$this->table} WHERE id = ?")->execute([\$id]);
    }
}
PHP;

file_put_contents($path, $stub);

Output::line();
Output::success("Created: \033[36mapp/models/\033[33m{$name}.php\033[0m");
if ($isResource) {
    Output::success("Included resource methods (CRUD).");
}
Output::line();
