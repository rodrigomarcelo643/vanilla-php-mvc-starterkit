<?php
Output::info('Tinker - Interactive PHP Shell');
Output::line("Type 'exit' to quit. Variables are preserved between lines.\n");

$__tinker_context = [];
while (true) {
    echo "\033[36m> \033[0m";
    $line = trim(fgets(STDIN));
    if ($line === 'exit' || $line === 'quit') break;
    if ($line === '') continue;

    if (!str_ends_with($line, ';') && !str_ends_with($line, '}')) {
        $line .= ';';
    }

    try {
        extract($__tinker_context);
        ob_start();
        $__tinker_result = eval($line);
        $__tinker_output = ob_get_clean();
        
        $__tinker_context = get_defined_vars();
        unset($__tinker_context['line'], $__tinker_context['__tinker_result'], $__tinker_context['__tinker_output'], $__tinker_context['__tinker_context']);

        if ($__tinker_output !== '') {
            echo $__tinker_output . "\n";
        }
        if ($__tinker_result !== null) {
            print_r($__tinker_result);
            echo "\n";
        }
    } catch (\Throwable $e) {
        Output::error($e->getMessage());
    }
}
