<?php

namespace RenokiCo\LaravelSteampipe;

use Illuminate\Database\PostgresConnection;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class SteampipeConnection extends PostgresConnection
{
    /**
     * Create a new database connection instance.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->useDefaultQueryGrammar();
        $this->useDefaultPostProcessor();
    }

    /**
     * Run a select statement against the database.
     *
     * @param  string  $query
     * @param  array  $bindings
     * @param  bool  $useReadPdo
     * @return array
     */
    public function select($query, $bindings = [], $useReadPdo = true)
    {
        return $this->run($query, $bindings, function ($query, $bindings) {
            if ($this->pretending()) {
                return [];
            }

            foreach ($bindings as $binding) {
                $query = Str::replaceFirst('?', $binding, $query);
            }

            return $this->processQuery($query);
        });
    }

    /**
     * Pluck the already-built SQL query in
     *
     * @param  string  $query
     * @return array
     */
    protected function processQuery(string $query): array
    {
        $binary = $this->config['binary'] ?? '$(which steampipe)';

        $process = Process::fromShellCommandline(
            "{$binary} query --output json \"{$query}\""
        );

        $process->run();

        if ($error = $process->getErrorOutput()) {
            throw new RuntimeException($error);
        }

        if ($json = json_decode($process->getOutput(), true)) {
            return $json;
        }

        return [];
    }
}
