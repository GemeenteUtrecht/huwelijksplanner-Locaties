<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use App\Entity\Locatie;

class LocatieController
{
	public function __invoke(Locatie $data): Locatie
	{
		//$this->bookPublishingHandler->handle($data);
		
		return $data;
	}
}