<?php

namespace Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Stackkit\LaravelGoogleCloudTasksQueue\CloudTasksServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('queue.default', 'cloudtasks');
        $app['config']->set('queue.connections.cloudtasks', [
            'driver' => 'cloudtasks',
            'credentials' => __DIR__ . '/Support/gcloud-key-valid.json',
            'queue' => 'test-queue',
            'project' => 'test-project',
            'location' => 'europe-west6',
            'handler' => 'https://localhost/my-handler',
            'service_account_email' => 'info@stackkit.io',
        ]);
    }

    protected function setConfigValue($key, $value)
    {
        $this->app['config']->set('queue.connections.cloudtasks.' . $key, $value);
    }
}
