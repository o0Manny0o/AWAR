<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    use AuthorizesRequests;

    protected string $baseRouteName = '';
    protected string $baseViewPath = "";

    protected function redirect(Request $request, string $route, mixed $parameters = []): RedirectResponse
    {
        $redirect = $request->input('redirect');

        if ($redirect) {
            return redirect($redirect);
        }

        return redirect()->route($route, $parameters);
    }

    protected function getIndexRouteName(): string
    {
        return $this->baseRouteName . '.index';
    }

    protected function getIndexView(): string
    {
        return $this->baseViewPath . '/Index';
    }

    protected function getCreateRouteName(): string
    {
        return $this->baseRouteName . '.create';
    }

    protected function getCreateView(): string
    {
        return $this->baseViewPath . '/Create';
    }

    protected function getStoreRouteName(): string
    {
        return $this->baseRouteName . '.store';
    }

    protected function getShowRouteName(): string
    {
        return $this->baseRouteName . '.show';
    }

    protected function getShowView(): string
    {
        return $this->baseViewPath . '/Show';
    }

    protected function getEditRouteName(): string
    {
        return $this->baseRouteName . '.edit';
    }

    protected function getEditView(): string
    {
        return $this->baseViewPath . '/Edit';
    }

    protected function getUpdateRouteName(): string
    {
        return $this->baseRouteName . '.update';
    }

    protected function getDestroyRouteName(): string
    {
        return $this->baseRouteName . '.destroy';
    }
}
