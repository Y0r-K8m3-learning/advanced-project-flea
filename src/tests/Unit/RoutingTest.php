<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

class RoutingTest  extends BaseTestCase
{
    /**
     * ホームページのルートが正しく設定されていることを確認するテスト
     *
     * @return void
     */
    public function test_home_route()
    {
        $route = Route::getRoutes()->getByName('home');

        $this->assertNotNull($route, "Route 'home' is not defined.");
        $this->assertEquals('GET', $route->methods()[0]);
        $this->assertEquals('/', $route->uri());
        $this->assertEquals([ItemController::class, 'index'], $route->action['uses']);
    }

    /**
     * インデックスのルートが正しく設定されていることを確認するテスト
     *
     * @return void
     */
    public function test_index_route()
    {
        $route = Route::getRoutes()->getByName('index');

        $this->assertNotNull($route, "Route 'index' is not defined.");
        $this->assertEquals('GET', $route->methods()[0]);
        $this->assertEquals('/', $route->uri());
        $this->assertEquals([ItemController::class, 'index'], $route->action['uses']);
    }

    /**
     * アイテム検索のルートが正しく設定されていることを確認するテスト
     *
     * @return void
     */
    public function test_item_search_route()
    {
        $route = Route::getRoutes()->getByName('item.search');

        $this->assertNotNull($route, "Route 'item.search' is not defined.");
        $this->assertEquals('GET', $route->methods()[0]);
        $this->assertEquals('item/search', $route->uri());
        $this->assertEquals([ItemController::class, 'search'], $route->action['uses']);
    }
}
