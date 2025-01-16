<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    use AuthorizesRequests;

    protected static string $baseRouteName = '';
    protected static string $baseViewPath = '';

    protected function redirect(
        Request $request,
        string $route,
        mixed $parameters = [],
    ): RedirectResponse {
        $redirect = $request->input('redirect');

        if ($redirect) {
            return redirect($redirect);
        }

        return redirect()->route($route, $parameters);
    }

    protected function getIndexRouteName(): string
    {
        return static::$baseRouteName . '.index';
    }

    protected function getIndexView(): string
    {
        return static::$baseViewPath . '/Index';
    }

    protected function getCreateRouteName(): string
    {
        return static::$baseRouteName . '.create';
    }

    protected function getCreateView(): string
    {
        return static::$baseViewPath . '/Create';
    }

    protected function getStoreRouteName(): string
    {
        return static::$baseRouteName . '.store';
    }

    protected function getShowRouteName(): string
    {
        return static::$baseRouteName . '.show';
    }

    protected function getShowView(): string
    {
        return static::$baseViewPath . '/Show';
    }

    protected function getEditRouteName(): string
    {
        return static::$baseRouteName . '.edit';
    }

    protected function getEditView(): string
    {
        return static::$baseViewPath . '/Edit';
    }

    protected function getUpdateRouteName(): string
    {
        return static::$baseRouteName . '.update';
    }

    protected function getDestroyRouteName(): string
    {
        return static::$baseRouteName . '.destroy';
    }
}
