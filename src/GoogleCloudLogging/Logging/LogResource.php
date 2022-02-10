<?php

namespace Inventcorp\LaravelBasePackage\GoogleCloudLogging\Logging;

use Illuminate\Contracts\Support\Arrayable;

class LogResource implements Arrayable
{
    private array $resource;
    private array $labels;

    /**
     * @param array $resource A set of user-defined (key, value) data.
     *           The [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
     *           to associate log entries with. **Defaults to** type global.
     * @param array $labels A set of user-defined (key, value) data that
     *           provides additional information about the log entry.
     */
    public function __construct(array $resource = [], array $labels = [])
    {
        $this->resource = $resource;
        $this->labels = $labels;
    }

    public function getResource(): array
    {
        return $this->resource;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function toArray(): array
    {
        $result = [];
        if (!empty($this->resource)) {
            $result['resource'] = $this->resource;
        }
        if (!empty($this->labels)) {
            $result['labels'] = $this->labels;
        }
        return $result;
    }
}
