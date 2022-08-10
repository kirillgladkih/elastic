<?php

namespace App\Console\Commands\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

abstract class AbstractElasticCommand extends Command
{
    /**
     * Client
     *
     * @var Client
     */
    protected Client $client;
    /**
     * Hosts
     *
     * @var array
     */
    protected array $hosts;
    /**
     * Mapping requires array
     *
     * @var \App\Repository\Mapping\Elastic\Interfaces\ElasticMap[]
     */
    protected array $mapping;
    /**
     * Init
     */
    public function __construct()
    {
        parent::__construct();

        $this->hosts = config("app.search.hosts");

        $this->mapping = config("mapping.elastic");

        if (count($this->mapping) < 1)
            $this->error("empty mappging array");

        $this->client = ClientBuilder::create()->setHosts($this->hosts)->build();;
    }
}
