<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;

Schedule::command('inspire')->hourly();
