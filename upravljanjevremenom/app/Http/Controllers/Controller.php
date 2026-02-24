<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\Info(
version: "1.0.0",
title: "Time Manager API",
description: "REST API sistem za upravljanje vremenom. 
Omogućava korisnicima upravljanje zadacima, beleškama i obaveštenjima, 
praćenje statusa zadataka, kao i pregled statistike rada korisnika. 
Sistem podržava uloge (admin, regular i premium korisnik)."
)]


abstract class Controller
{
    //
}
