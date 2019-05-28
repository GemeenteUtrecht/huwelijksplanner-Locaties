<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ActivityLogBundle\Entity\Interfaces\StringableInterface;


/**
 * Locatie
 * 
 * Een Locatie object beschrijft een bag locatie of deel daarvan, als stapelbaar object kan alles betreffen van een kantoor gebouw tot specifieke kamer. 
 * 
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 *
 * @version    	1.0
 *
 * @link   		http//:www.conduction.nl
 * @package		Common Ground
 * @subpackage  Locatie
 * 
 *  @ApiResource( 
 *  collectionOperations={
 *  	"get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/locaties",
 *  		"openapi_context" = {
 * 				"summary" = "Haalt een verzameling van Locaties op"
 *  		}
 *  	},
 *  	"post"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"personen"={"groups"={"write"}},
 *      	"path"="/locaties",
 *  		"openapi_context" = {
 * 				"summary" = "Maak een Locatie aan"
 *  		}
 *  	}
 *  },
 * 	itemOperations={
 *     "get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/locaties/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Haal een specifieke Locatie op"
 *  		}
 *  	},
 *     "put"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/locaties/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Vervang een specifieke Locatie"
 *  		}
 *  	},
 *     "delete"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/locaties/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Verwijder een specifieke Locatie"
 *  		}
 *  	},
 *     "log"={
 *         	"method"="GET",
 *         	"path"="/locaties/{id}/log",
 *          "controller"= HuwelijkController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Logboek inzien",
 *         		"description" = "Geeft een array van eerdere versies en wijzigingen van dit object.",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	}            
 *         }
 *     },
 *     "revert"={
 *         	"method"="POST",
 *         	"path"="/locaties/{id}/revert/{version}",
 *          "controller"= HuwelijkController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Versie herstellen",
 *         		"description" = "Herstel een eerdere versie van dit object. Dit is een destructieve actie die niet ongedaan kan worden gemaakt.",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	},
 *             	"responses" = {
 *         			"202" = {
 *         				"description" = "Teruggedraaid naar eerdere versie"
 *         			},	
 *         			"400" = {
 *         				"description" = "Ongeldige aanvraag"
 *         			},
 *         			"404" = {
 *         				"description" = "Locatie niet gevonden"
 *         			}
 *            	}            
 *         }
 *     }
 *  }
 * )
 * @ORM\Entity
 * @Gedmo\Loggable(logEntryClass="ActivityLogBundle\Entity\LogEntry")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"identificatie", "bronOrganisatie"},
 *     message="De identificatie dient uniek te zijn voor de bronOrganisatie"
 * )
 */

class Locatie implements StringableInterface
{
	/**
	 * Het identifacitie nummer van deze Locatie <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a><br /><br /><b>Note</b> This is for devolopment purposes, the INT ID wil be replaced by BLOB UUID on production
	 *
	 * @var int|null
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type = "integer",options={"unsigned": true})
	 * @ApiProperty(iri="https://schema.org/identifier", identifier=true)
	 * @Groups({"read"})
	 */
	private $id;
	
	/**
	 * De unieke identificatie van dit object binnen de organisatie die dit object heeft gecreëerd. <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
	 *
	 * @var string
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 40,
	 *     nullable=true
	 * )
	 * @Assert\Length(
	 *      max = 40,
	 *      maxMessage = "Het RSIN kan niet langer dan {{ limit }} karakters zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "example"="6a36c2c4-213e-4348-a467-dfa3a30f64aa",
	 *             "description"="De unieke identificatie van dit object de organisatie die dit object heeft gecreëerd.",
	 *             "maxLength"=40
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $identificatie;
	
	/**
	 * Het RSIN van de organisatie waartoe deze Locatie behoort. Dit moet een geldig RSIN zijn van 9 nummers en voldoen aan https://nl.wikipedia.org/wiki/Burgerservicenummer#11-proef. <br> Het RSIN wordt bepaald aan de hand van de geauthenticeerde applicatie en kan niet worden overschreven.
	 *
	 * @var integer
	 * @ORM\Column(
	 *     type     = "integer",
	 *     length   = 9
	 * )
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 9,
	 *      minMessage = "Het RSIN moet ten minste {{ limit }} karakters lang zijn",
	 *      maxMessage = "Het RSIN kan niet langer dan {{ limit }} karakters zijn"
	 * )
	 * @Groups({"read"})
	 * @ApiFilter(SearchFilter::class, strategy="exact")
	 * @ApiFilter(OrderFilter::class)
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="bronOrganisatie",
	 *             "type"="string",
	 *             "example"="123456789",
	 *             "required"="true",
	 *             "maxLength"=9,
	 *             "minLength"=8
	 *         }
	 *     }
	 * )
	 */
	public $bronOrganisatie;	
	
	/**
	 * URL-referentie naar het afbeeldings document.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BRP",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van dit persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $afbeelding;
	
	/**
	 * URL-referentie naar het film document.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BRP",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van deze persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $film;
	
	/**
	 * URL-referentie naar de BAG inschrijving van deze Locatie.
	 *
	 * @var string
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BAG",
	 *             "type"="string",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=200,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BAG inschrijving van deze Locatie"
	 *         }
	 *     }
	 * )
	 */
	public $bag;
	
	/**
	 * De naam van deze Locatie. <br /><b>Schema:</b> <a href="https://schema.org/name">https://schema.org/name</a>
	 *
	 * @var string
	 *
     * @Gedmo\Translatable
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 5,
	 *      max = 255,
	 *      minMessage = "De naam moet ten minste {{ limit }} tekens lang zijn",
	 *      maxMessage = "De naam kan niet langer dan {{ limit }} tekens zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",	 
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
	 *             "minLength"=5,
	 *             "maxLength"=255,
     *             "example"="Trouwzaal"
     *         }
     *     }
	 * )
	 **/
	public $naam;
	
	/**
	 * Een korte samenvattende tekst over deze Locatie bedoeld ter introductie.  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
	 *
	 * @var string
	 *
     * @Gedmo\Translatable
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "text"
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 25,
	 *      max = 2000,
	 *      minMessage = "Uw samenvatting moet ten minste bestaan uit{{ limit }} tekens",
	 *      maxMessage = "Uw samenvatting kan niet langer zijn dan {{ limit }} tekens")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "minLength"=25,
	 *             "maxLength"=2000,
	 *             "example"="Deze prachtige Locatie is zeker het aanbevelen waard"
	 *         }
	 *     }
	 * )
	 **/
	public $samenvatting;
	
	/** 
	 * Een uitgebreide beschrijvende tekst over deze Locatie bedoeld ter verdere verduidelijking.  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
	 *
	 * @var string
	 *
     * @Gedmo\Translatable
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "text"
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 25,
	 *      max = 2000,
	 *      minMessage = "Uw beschrijving moet ten minste bestaan uit{{ limit }} tekens",
	 *      maxMessage = "Uw beschrijving kan niet langer zijn dan {{ limit }} tekens")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",	 
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
	 *             "minLength"=25,
	 *             "maxLength"=2000,
     *             "example"="Deze uitsterst sfeervolle trouwzaal is de droom van ieder koppel"
     *         }
     *     }
	 * )
	 **/
	public $beschrijving;
		
	/**
	 * URL-referentie naar de agenda van deze Locatie.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de agenda van deze Locatie."
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $agenda;
	
	/**
	 * De taal waarin de informatie van deze Locatie is opgesteld. <br /><b>Schema:</b> <a href="https://www.ietf.org/rfc/rfc3066.txt">https://www.ietf.org/rfc/rfc3066.txt</a>
	 *
	 * @var string Een Unicode language identifier, ofwel RFC 3066 taalcode.
	 *
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 2
	 * )
	 * @Groups({"read", "write"})
	 * @Assert\Language
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="NL"
	 *         }
	 *     }
	 * )
	 **/
	public $taal = 'nl';
	
	/**
	 * Producten die bij deze Locatie horen.
	 *
	 * @var array
	 * @ORM\Column(
	 *  	type="array", 
	 *  	nullable=true
	 *  )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="producten",
	 *             "type"="array",
	 *             "example"="[]",
	 *             "description"="Producten die bij deze Locatie horen"
	 *         }
	 *     }
	 * )
	 */	
	public $producten;
	
	/**
	 * Het tijdstip waarop dit Locatie object is aangemaakt.
	 *
	 * @var string Een "Y-m-d H:i:s" waarde bijvoorbeeld "2018-12-31 13:33:05" ofwel "Jaar-dag-maand uur:minuut:seconde"
	 * @Gedmo\Timestampable(on="create")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime"
	 * )
	 * @Groups({"read"})
	 */
	public $registratiedatum;
	
	/**
	 * Het tijdstip waarop dit Locatie object voor het laatst is gewijzigd.
	 *
	 * @var string Een "Y-m-d H:i:s" waarde bijvoorbeeld "2018-12-31 13:33:05" ofwel "Jaar-dag-maand uur:minuut:seconde"
	 * @Gedmo\Timestampable(on="update")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime",
	 *     nullable	= true
	 * )
	 * @Groups({"read"})
	 */
	public $wijzigingsdatum;
	
	/**
	 * De contactpersoon voor deze Locatie.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="Contactpersoon",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $contactPersoon;
	
	/**
	 * Met eigenaar wordt bijgehouden welke  applicatie verantwoordelijk is voor het object, en daarvoor de rechten beheert en uitgeeft. De eigenaar kan dan ook worden gezien in de trant van autorisatie en configuratie in plaats van als onderdeel van het datamodel.
	 *
	 * @var App\Entity\Applicatie $eigenaar
	 *
	 * @Gedmo\Blameable(on="create")
	 * @ORM\ManyToOne(targetEntity="App\Entity\Applicatie")
	 * @Groups({"read"})
	 */
	public $eigenaar;
	
	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->naam;
	}
		
	/**
	 * Vanuit rendering perspectief (voor bijvoorbeeld logging of berichten) is het belangrijk dat we een entiteit altijd naar string kunnen omzetten.
	 */
	public function __toString()
	{
		return $this->toString();
	}
	
	/**
	 * The pre persist function is called when the enity is first saved to the database and allows us to set some aditional first values
	 *
	 * @ORM\PrePersist
	 */
	public function prePersist()
	{
		$this->registratieDatum = new \ Datetime();
		// We want to add some default stuff here like products, productgroups, paymentproviders, templates, clientGroups, mailinglists and ledgers
		return $this;
	}

    public function getId(): ?int
    {
        return $this->id;
    }
	
	/**
	 * Get Url
	 */
	public function getUrl()
	{
		return 'http://locaties.demo.zaakonline.nl/locaties/'.$this->id;
	}

    public function getIdentificatie(): ?string
    {
        return $this->identificatie;
    }

    public function setIdentificatie(?string $identificatie): self
    {
        $this->identificatie = $identificatie;

        return $this;
    }

    public function getBronOrganisatie(): ?int
    {
        return $this->bronOrganisatie;
    }

    public function setBronOrganisatie(int $bronOrganisatie): self
    {
        $this->bronOrganisatie = $bronOrganisatie;

        return $this;
    }

    public function getAfbeelding(): ?string
    {
        return $this->afbeelding;
    }

    public function setAfbeelding(?string $afbeelding): self
    {
        $this->afbeelding = $afbeelding;

        return $this;
    }

    public function getFilm(): ?string
    {
        return $this->film;
    }

    public function setFilm(?string $film): self
    {
        $this->film = $film;

        return $this;
    }

    public function getBag(): ?string
    {
        return $this->bag;
    }

    public function setBag(?string $bag): self
    {
        $this->bag = $bag;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getSamenvatting(): ?string
    {
        return $this->samenvatting;
    }

    public function setSamenvatting(string $samenvatting): self
    {
        $this->samenvatting = $samenvatting;

        return $this;
    }

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    public function getAgenda(): ?string
    {
        return $this->agenda;
    }

    public function setAgenda(?string $agenda): self
    {
        $this->agenda = $agenda;

        return $this;
    }

    public function getTaal(): ?string
    {
        return $this->taal;
    }

    public function setTaal(string $taal): self
    {
        $this->taal = $taal;

        return $this;
    }

    public function getRegistratiedatum(): ?\DateTimeInterface
    {
        return $this->registratiedatum;
    }

    public function setRegistratiedatum(\DateTimeInterface $registratiedatum): self
    {
        $this->registratiedatum = $registratiedatum;

        return $this;
    }

    public function getWijzigingsdatum(): ?\DateTimeInterface
    {
        return $this->wijzigingsdatum;
    }

    public function setWijzigingsdatum(?\DateTimeInterface $wijzigingsdatum): self
    {
        $this->wijzigingsdatum = $wijzigingsdatum;

        return $this;
    }

    public function getContactPersoon(): ?string
    {
        return $this->contactPersoon;
    }

    public function setContactPersoon(?string $contactPersoon): self
    {
        $this->contactPersoon = $contactPersoon;

        return $this;
    }

    public function getEigenaar(): ?Applicatie
    {
        return $this->eigenaar;
    }

    public function setEigenaar(?Applicatie $eigenaar): self
    {
        $this->eigenaar = $eigenaar;

        return $this;
    }
}
