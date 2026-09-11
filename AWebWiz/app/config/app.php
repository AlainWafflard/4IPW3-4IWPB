<?php

namespace Config;

class App
{
	// Version du framework
	public const AWEBWIZ_VERSION = "3.1";

	// Répertoires
	public const ROOT_DIR = '../app/';
	public const DATABASE_DIR = '../assets/database/';
	public const STATIC_CONTENT_DIR = '../assets/static_content';

	// machine utilisée (localisation de l'application)
	// impact sur la DB
	public const MACHINE = "home"; // "classe38" ou  "home" ou ... ce qu'on veut
}

