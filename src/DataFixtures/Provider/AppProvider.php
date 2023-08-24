<?php

namespace App\DataFixtures\Provider;

class AppProvider
{
    private $user = [
        "admin" => [
            "email" => "admin@histotrip.fr",
            "password" => "admin",
            "roles" => ["ROLE_ADMIN"],
            "lastname" => "Lfureux",
            "firstname" => "Sue",
            "pseudonym" => "sulfureux",
            "isActive" => 1
        ],
        "modo" => [
            "email" => "modo@histotrip.fr",
            "password" => "modo",
            "roles" => ["ROLE_MODERATOR"],
            "lastname" => "Remort",
            "firstname" => "Yves",
            "pseudonym" => "ivremort",
            "isActive" => 1
        ],
        "user" => [
            "email" => "user@histotrip.fr",
            "password" => "user",
            "roles" => [],
            "lastname" => "Mobil",
            "firstname" => "Otto",
            "pseudonym" => "automobile",
            "isActive" => 1
        ],
    ];

    private $categories = [
        ["Châteaux", "LuCastle"],
        ["Musées", "MdOutlineMuseum"],
        ["Citadelles", "FaFortAwesome"],
        ["Forts", "GiHillFort"],
        ["Cimetières", "LiaCrossSolid"],
        ["Églises", "PiChurchThin"],
        ["Monastères", "GiChurch"],
        ["Écomusées", "MdMuseum"],
        ["Monuments", "FaMonument"],
        ["Champs de Batailles", "GiGuards"],
        ["Mémorials", "GiMartyrMemorial"],
        ["Blockhaus", "GiBunker"],
        ["Centres d'interprétations", "LuCastle"],
        ["Autres", "LuCastle"],
        ["Artisanats", "GiAnvilImpact"],
        ["Ruines", "GiCastleRuins"],
        ["Villages", "GiVillage"],
        ["Musée d'art", "GiMonaLisa"],
    ];

    private $centuries = [
        "1" => [
            "century" => "I (1-100)",
            "period" => "Antiquité"
        ],
        "2" => [
            "century" => "II (101-200)",
            "period" => "Antiquité"
        ],
        "3" => [
            "century" => "III (201-300)",
            "period" => "Antiquité"
        ],
        "4" => [
            "century" => "IV (301-400)",
            "period" => "Antiquité"
        ],
        "5" => [
            "century" => "V (401-500)",
            "period" => "Antiquité tardive"
        ],
        "6" => [
            "century" => "VI (501-600)",
            "period" => "Haut Moyen Âge"
        ],
        "7" => [
            "century" => "VII (601-700)",
            "period" => "Haut Moyen Âge"
        ],
        "8" => [
            "century" => "VIII (701-800)",
            "period" => "Haut Moyen Âge"
        ],
        "9" => [
            "century" => "IX (801-900)",
            "period" => "Haut Moyen Âge"
        ],
        "10" => [
            "century" => "X (901-1000)",
            "period" => "Haut Moyen Âge"
        ],
        "11" => [
            "century" => "XI (1001-1100)",
            "period" => "Moyen Âge"
        ],
        "12" => [
            "century" => "XII (1101-1200)",
            "period" => "Moyen Âge"
        ],
        "13" => [
            "century" => "XIII (1201-1300)",
            "period" => "Moyen Âge"
        ],
        "14" => [
            "century" => "XIV (1301-1400)",
            "period" => "Moyen Âge"
        ],
        "15" => [
            "century" => "XV (1401-1500)",
            "period" => "Moyen Âge"
        ],
        "16" => [
            "century" => "XVI (1501-1600)",
            "period" => "Renaissance"
        ],
        "17" => [
            "century" => "XVII (1601-1700)",
            "period" => "Renaissance"
        ],
        "18" => [
            "century" => "XVIII (1701-1800)",
            "period" => "Siècle des Lumières"
        ],
        "19" => [
            "century" => "XIX (1801-1900)",
            "period" => "Révolution industrielle"
        ],
        "20" => [
            "century" => "XX (1901-2000)",
            "period" => "contemporaine"
        ],
        "21" => [
            "century" => "XXI (>2000)",
            "period" => "contemporaine"
        ]
    ];

    private $places = [
        [
            "name" => "Mémorial de Caen", 
            "coordinate" => "49.19747/-0.38402", 
            "adress" => "Esp. Général Eisenhower", 
            "postcode" => 14050, 
            "city" => "Caen", 
            "country" => "France", 
            "website" => "https://www.memorial-caen.fr/", 
            "phone" => "02 31 06 06 45", 
            "price" => "Tarif plein : 19,80€", 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => 1,
            "isValid" => 1,
            "slug" => "Mémorial-de-Caen",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Le_M%C3%A9morial_de_Caen.jpg/1280px-Le_M%C3%A9morial_de_Caen.jpg",
                "picture_legend" => "Le Mémorial de Caen./François Monier — Fonds photographique du Mémorial de Caen./CC BY-SA 4.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Mémorial de Verdun - Champ de Bataille", 
            "coordinate" => "49.19527/5.43362",
            "adress" => "1 av. Corps Européen", 
            "postcode" => 55100, 
            "city" => "Fleury-devant-Douaumont", 
            "country" => "France", 
            "website" => "https://memorial-verdun.fr/", 
            "phone" => "03 29 88 19 16", 
            "price" => "Tarif plein : 17€", 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null, 
            "isValid" => 1,
            "slug" => "Mémorial-de-Verdun-Champ-de-Bataille",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/M%C3%A9morial_de_Verdun_nouveau.jpg/1920px-M%C3%A9morial_de_Verdun_nouveau.jpg",
                "picture_legend" => "Vue extérieure du Mémorial de Verdun après sa rénovation en 2016/Jean-Marie Mangeot — © Mémorial de Verdun/CC BY-SA 3.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Monastère de Brou", 
            "coordinate" => "46.19835/5.23609", 
            "adress" => "63 Bd de Brou", 
            "postcode" => 01000, 
            "city" => "Bourg-En-Bresse", 
            "country" => "France", 
            "website" => "https://www.monastere-de-brou.fr/", 
            "phone" => "04 74 22 83 83", 
            "price" => "Tarif individuel: 9,50€", 
            "opening_hours" => "Du 1er avril au 30 septembre : 9h - 18h, Du 1er octobre au 31 mars :  9h - 17h", 
            "accessibility" => null, 
            "guided_tour" => 1,
            "isValid" => 1,
            "slug" => "Monastère-de-Brou",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Monast%C3%A8re_royal_de_Brou_%28%C3%A9glise%29_%281%29.JPG/2560px-Monast%C3%A8re_royal_de_Brou_%28%C3%A9glise%29_%281%29.JPG",
                "picture_legend" => "Vue de l'église du monastère./Benoît Prieur/CC 0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Château de Castelnaud", 
            "coordinate" => "44.81599/1.14849", 
            "adress" => "Château de Castelnaud Musée de la guerre au Moyen Age", 
            "postcode" => 24250, 
            "city" => "Castelnaud-la-Chapelle", 
            "country" => "France", 
            "website" => "https://castelnaud.com/", 
            "phone" => "05 53 31 30 00", 
            "price" => null, 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Château-de-Castelnaud",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Vue_d%27ensemble_Ch%C3%A2teau_de_Castelnaud.jpg/1920px-Vue_d%27ensemble_Ch%C3%A2teau_de_Castelnaud.jpg",
                "picture_legend" => "Château de Castelnaud/Château de Castelnaud - Musée de la guerre au Moyen Âge./CC BY-SA 3.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Château de Beynac", 
            "coordinate" => "44.84051/1.14595", 
            "adress" => "Le Château de Beynac, Place du château", 
            "postcode" => 24220, 
            "city" => "Beynac-et-Cazenac", 
            "country" => "France", 
            "website" => "https://chateau-beynac.com/", 
            "phone" => "05 53 29 50 40", 
            "price" => "Tarif adulte : 11,50€ ; Tarif jeune 11-16 ans: 7€ ; Enfant -10ans: Gratuit", 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Château-de-Beynac",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Ch%C3%A2teau_de_Beynac_%28Dordogne%29.jpg/1920px-Ch%C3%A2teau_de_Beynac_%28Dordogne%29.jpg",
                "picture_legend" => "Le château de Beynac/Gentil Hibou — Travail personnel/CC BY-SA 3.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Maison d'Izieu", 
            "coordinate" => "45.64902/5.63238", 
            "adress" => "70 Rte de Lambraz", 
            "postcode" => 01300, 
            "city" => "Izieu", 
            "country" => "France", 
            "website" => "https://www.memorializieu.eu/", 
            "phone" => "04 79 87 21 05", 
            "price" => "Tarif adulte : 11,50€ ; Tarif jeune 11-16 ans: 7€ ; Enfant -10ans: Gratuit", 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null, 
            "isValid" => 1,
            "slug" => "Maison-d-Izieu",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/Maison_Enfants_Izieu_5.jpg/1920px-Maison_Enfants_Izieu_5.jpg",
                "picture_legend" => "Mémorial des enfants d'Izieu/Chabe01/CC BY-SA 4.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Centre Historique de la Resistance et de la déporation", 
            "coordinate" => "45.74656/4.83596",  
            "adress" => "14 Av. Berthelot", 
            "postcode" => 69007, 
            "city" => "Lyon", 
            "country" => "France", 
            "website" => "https://www.chrd.lyon.fr/", 
            "phone" => "04 72 73 99 00", 
            "price" => null, 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Centre-Historique-de-la-Resistance-et-de-la-déporation",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/d/d0/Lyon_7e_Cour_Centre_Berthelot_Entree_CHRD_%40Laurent_Vella.jpg",
                "picture_legend" => "Entrée du CHRD située dans la cour du Centre Berthelot/Laurent Vella/CC BY-SA 4.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Mémorial National de la Prison de Montluc", 
            "coordinate" => "45.75080/4.86201", 
            "adress" => "4 Rue Jeanne Hachette", 
            "postcode" => 69003, 
            "city" => "Lyon ", 
            "country" => "France", 
            "website" => "https://www.memorial-montluc.fr/", 
            "phone" => "04 78 53 60 41", 
            "price" => "Gratuit", 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Mémorial-National-de-la-Prison-de-Montluc",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Prison_Militaire_Montluc_Lyon.jpg/1024px-Prison_Militaire_Montluc_Lyon.jpg",
                "picture_legend" => "Prison Militaire de Montluc à Lyon/© Xavier Caré / Wikimedia Commons/CC BY-SA 3.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Centre Historique minier de Lewarde", 
            "coordinate" => "50.33111/3.17274", 
            "adress" => "Fosse Delloye, Rue d'Erchin", 
            "postcode" => 59287, 
            "city" => "Lewarde", 
            "country" => "France", 
            "website" => "https://www.chm-lewarde.com/fr/", 
            "phone" => "03 27 95 82 82", 
            "price" => null, 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Centre-Historique-minier-de-Lewarde",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Lewarde_-_Fosse_Delloye_des_mines_d%27Aniche_%28324%29.JPG/1920px-Lewarde_-_Fosse_Delloye_des_mines_d%27Aniche_%28324%29.JPG",
                "picture_legend" => "Vue générale de la partie extractive./Jérémy Jännick — Travail personnel/Domaine Public",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Le musée de l'abri de Hatten", 
            "coordinate" => "48.89924/7.96774",  
            "adress" => "Rue de l'Abri", 
            "postcode" => 67690, 
            "city" => "Hatten", 
            "country" => "France", 
            "website" => "https://www.abrihatten.fr/", 
            "phone" => "03 88 80 14 90", 
            "price" => "Adultes: 8€ ; Enfants et étudiants : 5€", 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Le-musée-de-l'abri-de-Hatten",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Fort_Schoenenbourg_FRA_001.jpg/1920px-Fort_Schoenenbourg_FRA_001.jpg",
                "picture_legend" => "L'entrée des munitions de l'ouvrage./ignis — Travail personnel/GFDL,cc-by-sa-2.5,2.0,1.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "Fort L'Écluse", 
            "coordinate" => "46.12031/5.89197", 
            "adress" => "Rte de Genève", 
            "postcode" => 01200, 
            "city" => "Léaz", 
            "country" => "France", 
            "website" => "https://www.fortlecluse.fr/", 
            "phone" => "04 50 56 73 63", 
            "price" => null, 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 1,
            "slug" => "Fort-L-Écluse",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Fort_l_Ecluse.jpg/1024px-Fort_l_Ecluse.jpg",
                "picture_legend" => "Fort l’Écluse, à Léaz (Ain, Rhône-Alpes, France), depuis la route D 908./© Yann Forget / Wikimedia Commons/CC BY-SA 4.0",
                "isMain" => 1
            ]
        ],
        [
            "name" => "La ligne Maginot - Fort de Schoenenbourg", 
            "coordinate" => "48.96618/7.91250", 
            "adress" => "Rue Commandant Martial Reynier", 
            "postcode" => 67250, 
            "city" => "Hunspach", 
            "country" => "France", 
            "website" => "https://www.lignemaginot.com/", 
            "phone" => "03 88 80 96 19", 
            "price" => null, 
            "opening_hours" => null, 
            "accessibility" => null, 
            "guided_tour" => null,
            "isValid" => 0,
            "slug" => "La-ligne-Maginot-Fort-de-Schoenenbourg",
            "picture" => [
                "url" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Fort_Schoenenbourg_FRA_001.jpg/1920px-Fort_Schoenenbourg_FRA_001.jpg",
                "picture_legend" => "L'entrée des munitions de l'ouvrage./ignis — Travail personnel/GFDL,cc-by-sa-2.5,2.0,1.0",
                "isMain" => 1
            ]
        ],	
    ];

    public function user($role = null)
    {
        if ($role) {
            return $this->user[$role];
        }
        return $this->user[array_rand($this->user)];
    }

    public function getCategories()
    {
        return $this->categories;
    }
    
    public function getCenturies()
    {
        return $this->centuries;
    }

    public function getPlaces()
    {
        return $this->places;
    }
}