<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
       /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindSearchClient();
    }
    /**
     * Bind search client
     *
     * @return void
     */
    private function bindSearchClient()
    {
        $this->app->bind(\Elastic\Elasticsearch\Client::class, function () {

            $hosts = config("app.search.hosts");

            return \Elastic\Elasticsearch\ClientBuilder::create()
                ->setHosts($hosts)
                ->build();
        });
    }
}
