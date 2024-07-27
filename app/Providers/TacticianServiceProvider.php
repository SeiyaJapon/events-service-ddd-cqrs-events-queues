<?php

declare(strict_types=1);

namespace App\Providers;

use App\EventContext\Infrastructure\CommandBus\TacticianCommandBus;
use App\EventContext\Infrastructure\Event\Services\EventDispatcherService;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use App\EventContext\Infrastructure\QueryBus\TacticianQueryBus;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use App\EventContext\Infrastructure\QueryBus\QueryBusInterface;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

class TacticianServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CommandBusInterface::class, function ($app) {
            $commandMap = config('cqrs.commands');
            $locator = new InMemoryLocator();

            foreach ($commandMap as $command => $handler) {
                $handlerInstance = $app->make($handler);
                $locator->addHandler($handlerInstance, $command);
            }

            $commandBus = new CommandBus([
                new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    $locator,
                    new HandleInflector()
                ),
            ]);

            return new TacticianCommandBus($commandBus);
        });

        $this->app->singleton(QueryBusInterface::class, function ($app) {
            $queryMap = config('cqrs.queries');
            $locator = new InMemoryLocator();

            foreach ($queryMap as $query => $handler) {
                $handlerInstance = $app->make($handler);
                $locator->addHandler($handlerInstance, $query);
            }

            $queryBus = new CommandBus([
                new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    $locator,
                    new HandleInflector()
                ),
            ]);

            return new TacticianQueryBus($queryBus);
        });

        $this->app->singleton(EventDispatcherService::class, function ($app) {
            return new EventDispatcherService($app->make(Dispatcher::class));
        });
    }
}