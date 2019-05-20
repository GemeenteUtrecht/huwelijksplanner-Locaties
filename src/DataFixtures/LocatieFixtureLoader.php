<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


use App\Entity\Locatie;

class LocatieFixtureLoader extends Fixture
{
	public function load(ObjectManager $manager)
	{
		
		$locatie = new Locatie();
		$locatie->setBronOrganisatie('123456789');
		$locatie->setAfbeelding('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/Trouwzaal-Stadskantoor-Utrecht.jpg');
		$locatie->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$locatie->setBag('123456789');
		$locatie->setNaam('Stadskantoor');
		$locatie->setSamenvatting('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		$locatie->setBeschrijving('Deze locatie is speciaal voor eenvoudige en gratis huwelijken.
 De zaal ligt op de 6e etage van het Stadskantoor.
 De ruimte is eenvoudig en toch heel intiem.
 Het licht is in te stellen op een kleur die jullie graag willen.');
		
		$manager->persist($locatie);
		
		
		$locatie = new Locatie();
		$locatie->setBronOrganisatie('123456789');
		$locatie->setAfbeelding('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/kleine-trouwzaal-stadhuis-utrecht.jpg');
		$locatie->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$locatie->setBag('123456789');
		$locatie->setNaam('Stadhuis kleine zaal');
		$locatie->setSamenvatting('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		$locatie->setBeschrijving('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		
		$manager->persist($locatie);
		
		$locatie = new Locatie();
		$locatie->setBronOrganisatie('123456789');
		$locatie->setAfbeelding('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/grote-trouwzaal-stadhuis-utrecht.jpg');
		$locatie->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$locatie->setBag('123456789');
		$locatie->setNaam('Stadhuis grote zaal');
		$locatie->setSamenvatting('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		$locatie->setBeschrijving('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		
		$manager->persist($locatie);
		
		$locatie = new Locatie();
		$locatie->setBronOrganisatie('123456789');
		$locatie->setAfbeelding('https://www.utrecht.nl/fileadmin/uploads/documenten/9.digitaalloket/Burgerzaken/trouwzaal-wsc-vleuten-de-meern.jpg');
		$locatie->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$locatie->setBag('123456789');
		$locatie->setNaam('Stadhuis grote zaal');
		$locatie->setSamenvatting('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		$locatie->setBeschrijving('Deze uiterst sfeervolle trouwzaal is de droom van ieder koppel');
		
		$manager->persist($locatie);
		
		$manager->flush();
	}
}
