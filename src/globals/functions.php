<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use SPC\exception\WrongUsageException;
use SPC\util\UnixShell;
use SPC\util\WindowsCmd;
use ZM\Logger\ConsoleLogger;

/**
 * Judge if an array is an associative array
 */
function is_assoc_array(mixed $array): bool
{
    return is_array($array) && (!empty($array) && array_keys($array) !== range(0, count($array) - 1));
}

/**
 * Return a logger instance
 */
function logger(): LoggerInterface
{
    global $ob_logger;
    if ($ob_logger === null) {
        return new ConsoleLogger();
    }
    return $ob_logger;
}

/**
 * Transfer architecture name to gnu triplet
 *
 * @throws WrongUsageException
 */
function arch2gnu(string $arch): string
{
    $arch = strtolower($arch);
    return match ($arch) {
        'x86_64', 'x64', 'amd64' => 'x86_64',
        'arm64', 'aarch64' => 'aarch64',
        default => throw new WrongUsageException('Not support arch: ' . $arch),
        // 'armv7' => 'arm',
    };
}

function quote(string $str, string $quote = '"'): string
{
    return $quote . $str . $quote;
}

/**
 * Get Family name of current OS
 *
 * @throws WrongUsageException
 */
function osfamily2dir(): string
{
    return match (PHP_OS_FAMILY) {
        /* @phpstan-ignore-next-line */
        'Windows', 'WINNT', 'Cygwin' => 'windows',
        'Darwin' => 'macos',
        'Linux' => 'linux',
        'BSD' => 'freebsd',
        default => throw new WrongUsageException('Not support os: ' . PHP_OS_FAMILY),
    };
}

/**
 * Execute the shell command, and the output will be directly printed in the terminal. If there is an error, an exception will be thrown
 *
 * @throws \SPC\exception\RuntimeException
 */
function f_passthru(string $cmd): ?bool
{
    $danger = false;
    foreach (DANGER_CMD as $danger_cmd) {
        if (str_starts_with($cmd, $danger_cmd . ' ')) {
            $danger = true;
            break;
        }
    }
    if ($danger) {
        logger()->notice('Running dangerous command: ' . $cmd);
    } else {
        logger()->debug('Running command with direct output: ' . $cmd);
    }
    $ret = passthru($cmd, $code);
    if ($code !== 0) {
        throw new \SPC\exception\RuntimeException('Command run failed with code[' . $code . ']: ' . $cmd, $code);
    }
    return $ret;
}

/**
 * Execute a command, return the output and result code
 */
function f_exec(string $command, mixed &$output, mixed &$result_code): bool|string
{
    logger()->debug('Running command (no output) : ' . $command);
    return exec($command, $output, $result_code);
}

function f_mkdir(string $directory, int $permissions = 0777, bool $recursive = false): bool
{
    if (file_exists($directory)) {
        logger()->debug("Dir {$directory} already exists, ignored");
        return true;
    }
    logger()->debug('Making new directory ' . ($recursive ? 'recursive' : '') . ': ' . $directory);
    return mkdir($directory, $permissions, $recursive);
}

function f_putenv(string $env): bool
{
    logger()->debug('Setting env: ' . $env);
    return putenv($env);
}

function shell(?bool $debug = null): UnixShell
{
    return new UnixShell($debug);
}

function cmd(?bool $debug = null): WindowsCmd
{
    return new WindowsCmd($debug);
}
