<?php
namespace app\Http\Controllers;

class HomeController
{
    public function index()
    {
        return view('Home.index');
    }

    public function welcome()
    {
        return view('Home.welcome');
    }
}