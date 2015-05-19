<?php
/* This umo_hangout_updated option is used to check whether running script is update version or older version*/
if( get_option('umo_hangout_updated') )
{
	$directory = plugin_dir_path(__FILE__);
	if( is_writable($directory.'google_hangout_plugin.php') )
	{
		$fh			=	file_get_contents($directory.'google_hangout_plugin.php');

		$lines		=	explode("\n",$fh);
		
		$lines[4]  	= 	'  * Description: Another <a href="http://www.universalmedia-online.com" target="_blank">UMO</a> plugin. Allowing you to create Webinars from hangouts with registrations and follow ups. <a href="http://runclick.com/changelog.txt" target="_blank" />Change Log </a>';
		$lines[6]  	= 	' * Version: '. get_option('umo_hangout_version');
		
		$data		=	implode("\n",$lines);

		if( file_put_contents($directory.'google_hangout_plugin.php',$data) )
		{
			update_option('umo_hangout_updated',0);
		}
	}
}
add_action('admin_menu','ghangout_themes_option_menu');
add_action('admin_print_styles','ghangout_stylesheet_include');

/* function name: google_hangout_event_post_type
   Description:  Create New post type for Run Click Webinar
*/
function google_hangout_event_post_type(){
	register_post_type('ghangout',array(
						'public' => true,
						'show_ui' =>false,
						'supports'=> array('title','editor','custom-fields','comments') // this is IMPORTANT

									
	));
	flush_rewrite_rules(false);
 }
// google_hangout_event_post_type funciton is called on init to create custom post type for run click
 add_action('init','google_hangout_event_post_type');

 
/* function name: google_hangout_create_location
   Description:  google_hangout_create_location funciton is used to check whether all new fields are in db or not. If not then we add here.
*/
function google_hangout_create_location(){
	global $wpdb;
		
		$update_optionget_option	=	trim(get_option('runclick_collumn_updated'));
		if($update_optionget_option == '' || $update_optionget_option =='1')
		{
			$sql1_alter="ALTER TABLE `".$wpdb->prefix."google_hangout_subscriber`  MODIFY `organization` VARCHAR(255) NOT NULL , MODIFY `hangout_date` DATE NOT NULL , MODIFY `hangout_time`  varchar(255) NOT NULL , MODIFY `reminder_time`  varchar(255) NOT NULL";
			$wpdb->query($sql1_alter);
			update_option('runclick_collumn_updated','updated');
		}
		$update_vote_option	=	trim(get_option('update_vote_option'));
		if($update_vote_option == '' || $update_vote_option =='1'  || $update_vote_option =='updated')
		{
			$sql1_alter="ALTER TABLE `hangout_vote`  ADD `option_number` int(11) NOT NULL ";
			$wpdb->query($sql1_alter);
			update_option('update_vote_option','donotupdate');
		}
		
	
	/* Insert list of all location */									
	if($wpdb->get_var("show tables like '".$wpdb->prefix."location'") != $wpdb->prefix."location")
	{
		$sql1 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."location` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
		  `time_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
		  `title` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3687" ;


		$sql2 = "
		INSERT INTO `".$wpdb->prefix."location` (`id`, `name`, `time_code`, `title`) VALUES
		(1, 'cote-divoire/abidjan', 'Abidjan', 'Cote d''Ivoire'),
		(2, 'united-arab-emirates/abu-dhabi', 'Abu Dhabi', 'United Arab Emirates'),
		(3, 'mexico/acapulco', 'Acapulco', 'Mexico'),
		(4, 'ghana/accra', 'Accra', 'Ghana'),
		(5, 'australia/adelaide', 'Adelaide', 'Australia'),
		(6, 'yemen/aden', 'Aden', 'Yemen'),
		(7, 'ethiopia/addis-ababa', 'Addis Ababa', 'Ethiopia'),
		(8, 'qatar/doha', 'Doha', 'Qatar'),
		(9, 'mexico/aguascalientes', 'Aguascalientes', 'Mexico'),
		(10, 'canada/aklavik', 'Aklavik', 'Canada'),
		(11, 'jordan/amman', 'Amman', 'Jordan'),
		(12, 'usa/albany', 'Albany', 'United States'),
		(13, 'usa/adak', 'Adak', 'United States'),
		(14, 'algeria/algiers', 'Algiers', 'Algeria'),
		(15, 'bahrain/manama', 'Manama', 'Bahrain'),
		(16, 'netherlands/amsterdam', 'Amsterdam', 'Netherlands'),
		(17, 'russia/anadyr', 'Anadyr', 'Russia'),
		(18, 'usa/anchorage', 'Anchorage', 'United States'),
		(19, 'turkey/ankara', 'Ankara', 'Turkey'),
		(20, 'madagascar/antananarivo', 'Antananarivo', 'Madagascar'),
		(21, 'paraguay/asuncion', 'Asuncion', 'Paraguay'),
		(22, 'new-zealand/auckland', 'Auckland', 'New Zealand'),
		(23, 'usa/augusta', 'Augusta', 'United States'),
		(24, 'usa/austin', 'Austin', 'United States'),
		(25, 'usa/atlanta', 'Atlanta', 'United States'),
		(26, 'greece/athens', 'Athens', 'Greece'),
		(27, 'iraq/baghdad', 'Baghdad', 'Iraq'),
		(28, 'thailand/bangkok', 'Bangkok', 'Thailand'),
		(29, 'mali/bamako', 'Bamako', 'Mali'),
		(30, 'gambia/banjul', 'Banjul', 'The Gambia'),
		(31, 'spain/barcelona', 'Barcelona', 'Spain'),
		(32, 'usa/baton-rouge', 'Baton Rouge', 'United States'),
		(33, 'china/beijing', 'Beijing', 'China'),
		(34, 'lebanon/beirut', 'Beirut', 'Lebanon'),
		(35, 'serbia/belgrade', 'Belgrade', 'Serbia'),
		(36, 'belize/belmopan', 'Belmopan', 'Belize'),
		(37, 'germany/berlin', 'Berlin', 'Germany'),
		(38, 'bermuda/hamilton', 'Hamilton', 'Bermuda'),
		(39, 'usa/bismarck', 'Bismarck', 'United States'),
		(40, 'guinea-bissau/bissau', 'Bissau', 'Guinea-Bissau'),
		(41, 'colombia/bogota', 'Bogota', 'Colombia'),
		(42, 'usa/boise', 'Boise', 'United States'),
		(43, 'usa/boston', 'Boston', 'United States'),
		(44, 'india/mumbai', 'Mumbai', 'India'),
		(45, 'brazil/brasilia', 'Brasilia', 'Brazil'),
		(46, 'barbados/bridgetown', 'Bridgetown', 'Barbados'),
		(47, 'australia/brisbane', 'Brisbane', 'Australia'),
		(48, 'belgium/brussels', 'Brussels', 'Belgium'),
		(49, 'romania/bucharest', 'Bucharest', 'Romania'),
		(50, 'hungary/budapest', 'Budapest', 'Hungary'),
		(51, 'argentina/buenos-aires', 'Buenos Aires', 'Argentina'),
		(52, 'burundi/bujumbura', 'Bujumbura', 'Burundi'),
		(53, 'egypt/cairo', 'Cairo', 'Egypt'),
		(54, 'india/kolkata', 'Kolkata', 'India'),
		(55, 'canada/calgary', 'Calgary', 'Canada'),
		(56, 'south-africa/cape-town', 'Cape Town', 'South Africa'),
		(57, 'australia/canberra', 'Canberra', 'Australia'),
		(58, 'venezuela/caracas', 'Caracas', 'Venezuela'),
		(59, 'usa/carson-city', 'Carson City', 'United States'),
		(60, 'morocco/casablanca', 'Casablanca', 'Morocco'),
		(61, 'france/cayenne', 'Cayenne', 'French Guiana'),
		(62, 'usa/charleston-wv', 'Charleston Wv', 'United States'),
		(63, 'new-zealand/chatham-islands', 'Chatham Islands', 'New Zealand'),
		(64, 'usa/chicago', 'Chicago', 'United States'),
		(65, 'mexico/chihuahua', 'Chihuahua', 'Mexico'),
		(66, 'usa/columbia', 'Columbia', 'United States'),
		(67, 'guinea/conakry', 'Conakry', 'Guinea'),
		(68, 'usa/concord', 'Concord', 'United States'),
		(69, 'denmark/copenhagen', 'Copenhagen', 'Denmark'),
		(70, 'usa/dallas', 'Dallas', 'United States'),
		(71, 'tanzania/dar-es-salaam', 'Dar Es Salaam', 'Tanzania'),
		(72, 'australia/darwin', 'Darwin', 'Australia'),
		(73, 'bangladesh/dhaka', 'Dhaka', 'Bangladesh'),
		(74, 'senegal/dakar', 'Dakar', 'Senegal'),
		(75, 'usa/denver', 'Denver', 'United States'),
		(76, 'usa/des-moines', 'Des Moines', 'United States'),
		(77, 'usa/detroit', 'Detroit', 'United States'),
		(78, 'ireland/dublin', 'Dublin', 'Ireland'),
		(79, 'germany/dusseldorf', 'Dusseldorf', 'Germany'),
		(80, 'canada/edmonton', 'Edmonton', 'Canada'),
		(81, 'usa/fairbanks', 'Fairbanks', 'United States'),
		(82, 'fiji/suva', 'Suva', 'Fiji'),
		(83, 'germany/frankfurt', 'Frankfurt', 'Germany'),
		(84, 'usa/frankfort', 'Frankfort', 'United States'),
		(85, 'sierra-leone/freetown', 'Freetown', 'Sierra Leone'),
		(86, 'botswana/gaborone', 'Gaborone', 'Botswana'),
		(87, 'switzerland/geneva', 'Geneva', 'Switzerland'),
		(88, 'guyana/georgetown', 'Georgetown', 'Guyana'),
		(89, 'gibraltar/gibraltar', 'Gibraltar', 'Gibraltar'),
		(90, 'uk/glasgow', 'Glasgow', 'United Kingdom'),
		(91, 'usa/guam-hagatna', 'Guam Hagatna', 'Guam'),
		(92, 'mexico/guadalajara', 'Guadalajara', 'Mexico'),
		(93, 'ecuador/guayaquil', 'Guayaquil', 'Ecuador'),
		(94, 'guatemala/guatemala', 'Guatemala', 'Guatemala'),
		(95, 'vietnam/hanoi', 'Hanoi', 'Vietnam'),
		(96, 'zimbabwe/harare', 'Harare', 'Zimbabwe'),
		(97, 'usa/harrisburg', 'Harrisburg', 'United States'),
		(98, 'usa/hartford', 'Hartford', 'United States'),
		(99, 'cuba/havana', 'Havana', 'Cuba'),
		(100, 'usa/helena', 'Helena', 'United States'),
		(101, 'finland/helsinki', 'Helsinki', 'Finland'),
		(102, 'hong-kong/hong-kong', 'Hong Kong', 'Hong Kong'),
		(103, 'usa/honolulu', 'Honolulu', 'United States'),
		(104, 'usa/houston', 'Houston', 'United States'),
		(105, 'usa/indianapolis', 'Indianapolis', 'United States'),
		(106, 'pakistan/islamabad', 'Islamabad', 'Pakistan'),
		(107, 'turkey/istanbul', 'Istanbul', 'Turkey'),
		(108, 'indonesia/jakarta', 'Jakarta', 'Indonesia'),
		(109, 'usa/jefferson-city', 'Jefferson City', 'United States'),
		(110, 'israel/jerusalem', 'Jerusalem', 'Israel'),
		(111, 'south-africa/johannesburg', 'Johannesburg', 'South Africa'),
		(112, 'usa/juneau', 'Juneau', 'United States'),
		(113, 'afghanistan/kabul', 'Kabul', 'Afghanistan'),
		(114, 'russia/petropavlovsk-kamchatsky', 'Petropavlovsk Kamchatsky', 'Russia'),
		(115, 'uganda/kampala', 'Kampala', 'Uganda'),
		(116, 'nigeria/kano', 'Kano', 'Nigeria'),
		(117, 'nepal/kathmandu', 'Kathmandu', 'Nepal'),
		(118, 'sudan/khartoum', 'Khartoum', 'Sudan'),
		(119, 'rwanda/kigali', 'Kigali', 'Rwanda'),
		(120, 'jamaica/kingston', 'Kingston', 'Jamaica'),
		(121, 'congo-demrep/kinshasa', 'Kinshasa', 'Congo Dem.Rep.'),
		(122, 'malaysia/kuala-lumpur', 'Kuala Lumpur', 'Malaysia'),
		(123, 'kuwait/kuwait-city', 'Kuwait City', 'Kuwait'),
		(124, 'bolivia/la-paz', 'La Paz', 'Bolivia'),
		(125, 'nigeria/lagos', 'Lagos', 'Nigeria'),
		(126, 'usa/lansing', 'Lansing', 'United States'),
		(127, 'usa/las-vegas', 'Las Vegas', 'United States'),
		(128, 'mexico/leon', 'Leon', 'Mexico'),
		(129, 'gabon/libreville', 'Libreville', 'Gabon'),
		(130, 'malawi/lilongwe', 'Lilongwe', 'Malawi'),
		(131, 'peru/lima', 'Lima', 'Peru'),
		(132, 'usa/lincoln', 'Lincoln', 'United States'),
		(133, 'portugal/lisbon', 'Lisbon', 'Portugal'),
		(134, 'usa/little-rock', 'Little Rock', 'United States'),
		(135, 'togo/lome', 'Lome', 'Togo'),
		(136, 'uk/london', 'London', 'United Kingdom'),
		(137, 'usa/los-angeles', 'Los Angeles', 'United States'),
		(138, 'angola/luanda', 'Luanda', 'Angola'),
		(139, 'congo-demrep/lubumbashi', 'Lubumbashi', 'Congo Dem.Rep.'),
		(140, 'zambia/lusaka', 'Lusaka', 'Zambia'),
		(141, 'spain/madrid', 'Madrid', 'Spain'),
		(142, 'usa/madison', 'Madison', 'United States'),
		(143, 'nicaragua/managua', 'Managua', 'Nicaragua'),
		(144, 'brazil/manaus', 'Manaus', 'Brazil'),
		(145, 'philippines/manila', 'Manila', 'Philippines'),
		(146, 'mozambique/maputo', 'Maputo', 'Mozambique'),
		(147, 'lesotho/maseru', 'Maseru', 'Lesotho'),
		(148, 'mexico/mazatlan', 'Mazatlan', 'Mexico'),
		(149, 'swaziland/mbabane', 'Mbabane', 'Swaziland'),
		(150, 'colombia/medellin', 'Medellin', 'Colombia'),
		(151, 'saudi-arabia/makkah', 'Makkah', 'Saudi Arabia'),
		(152, 'australia/melbourne', 'Melbourne', 'Australia'),
		(153, 'mexico/merida', 'Merida', 'Mexico'),
		(154, 'mexico/mexicali', 'Mexicali', 'Mexico'),
		(155, 'mexico/mexico-city', 'Mexico City', 'Mexico'),
		(156, 'usa/miami', 'Miami', 'United States'),
		(157, 'italy/milan', 'Milan', 'Italy'),
		(158, 'usa/milwaukee', 'Milwaukee', 'United States'),
		(159, 'usa/minneapolis', 'Minneapolis', 'United States'),
		(160, 'somalia/mogadishu', 'Mogadishu', 'Somalia'),
		(161, 'liberia/monrovia', 'Monrovia', 'Liberia'),
		(162, 'mexico/monterrey', 'Monterrey', 'Mexico'),
		(163, 'uruguay/montevideo', 'Montevideo', 'Uruguay'),
		(164, 'usa/montpelier', 'Montpelier', 'United States'),
		(165, 'canada/montreal', 'Montreal', 'Canada'),
		(166, 'russia/moscow', 'Moscow', 'Russia'),
		(167, 'russia/murmansk', 'Murmansk', 'Russia'),
		(168, 'germany/munich', 'Munich', 'Germany'),
		(169, 'oman/muscat', 'Muscat', 'Oman'),
		(170, 'kenya/nairobi', 'Nairobi', 'Kenya'),
		(171, 'usa/nashville', 'Nashville', 'United States'),
		(172, 'italy/naples', 'Naples', 'Italy'),
		(173, 'bahamas/nassau', 'Nassau', 'The Bahamas'),
		(174, 'chad/ndjamena', 'Ndjamena', 'Chad'),
		(175, 'canada/st-johns', 'St Johns', 'Canada'),
		(176, 'india/new-delhi', 'New Delhi', 'India'),
		(177, 'moldova/kishinev', 'Kishinev', 'Moldova'),
		(178, 'usa/new-orleans', 'New Orleans', 'United States'),
		(179, 'usa/new-york', 'New York', 'United States'),
		(180, 'niger/niamey', 'Niamey', 'Niger'),
		(181, 'france/nice', 'Nice', 'France'),
		(182, 'usa/nome', 'Nome', 'United States'),
		(183, 'mauritania/nouakchott', 'Nouakchott', 'Mauritania'),
		(184, 'usa/oklahoma-city', 'Oklahoma City', 'United States'),
		(185, 'usa/olympia', 'Olympia', 'United States'),
		(186, 'burkina-faso/ouagadougou', 'Ouagadougou', 'Burkina Faso'),
		(187, 'norway/oslo', 'Oslo', 'Norway'),
		(188, 'canada/ottawa', 'Ottawa', 'Canada'),
		(189, 'canada/quebec', 'Quebec', 'Canada'),
		(190, 'ecuador/quito', 'Quito', 'Ecuador'),
		(191, 'spain/palma', 'Palma', 'Spain'),
		(192, 'panama/panama', 'Panama', 'Panama'),
		(193, 'papua-new-guinea/port-moresby', 'Port Moresby', 'Papua New Guinea'),
		(194, 'suriname/paramaribo', 'Paramaribo', 'Suriname'),
		(195, 'france/paris', 'Paris', 'France'),
		(196, 'australia/perth', 'Perth', 'Australia'),
		(197, 'usa/phoenix', 'Phoenix', 'United States'),
		(198, 'usa/philadelphia', 'Philadelphia', 'United States'),
		(199, 'cambodia/phnom-penh', 'Phnom Penh', 'Cambodia'),
		(200, 'usa/pierre', 'Pierre', 'United States'),
		(201, 'mauritius/port-louis', 'Port Louis', 'Mauritius'),
		(202, 'usa/portland-or', 'Portland Or', 'United States'),
		(203, 'benin/porto-novo', 'Porto Novo', 'Benin'),
		(204, 'czech-republic/prague', 'Prague', 'Czech Republic'),
		(205, 'north-korea/pyongyang', 'Pyongyang', 'North Korea'),
		(206, 'morocco/rabat', 'Rabat', 'Morocco'),
		(207, 'usa/raleigh', 'Raleigh', 'United States'),
		(208, 'myanmar/yangon', 'Yangon', 'Myanmar'),
		(209, 'brazil/recife', 'Recife', 'Brazil'),
		(210, 'canada/regina', 'Regina', 'Canada'),
		(211, 'iceland/reykjavik', 'Reykjavik', 'Iceland'),
		(212, 'usa/richmond', 'Richmond', 'United States'),
		(213, 'brazil/rio-de-janeiro', 'Rio De Janeiro', 'Brazil'),
		(214, 'saudi-arabia/riyadh', 'Riyadh', 'Saudi Arabia'),
		(215, 'italy/rome', 'Rome', 'Italy'),
		(216, 'reunion/saint-denis', 'Saint Denis', 'Reunion'),
		(217, 'usa/sacramento', 'Sacramento', 'United States'),
		(218, 'vietnam/ho-chi-minh', 'Ho Chi Minh', 'Vietnam'),
		(219, 'usa/st-paul', 'St Paul', 'United States'),
		(220, 'usa/salt-lake-city', 'Salt Lake City', 'United States'),
		(221, 'usa/salem', 'Salem', 'United States'),
		(222, 'brazil/salvador', 'Salvador', 'Brazil'),
		(223, 'austria/salzburg', 'Salzburg', 'Austria'),
		(224, 'usa/san-francisco', 'San Francisco', 'United States'),
		(225, 'costa-rica/san-jose', 'San Jose', 'Costa Rica'),
		(226, 'puerto-rico/san-juan', 'San Juan', 'Puerto Rico'),
		(227, 'mexico/san-luis-potosi', 'San Luis Potosi', 'Mexico'),
		(228, 'el-salvador/san-salvador', 'San Salvador', 'El Salvador'),
		(229, 'el-salvador/santa-ana', 'Santa Ana', 'El Salvador'),
		(230, 'dominican-republic/santo-domingo', 'Santo Domingo', 'Dominican Republic'),
		(231, 'usa/santa-fe', 'Santa Fe', 'United States'),
		(232, 'chile/santiago', 'Santiago', 'Chile'),
		(233, 'brazil/sao-paulo', 'Sao Paulo', 'Brazil'),
		(234, 'usa/seattle', 'Seattle', 'United States'),
		(235, 'south-korea/seoul', 'Seoul', 'South Korea'),
		(236, 'singapore/singapore', 'Singapore', 'Singapore'),
		(237, 'china/shanghai', 'Shanghai', 'China'),
		(238, 'bulgaria/sofia', 'Sofia', 'Bulgaria'),
		(239, 'sweden/stockholm', 'Stockholm', 'Sweden'),
		(240, 'australia/sydney', 'Sydney', 'Australia'),
		(241, 'taiwan/taipei', 'Taipei', 'Taiwan'),
		(242, 'estonia/tallinn', 'Tallinn', 'Estonia'),
		(243, 'morocco/tanger', 'Tanger', 'Morocco'),
		(244, 'uzbekistan/tashkent', 'Tashkent', 'Uzbekistan'),
		(245, 'honduras/tegucigalpa', 'Tegucigalpa', 'Honduras'),
		(246, 'iran/tehran', 'Tehran', 'Iran'),
		(247, 'mexico/tijuana', 'Tijuana', 'Mexico'),
		(248, 'japan/tokyo', 'Tokyo', 'Japan'),
		(249, 'usa/topeka', 'Topeka', 'United States'),
		(250, 'canada/toronto', 'Toronto', 'Canada'),
		(251, 'usa/trenton', 'Trenton', 'United States'),
		(252, 'libya/tripoli', 'Tripoli', 'Libya'),
		(253, 'tunisia/tunis', 'Tunis', 'Tunisia'),
		(254, 'italy/turin', 'Turin', 'Italy'),
		(255, 'malta/valletta', 'Valletta', 'Malta'),
		(256, 'canada/vancouver', 'Vancouver', 'Canada'),
		(257, 'italy/venice', 'Venice', 'Italy'),
		(258, 'mexico/veracruz', 'Veracruz', 'Mexico'),
		(259, 'austria/vienna', 'Vienna', 'Austria'),
		(260, 'laos/vientiane', 'Vientiane', 'Laos'),
		(261, 'russia/vladivostok', 'Vladivostok', 'Russia'),
		(262, 'poland/warsaw', 'Warsaw', 'Poland'),
		(263, 'usa/washington-dc', 'Washington Dc', 'United States'),
		(264, 'new-zealand/wellington', 'Wellington', 'New Zealand'),
		(265, 'canada/winnipeg', 'Winnipeg', 'Canada'),
		(266, 'namibia/windhoek', 'Windhoek', 'Namibia'),
		(267, 'cameroon/yaounde', 'Yaounde', 'Cameroon'),
		(268, 'switzerland/zurich', 'Zurich', 'Switzerland'),
		(269, 'south-africa/pretoria', 'Pretoria', 'South Africa'),
		(270, 'switzerland/bern', 'Bern', 'Switzerland'),
		(271, 'portugal/azores', 'Azores', 'Portugal'),
		(272, 'tuvalu/funafuti', 'Funafuti', 'Tuvalu'),
		(273, 'solomon-islands/honiara', 'Honiara', 'Solomon Islands'),
		(274, 'kiribati/kiritimati', 'Kiritimati', 'Kiribati'),
		(275, 'micronesia/kolonia', 'Kolonia', 'Micronesia'),
		(276, 'nauru/yaren', 'Yaren', 'Nauru'),
		(277, 'tonga/nukualofa', 'Nukualofa', 'Tonga'),
		(278, 'france/papeete', 'Papeete', 'France'),
		(279, 'cook-islands/rarotonga', 'Rarotonga', 'Cook Islands'),
		(280, 'vanuatu/port-vila', 'Port Vila', 'Vanuatu'),
		(281, 'croatia/zagreb', 'Zagreb', 'Croatia'),
		(282, 'samoa/apia', 'Apia', 'Samoa'),
		(283, 'usa/san-jose', 'San Jose', 'United States'),
		(284, 'albania/tirana', 'Tirana', 'Albania'),
		(285, 'belarus/minsk', 'Minsk', 'Belarus'),
		(286, 'canada/halifax', 'Halifax', 'Canada'),
		(287, 'norway/bergen', 'Bergen', 'Norway'),
		(288, 'norway/trondheim', 'Trondheim', 'Norway'),
		(289, 'norway/stavanger', 'Stavanger', 'Norway'),
		(290, 'norway/tromso', 'Tromso', 'Norway'),
		(291, 'sweden/goteborg', 'Goteborg', 'Sweden'),
		(292, 'sweden/sundsvall', 'Sundsvall', 'Sweden'),
		(293, 'sweden/malmo', 'Malmo', 'Sweden'),
		(294, 'sweden/ostersund', 'Ostersund', 'Sweden'),
		(295, 'finland/oulu', 'Oulu', 'Finland'),
		(296, 'finland/turku', 'Turku', 'Finland'),
		(297, 'uk/birmingham', 'Birmingham', 'United Kingdom'),
		(298, 'uk/cardiff', 'Cardiff', 'United Kingdom'),
		(299, 'uk/bristol', 'Bristol', 'United Kingdom'),
		(300, 'uk/southampton', 'Southampton', 'United Kingdom'),
		(301, 'uk/liverpool', 'Liverpool', 'United Kingdom'),
		(302, 'uk/manchester', 'Manchester', 'United Kingdom'),
		(303, 'uk/leeds', 'Leeds', 'United Kingdom'),
		(304, 'uk/edinburgh', 'Edinburgh', 'United Kingdom'),
		(305, 'uk/aberdeen', 'Aberdeen', 'United Kingdom'),
		(306, 'germany/kiel', 'Kiel', 'Germany'),
		(307, 'germany/hamburg', 'Hamburg', 'Germany'),
		(308, 'germany/bremen', 'Bremen', 'Germany'),
		(309, 'germany/hannover', 'Hannover', 'Germany'),
		(310, 'germany/essen', 'Essen', 'Germany'),
		(311, 'germany/cologne', 'Cologne', 'Germany'),
		(312, 'germany/bonn', 'Bonn', 'Germany'),
		(313, 'germany/leipzig', 'Leipzig', 'Germany'),
		(314, 'germany/dresden', 'Dresden', 'Germany'),
		(315, 'germany/dortmund', 'Dortmund', 'Germany'),
		(316, 'germany/nuremberg', 'Nuremberg', 'Germany'),
		(317, 'germany/stuttgart', 'Stuttgart', 'Germany'),
		(318, 'austria/graz', 'Graz', 'Austria'),
		(319, 'austria/linz', 'Linz', 'Austria'),
		(320, 'portugal/porto', 'Porto', 'Portugal'),
		(321, 'spain/sevilla', 'Sevilla', 'Spain'),
		(322, 'spain/cordoba', 'Cordoba', 'Spain'),
		(323, 'spain/malaga', 'Malaga', 'Spain'),
		(324, 'spain/murcia', 'Murcia', 'Spain'),
		(325, 'spain/valencia', 'Valencia', 'Spain'),
		(326, 'spain/zaragoza', 'Zaragoza', 'Spain'),
		(327, 'spain/bilbao', 'Bilbao', 'Spain'),
		(328, 'france/bordeaux', 'Bordeaux', 'France'),
		(329, 'france/toulouse', 'Toulouse', 'France'),
		(330, 'france/marseille', 'Marseille', 'France'),
		(331, 'france/nantes', 'Nantes', 'France'),
		(332, 'france/strasbourg', 'Strasbourg', 'France'),
		(333, 'france/lyon', 'Lyon', 'France'),
		(334, 'france/le-havre', 'Le Havre', 'France'),
		(335, 'france/brest', 'Brest', 'France'),
		(336, 'france/lille', 'Lille', 'France'),
		(337, 'belgium/antwerp', 'Antwerp', 'Belgium'),
		(338, 'netherlands/rotterdam', 'Rotterdam', 'Netherlands'),
		(339, 'italy/bologna', 'Bologna', 'Italy'),
		(340, 'italy/genoa', 'Genoa', 'Italy'),
		(341, 'italy/firenze', 'Firenze', 'Italy'),
		(342, 'italy/bari', 'Bari', 'Italy'),
		(343, 'italy/messina', 'Messina', 'Italy'),
		(344, 'italy/palermo', 'Palermo', 'Italy'),
		(345, 'italy/catania', 'Catania', 'Italy'),
		(346, 'italy/cagliari', 'Cagliari', 'Italy'),
		(347, 'russia/volgograd', 'Volgograd', 'Russia'),
		(348, 'russia/rostov', 'Rostov', 'Russia'),
		(349, 'russia/saratov', 'Saratov', 'Russia'),
		(350, 'russia/voronezh', 'Voronezh', 'Russia'),
		(351, 'russia/krasnodar', 'Krasnodar', 'Russia'),
		(352, 'russia/saint-peterburg', 'Saint Peterburg', 'Russia'),
		(353, 'russia/novgorod', 'Novgorod', 'Russia'),
		(354, 'russia/kazan', 'Kazan', 'Russia'),
		(355, 'russia/samara', 'Samara', 'Russia'),
		(356, 'russia/ufa', 'Ufa', 'Russia'),
		(357, 'russia/perm', 'Perm', 'Russia'),
		(358, 'russia/yekaterinburg', 'Yekaterinburg', 'Russia'),
		(359, 'russia/penza', 'Penza', 'Russia'),
		(360, 'russia/yaroslavl', 'Yaroslavl', 'Russia'),
		(361, 'russia/ulyanovsk', 'Ulyanovsk', 'Russia'),
		(362, 'russia/tolyatti', 'Tolyatti', 'Russia'),
		(363, 'russia/orenburg', 'Orenburg', 'Russia'),
		(364, 'russia/izhevsk', 'Izhevsk', 'Russia'),
		(365, 'ukraine/simferopol', 'Simferopol', 'Ukraine'),
		(366, 'ukraine/odesa', 'Odesa', 'Ukraine'),
		(367, 'ukraine/kyiv', 'Kyiv', 'Ukraine'),
		(368, 'ukraine/lviv', 'Lviv', 'Ukraine'),
		(369, 'azerbaijan/baku', 'Baku', 'Azerbaijan'),
		(370, 'armenia/yerevan', 'Yerevan', 'Armenia'),
		(371, 'georgia/tbilisi', 'Tbilisi', 'Georgia'),
		(372, 'russia/krasnoyarsk', 'Krasnoyarsk', 'Russia'),
		(373, 'russia/chelyabinsk', 'Chelyabinsk', 'Russia'),
		(374, 'russia/omsk', 'Omsk', 'Russia'),
		(375, 'russia/novosibirsk', 'Novosibirsk', 'Russia'),
		(376, 'russia/novokuznetsk', 'Novokuznetsk', 'Russia'),
		(377, 'uk/georgetown', 'Georgetown', 'Cayman Islands'),
		(378, 'russia/irkutsk', 'Irkutsk', 'Russia'),
		(379, 'russia/khabarovsk', 'Khabarovsk', 'Russia'),
		(380, 'russia/magadan', 'Magadan', 'Russia'),
		(381, 'russia/norilsk', 'Norilsk', 'Russia'),
		(382, 'kazakstan/almaty', 'Almaty', 'Kazakhstan'),
		(383, 'kazakstan/karaganda', 'Karaganda', 'Kazakhstan'),
		(384, 'kyrgyzstan/bishkek', 'Bishkek', 'Kyrgyzstan'),
		(385, 'tajikistan/dushanbe', 'Dushanbe', 'Tajikistan'),
		(386, 'uzbekistan/samarkand', 'Samarkand', 'Uzbekistan'),
		(387, 'turkmenistan/ashgabat', 'Ashgabat', 'Turkmenistan'),
		(388, 'usa/oakland', 'Oakland', 'United States'),
		(389, 'sri-lanka/colombo', 'Colombo', 'Sri Lanka'),
		(390, 'usa/fresno', 'Fresno', 'United States'),
		(391, 'usa/tacoma', 'Tacoma', 'United States'),
		(392, 'usa/spokane', 'Spokane', 'United States'),
		(393, 'usa/tucson', 'Tucson', 'United States'),
		(394, 'usa/albuquerque', 'Albuquerque', 'United States'),
		(395, 'usa/el-paso', 'El Paso', 'United States'),
		(396, 'australia/hobart', 'Hobart', 'Australia'),
		(397, 'kergulen/port-aux-francais', 'Port Aux Francais', 'Kerguelen Islands'),
		(398, 'usa/colorado-springs', 'Colorado Springs', 'United States'),
		(399, 'usa/pueblo', 'Pueblo', 'United States'),
		(400, 'usa/san-antonio', 'San Antonio', 'United States'),
		(401, 'usa/fort-worth', 'Fort Worth', 'United States'),
		(402, 'usa/tulsa', 'Tulsa', 'United States'),
		(403, 'usa/wichita', 'Wichita', 'United States'),
		(404, 'usa/omaha', 'Omaha', 'United States'),
		(405, 'usa/kansas-city', 'Kansas City', 'United States'),
		(406, 'usa/mobile', 'Mobile', 'United States'),
		(407, 'usa/montgomery', 'Montgomery', 'United States'),
		(408, 'usa/birmingham', 'Birmingham', 'United States'),
		(409, 'usa/memphis', 'Memphis', 'United States'),
		(410, 'usa/tampa', 'Tampa', 'United States'),
		(411, 'usa/jacksonville', 'Jacksonville', 'United States'),
		(412, 'usa/charlotte', 'Charlotte', 'United States'),
		(413, 'usa/louisville', 'Louisville', 'United States'),
		(414, 'usa/cincinnati', 'Cincinnati', 'United States'),
		(415, 'usa/akron', 'Akron', 'United States'),
		(416, 'usa/toledo', 'Toledo', 'United States'),
		(417, 'usa/cleveland', 'Cleveland', 'United States'),
		(418, 'usa/pittsburgh', 'Pittsburgh', 'United States'),
		(419, 'usa/baltimore', 'Baltimore', 'United States'),
		(420, 'usa/norfolk', 'Norfolk', 'United States'),
		(421, 'usa/rochester', 'Rochester', 'United States'),
		(422, 'usa/buffalo', 'Buffalo', 'United States'),
		(423, 'india/ahmadabad', 'Ahmadabad', 'India'),
		(424, 'egypt/al-jizah', 'Al Jizah', 'Egypt'),
		(425, 'brazil/alagoinhas', 'Alagoinhas', 'Brazil'),
		(426, 'egypt/alexandria', 'Alexandria', 'Egypt'),
		(427, 'china/anshan', 'Anshan', 'China'),
		(428, 'chile/antofagasta', 'Antofagasta', 'Chile'),
		(429, 'brazil/anapolis', 'Anapolis', 'Brazil'),
		(430, 'brazil/aracaju', 'Aracaju', 'Brazil'),
		(431, 'peru/arequipa', 'Arequipa', 'Peru'),
		(432, 'chile/arica', 'Arica', 'Chile'),
		(433, 'argentina/bahia-blanca', 'Bahia Blanca', 'Argentina'),
		(434, 'indonesia/balikpapan', 'Balikpapan', 'Indonesia'),
		(435, 'australia/ballarat', 'Ballarat', 'Australia'),
		(436, 'indonesia/tanjungkarang', 'Tanjungkarang', 'Indonesia'),
		(437, 'indonesia/bandung', 'Bandung', 'Indonesia'),
		(438, 'india/bangalore', 'Bangalore', 'India'),
		(439, 'indonesia/banjarmasin', 'Banjarmasin', 'Indonesia'),
		(440, 'china/baotou', 'Baotou', 'China'),
		(441, 'venezuela/barquisimeto', 'Barquisimeto', 'Venezuela'),
		(442, 'colombia/barranquilla', 'Barranquilla', 'Colombia'),
		(443, 'brazil/barreiras', 'Barreiras', 'Brazil'),
		(444, 'brazil/bauru', 'Bauru', 'Brazil'),
		(445, 'brazil/belo-horizonte', 'Belo Horizonte', 'Brazil'),
		(446, 'brazil/belem', 'Belem', 'Brazil'),
		(447, 'australia/bendigo', 'Bendigo', 'Australia'),
		(448, 'usa/billings', 'Billings', 'United States'),
		(449, 'brazil/blumenau', 'Blumenau', 'Brazil'),
		(450, 'indonesia/bogor', 'Bogor', 'Indonesia'),
		(451, 'colombia/bucaramanga', 'Bucaramanga', 'Colombia'),
		(452, 'colombia/buenaventura', 'Buenaventura', 'Colombia'),
		(453, 'colombia/cali', 'Cali', 'Colombia'),
		(454, 'peru/callao', 'Callao', 'Peru'),
		(455, 'brazil/campina-grande', 'Campina Grande', 'Brazil'),
		(456, 'brazil/campinas', 'Campinas', 'Brazil'),
		(457, 'brazil/campo-grande', 'Campo Grande', 'Brazil'),
		(458, 'brazil/campos', 'Campos', 'Brazil'),
		(459, 'china/guangzhou', 'Guangzhou', 'China'),
		(460, 'colombia/cartagena', 'Cartagena', 'Colombia'),
		(461, 'brazil/caruaru', 'Caruaru', 'Brazil'),
		(462, 'argentina/catamarca', 'Catamarca', 'Argentina'),
		(463, 'brazil/caxias-do-sul', 'Caxias Do Sul', 'Brazil'),
		(464, 'china/changchun', 'Changchun', 'China'),
		(465, 'china/changsha', 'Changsha', 'China'),
		(466, 'china/chengdu', 'Chengdu', 'China'),
		(467, 'peru/chiclayo', 'Chiclayo', 'Peru'),
		(468, 'antarctica/south-pole', 'South Pole', 'Antarctica'),
		(469, 'bangladesh/chittagong', 'Chittagong', 'Bangladesh'),
		(470, 'china/chongqing', 'Chongqing', 'China'),
		(471, 'indonesia/cirebon', 'Cirebon', 'Indonesia'),
		(472, 'venezuela/ciudad-guayana', 'Ciudad Guayana', 'Venezuela'),
		(473, 'bolivia/cochabamba', 'Cochabamba', 'Bolivia'),
		(474, 'panama/colon', 'Colon', 'Panama'),
		(475, 'argentina/comodoro-rivadavia', 'Comodoro Rivadavia', 'Argentina'),
		(476, 'chile/concepcion', 'Concepcion', 'Chile'),
		(477, 'usa/corpus-christi', 'Corpus Christi', 'United States'),
		(478, 'argentina/corrientes', 'Corrientes', 'Argentina'),
		(479, 'brazil/cuiaba', 'Cuiaba', 'Brazil'),
		(480, 'venezuela/ciudad-ojeda', 'Ciudad Ojeda', 'Venezuela'),
		(481, 'mexico/culiacan', 'Culiacan', 'Mexico'),
		(482, 'venezuela/cumana', 'Cumana', 'Venezuela'),
		(483, 'brazil/curitiba', 'Curitiba', 'Brazil'),
		(484, 'peru/cuzco', 'Cuzco', 'Peru'),
		(485, 'argentina/cordoba', 'Cordoba', 'Argentina'),
		(486, 'colombia/cucuta', 'Cucuta', 'Colombia'),
		(487, 'syria/damascus', 'Damascus', 'Syria'),
		(488, 'brazil/feira-de-santana', 'Feira De Santana', 'Brazil'),
		(489, 'brazil/florianopolis', 'Florianopolis', 'Brazil'),
		(490, 'china/foochow', 'Foochow', 'China'),
		(491, 'brazil/fortaleza', 'Fortaleza', 'Brazil'),
		(492, 'japan/fukuoka', 'Fukuoka', 'Japan'),
		(493, 'china/fushun', 'Fushun', 'China'),
		(494, 'usa/galveston', 'Galveston', 'United States'),
		(495, 'brazil/garanhuns', 'Garanhuns', 'Brazil'),
		(496, 'poland/gdansk', 'Gdansk', 'Poland'),
		(497, 'brazil/goiania', 'Goiania', 'Brazil'),
		(498, 'brazil/governador-valadares', 'Governador Valadares', 'Brazil'),
		(499, 'china/guiyang', 'Guiyang', 'China'),
		(500, 'new-zealand/hamilton', 'Hamilton', 'New Zealand'),
		(501, 'china/hangzhou', 'Hangzhou', 'China'),
		(502, 'china/harbin', 'Harbin', 'China'),
		(503, 'mexico/hermosillo', 'Hermosillo', 'Mexico'),
		(504, 'peru/huancayo', 'Huancayo', 'Peru'),
		(505, 'india/hyderabad', 'Hyderabad', 'India'),
		(506, 'colombia/ibague', 'Ibague', 'Colombia'),
		(507, 'peru/ica', 'Ica', 'Peru'),
		(508, 'brazil/ilheus', 'Ilheus', 'Brazil'),
		(509, 'south-korea/incheon', 'Incheon', 'South Korea'),
		(510, 'new-zealand/invercargill', 'Invercargill', 'New Zealand'),
		(511, 'chile/iquique', 'Iquique', 'Chile'),
		(512, 'peru/iquitos', 'Iquitos', 'Peru'),
		(513, 'brazil/itabuna', 'Itabuna', 'Brazil'),
		(514, 'turkey/izmir', 'Izmir', 'Turkey'),
		(515, 'usa/jackson', 'Jackson', 'United States'),
		(516, 'india/jaipur', 'Jaipur', 'India'),
		(517, 'indonesia/jambi', 'Jambi', 'Indonesia'),
		(518, 'brazil/jequie', 'Jequie', 'Brazil'),
		(519, 'china/jilin', 'Jilin', 'China'),
		(520, 'china/jinan', 'Jinan', 'China'),
		(521, 'china/jinzhou', 'Jinzhou', 'China'),
		(522, 'brazil/joinville', 'Joinville', 'Brazil'),
		(523, 'brazil/joao-pessoa', 'Joao Pessoa', 'Brazil'),
		(524, 'brazil/juiz-de-fora', 'Juiz De Fora', 'Brazil'),
		(525, 'argentina/jujuy', 'Jujuy', 'Argentina'),
		(526, 'argentina/junin', 'Junin', 'Argentina'),
		(527, 'brazil/juazeiro-do-norte', 'Juazeiro Do Norte', 'Brazil'),
		(528, 'russia/kaliningrad', 'Kaliningrad', 'Russia'),
		(529, 'lithuania/kaunas', 'Kaunas', 'Lithuania'),
		(530, 'japan/kawasaki', 'Kawasaki', 'Japan'),
		(531, 'indonesia/kediri', 'Kediri', 'Indonesia'),
		(532, 'japan/kitakyushu', 'Kitakyushu', 'Japan'),
		(533, 'china/kowloon', 'Kowloon', 'Hong Kong'),
		(534, 'luxembourg/luxembourg', 'Luxembourg', 'Luxembourg'),
		(535, 'poland/krakow', 'Krakow', 'Poland'),
		(536, 'indonesia/kudus', 'Kudus', 'Indonesia'),
		(537, 'china/kunming', 'Kunming', 'China'),
		(538, 'japan/kyoto', 'Kyoto', 'Japan'),
		(539, 'india/kanpur', 'Kanpur', 'India'),
		(540, 'japan/kobe', 'Kobe', 'Japan'),
		(541, 'argentina/la-plata', 'La Plata', 'Argentina'),
		(542, 'china/lanchow', 'Lanchow', 'China'),
		(543, 'brazil/londrina', 'Londrina', 'Brazil'),
		(544, 'usa/lubbock', 'Lubbock', 'United States'),
		(545, 'india/lucknow', 'Lucknow', 'India'),
		(546, 'china/luoyang', 'Luoyang', 'China'),
		(547, 'nicaragua/leon', 'Leon', 'Nicaragua'),
		(548, 'poland/lodz', 'Lodz', 'Poland'),
		(549, 'china/luda', 'Luda', 'China'),
		(550, 'brazil/macapa', 'Macapa', 'Brazil'),
		(551, 'brazil/maceio', 'Maceio', 'Brazil'),
		(552, 'indonesia/madiun', 'Madiun', 'Indonesia'),
		(553, 'india/chennai', 'Chennai', 'India'),
		(554, 'indonesia/malang', 'Malang', 'Indonesia'),
		(555, 'indonesia/manado', 'Manado', 'Indonesia'),
		(556, 'brazil/porto-velho', 'Porto Velho', 'Brazil'),
		(557, 'colombia/manizales', 'Manizales', 'Colombia'),
		(558, 'argentina/mar-del-plata', 'Mar Del Plata', 'Argentina'),
		(559, 'venezuela/maracaibo', 'Maracaibo', 'Venezuela'),
		(560, 'venezuela/maracay', 'Maracay', 'Venezuela'),
		(561, 'indonesia/medan', 'Medan', 'Indonesia'),
		(562, 'argentina/mendoza', 'Mendoza', 'Argentina'),
		(563, 'brazil/montes-claros', 'Montes Claros', 'Brazil'),
		(564, 'brazil/mossoro', 'Mossoro', 'Brazil'),
		(565, 'japan/nagoya', 'Nagoya', 'Japan'),
		(566, 'china/nanchang', 'Nanchang', 'China'),
		(567, 'new-zealand/napier', 'Napier', 'New Zealand'),
		(568, 'brazil/natal', 'Natal', 'Brazil'),
		(569, 'australia/newcastle', 'Newcastle', 'Australia'),
		(570, 'brazil/niteroi', 'Niteroi', 'Brazil'),
		(571, 'india/nagpur', 'Nagpur', 'India'),
		(572, 'bolivia/oruro', 'Oruro', 'Bolivia'),
		(573, 'chile/osorno', 'Osorno', 'Chile'),
		(574, 'chile/punta-arenas', 'Punta Arenas', 'Chile'),
		(575, 'indonesia/padang', 'Padang', 'Indonesia'),
		(576, 'indonesia/palembang', 'Palembang', 'Indonesia'),
		(577, 'argentina/parana', 'Parana', 'Argentina'),
		(578, 'brazil/parnaiba', 'Parnaiba', 'Brazil'),
		(579, 'brazil/passo-fundo', 'Passo Fundo', 'Brazil'),
		(580, 'colombia/pasto', 'Pasto', 'Colombia'),
		(581, 'uruguay/paysandu', 'Paysandu', 'Uruguay'),
		(582, 'indonesia/pekalongan', 'Pekalongan', 'Indonesia'),
		(583, 'indonesia/pekanbaru', 'Pekanbaru', 'Indonesia'),
		(584, 'brazil/pelotas', 'Pelotas', 'Brazil'),
		(585, 'indonesia/pematangsiantar', 'Pematangsiantar', 'Indonesia'),
		(586, 'peru/piura', 'Piura', 'Peru'),
		(587, 'brazil/ponta-grossa', 'Ponta Grossa', 'Brazil'),
		(588, 'trinidad-and-tobago/port-of-spain', 'Port Of Spain', 'Trinidad and Tobago'),
		(589, 'argentina/posadas', 'Posadas', 'Argentina'),
		(590, 'bolivia/potosi', 'Potosi', 'Bolivia'),
		(591, 'poland/poznan', 'Poznan', 'Poland'),
		(592, 'mexico/puebla', 'Puebla', 'Mexico'),
		(593, 'chile/puerto-montt', 'Puerto Montt', 'Chile'),
		(594, 'south-korea/busan', 'Busan', 'South Korea'),
		(595, 'brazil/porto-alegre', 'Porto Alegre', 'Brazil'),
		(596, 'guatemala/quetzaltenango', 'Quetzaltenango', 'Guatemala'),
		(597, 'china/qiqihar', 'Qiqihar', 'China'),
		(598, 'chile/rancagua', 'Rancagua', 'Chile'),
		(599, 'usa/reno', 'Reno', 'United States'),
		(600, 'argentina/resistencia', 'Resistencia', 'Argentina'),
		(601, 'brazil/ribeirao-preto', 'Ribeirao Preto', 'Brazil'),
		(602, 'latvia/riga', 'Riga', 'Latvia'),
		(603, 'argentina/rio-gallegos', 'Rio Gallegos', 'Argentina'),
		(604, 'brazil/rio-grande', 'Rio Grande', 'Brazil'),
		(605, 'usa/st-louis', 'St Louis', 'United States'),
		(606, 'argentina/salta', 'Salta', 'Argentina'),
		(607, 'mexico/saltillo', 'Saltillo', 'Mexico'),
		(608, 'uruguay/salto', 'Salto', 'Uruguay'),
		(609, 'brazil/salvador2', 'Salvador2', 'Brazil'),
		(610, 'indonesia/samarinda', 'Samarinda', 'Indonesia'),
		(611, 'usa/san-bernardino', 'San Bernardino', 'United States'),
		(612, 'venezuela/san-cristobal', 'San Cristobal', 'Venezuela'),
		(613, 'argentina/san-luis', 'San Luis', 'Argentina'),
		(614, 'honduras/san-pedro-sula', 'San Pedro Sula', 'Honduras'),
		(615, 'bolivia/santa-cruz', 'Santa Cruz', 'Bolivia'),
		(616, 'argentina/santa-fe', 'Santa Fe', 'Argentina'),
		(617, 'brazil/santa-maria', 'Santa Maria', 'Brazil'),
		(618, 'colombia/santa-marta', 'Santa Marta', 'Colombia'),
		(619, 'cuba/santiago-de-cuba', 'Santiago De Cuba', 'Cuba'),
		(620, 'argentina/santiago-del-estero', 'Santiago Del Estero', 'Argentina'),
		(621, 'brazil/santos', 'Santos', 'Brazil'),
		(622, 'japan/sapporo', 'Sapporo', 'Japan'),
		(623, 'usa/savannah', 'Savannah', 'United States'),
		(624, 'indonesia/semarang', 'Semarang', 'Indonesia'),
		(625, 'china/shijiazhuang', 'Shijiazhuang', 'China'),
		(626, 'china/sian', 'Sian', 'China'),
		(627, 'usa/sioux-falls', 'Sioux Falls', 'United States'),
		(628, 'brazil/sobral', 'Sobral', 'Brazil'),
		(629, 'brazil/sorocaba', 'Sorocaba', 'Brazil'),
		(630, 'falkland/stanley', 'Stanley', 'Falkland Islands'),
		(631, 'indonesia/surabaya', 'Surabaya', 'Indonesia'),
		(632, 'indonesia/surakarta', 'Surakarta', 'Indonesia'),
		(633, 'poland/szczecin', 'Szczecin', 'Poland'),
		(634, 'brazil/sao-jose-do-rio-preto', 'Sao Jose Do Rio Preto', 'Brazil'),
		(635, 'brazil/sao-luis', 'Sao Luis', 'Brazil'),
		(636, 'south-korea/daegu', 'Daegu', 'South Korea'),
		(637, 'china/taiyuan', 'Taiyuan', 'China'),
		(638, 'chile/talca', 'Talca', 'Chile'),
		(639, 'chile/talcahuano', 'Talcahuano', 'Chile'),
		(640, 'china/tangshan', 'Tangshan', 'China'),
		(641, 'indonesia/tasikmalaya', 'Tasikmalaya', 'Indonesia'),
		(642, 'indonesia/tegal', 'Tegal', 'Indonesia'),
		(643, 'chile/temuco', 'Temuco', 'Chile'),
		(644, 'brazil/teresina', 'Teresina', 'Brazil'),
		(645, 'brazil/teofilo-otoni', 'Teofilo Otoni', 'Brazil'),
		(646, 'china/tianjin', 'Tianjin', 'China'),
		(647, 'mexico/torreon', 'Torreon', 'Mexico'),
		(648, 'peru/trujillo', 'Trujillo', 'Peru'),
		(649, 'china/tsingtao', 'Tsingtao', 'China'),
		(650, 'argentina/tucuman', 'Tucuman', 'Argentina'),
		(651, 'brazil/uberaba', 'Uberaba', 'Brazil'),
		(652, 'brazil/uberlandia', 'Uberlandia', 'Brazil'),
		(653, 'indonesia/makassar', 'Makassar', 'Indonesia'),
		(654, 'brazil/uruguaiana', 'Uruguaiana', 'Brazil'),
		(655, 'china/urumqi', 'Urumqi', 'China'),
		(656, 'argentina/ushuaia', 'Ushuaia', 'Argentina'),
		(657, 'chile/valdivia', 'Valdivia', 'Chile'),
		(658, 'venezuela/valencia', 'Valencia', 'Venezuela'),
		(659, 'chile/valparaiso', 'Valparaiso', 'Chile'),
		(660, 'lithuania/vilnius', 'Vilnius', 'Lithuania'),
		(661, 'brazil/vitoria-da-conquista', 'Vitoria Da Conquista', 'Brazil'),
		(662, 'chile/vina-del-mar', 'Vina Del Mar', 'Chile'),
		(663, 'brazil/volta-redonda', 'Volta Redonda', 'Brazil'),
		(664, 'poland/wroclaw', 'Wroclaw', 'Poland'),
		(665, 'china/wuhan', 'Wuhan', 'China'),
		(666, 'indonesia/yogyakarta', 'Yogyakarta', 'Indonesia'),
		(667, 'japan/yokohama', 'Yokohama', 'Japan'),
		(668, 'china/zhengzhou', 'Zhengzhou', 'China'),
		(669, 'china/zibo', 'Zibo', 'China'),
		(670, 'argentina/zarate', 'Zarate', 'Argentina'),
		(671, 'japan/osaka', 'Osaka', 'Japan'),
		(672, 'yemen/sana', 'Sana', 'Yemen'),
		(673, 'republic-of-macedonia/skopje', 'Skopje', 'Macedonia'),
		(674, 'monaco/monaco', 'Monaco', 'Monaco'),
		(675, 'kiribati/tarawa', 'Tarawa', 'Kiribati'),
		(676, 'israel/tel-aviv', 'Tel Aviv', 'Israel'),
		(677, 'canada/iqaluit', 'Iqaluit', 'Canada'),
		(678, 'canada/yellowknife', 'Yellowknife', 'Canada'),
		(679, 'canada/whitehorse', 'Whitehorse', 'Canada'),
		(680, 'cyprus/nicosia', 'Nicosia', 'Cyprus'),
		(681, 'spain/la-coruna', 'La Coruna', 'Spain'),
		(682, 'portugal/funchal', 'Funchal', 'Portugal'),
		(683, 'spain/santa-cruz', 'Santa Cruz', 'Spain'),
		(684, 'spain/las-palmas', 'Las Palmas', 'Spain'),
		(685, 'cape-verde/praia', 'Praia', 'Cape Verde'),
		(686, 'andorra/andorra-la-vella', 'Andorra La Vella', 'Andorra'),
		(687, 'anguilla/the-valley', 'The Valley', 'Anguilla'),
		(688, 'antigua-and-barbuda/saint-johns', 'Saint Johns', 'Antigua and Barbuda'),
		(689, 'netherlands/oranjestad', 'Oranjestad', 'Aruba'),
		(690, 'bhutan/thimphu', 'Thimphu', 'Bhutan'),
		(691, 'bosnia-herzegovina/sarajevo', 'Sarajevo', 'Bosnia and Herzegovina'),
		(692, 'uk/road-town', 'Road Town', 'British Virgin Islands'),
		(693, 'brunei/bandar-seri-begawan', 'Bandar Seri Begawan', 'Brunei'),
		(694, 'central-african-republic/bangui', 'Bangui', 'Central African Republic'),
		(695, 'australia/the-settlement', 'The Settlement', 'Australia'),
		(696, 'comoros/moroni', 'Moroni', 'Comoros'),
		(697, 'djibouti/djibouti', 'Djibouti', 'Djibouti'),
		(698, 'dominica/roseau', 'Roseau', 'Dominica'),
		(699, 'equatorial-guinea/malabo', 'Malabo', 'Equatorial Guinea'),
		(700, 'eritrea/asmara', 'Asmara', 'Eritrea'),
		(701, 'faroe/torshavn', 'Torshavn', 'Faroe Islands'),
		(702, 'gaza-strip/gaza', 'Gaza', 'Gaza Strip'),
		(703, 'greenland/nuuk', 'Nuuk', 'Greenland'),
		(704, 'greenland/qaanaaq', 'Qaanaaq', 'Greenland'),
		(705, 'greenland/ittoqqortoormiit', 'Ittoqqortoormiit', 'Greenland'),
		(706, 'grenada/saint-georges', 'Saint Georges', 'Grenada'),
		(707, 'guadeloupe/basse-terre', 'Basse Terre', 'Guadeloupe'),
		(708, 'uk/st-peter-port', 'St Peter Port', 'United Kingdom'),
		(709, 'haiti/port-au-prince', 'Port Au Prince', 'Haiti'),
		(710, 'vatican-city-state/vatican-city', 'Vatican City', 'Holy See (Vatican City)'),
		(711, 'norway/jan-mayen', 'Jan Mayen', 'Norway'),
		(712, 'uk/saint-helier', 'Saint Helier', 'United Kingdom'),
		(713, 'kiribati/rawaki', 'Rawaki', 'Kiribati'),
		(714, 'liechtenstein/vaduz', 'Vaduz', 'Liechtenstein'),
		(715, 'maldives/male', 'Male', 'Maldives'),
		(716, 'isle-of-man/douglas', 'Douglas', 'Isle of Man'),
		(717, 'marshall-islands/majuro', 'Majuro', 'Marshall Islands'),
		(718, 'martinique/fort-de-france', 'Fort De France', 'Martinique'),
		(719, 'mayotte/mamoutzou', 'Mamoutzou', 'Mayotte'),
		(720, 'mongolia/ulaanbaatar', 'Ulaanbaatar', 'Mongolia'),
		(721, 'montserrat/brades', 'Brades', 'Montserrat'),
		(722, 'curacao/willemstad', 'Willemstad', 'Curaçao'),
		(723, 'france/noumea', 'Noumea', 'France'),
		(724, 'niue/alofi', 'Alofi', 'Niue'),
		(725, 'norfolk-island/kingston', 'Kingston', 'Norfolk Island'),
		(726, 'palau/koror', 'Koror', 'Palau'),
		(727, 'uk/jamestown', 'Jamestown', 'Saint Helena'),
		(728, 'saint-kitts-and-nevis/basseterre', 'Basseterre', 'Saint Kitts and Nevis'),
		(729, 'saint-lucia/castries', 'Castries', 'Saint Lucia'),
		(730, 'st-pierre-miquelon/saint-pierre', 'Saint Pierre', 'Saint Pierre and Miquelon'),
		(731, 'saint-vincent-and-grenadines/kingstown', 'Kingstown', 'Saint Vincent and the Grenadines'),
		(732, 'san-marino/san-marino', 'San Marino', 'San Marino'),
		(733, 'sao-tome-and-principe/sao-tome', 'Sao Tome', 'Sao Tome and Principe'),
		(734, 'seychelles/victoria', 'Victoria', 'Seychelles'),
		(735, 'slovakia/bratislava', 'Bratislava', 'Slovakia'),
		(736, 'slovenia/ljubljana', 'Ljubljana', 'Slovenia'),
		(737, 'norway/longyearbyen', 'Longyearbyen', 'Norway'),
		(738, 'tokelau/fakaofo', 'Fakaofo', 'Tokelau'),
		(739, 'turks-caicos/cockburn-town', 'Cockburn Town', 'Turks and Caicos Islands'),
		(740, 'france/mata-utu', 'Mata Utu', 'Wallis and Futuna'),
		(741, 'western-sahara/el-aaiun', 'El Aaiun', 'Western Sahara'),
		(742, 'nigeria/abuja', 'Abuja', 'Nigeria'),
		(743, 'kosovo/pristina', 'Pristina', 'Kosovo'),
		(744, 'montenegro/podgorica', 'Podgorica', 'Montenegro'),
		(745, 'usa/asheville', 'Asheville', 'United States'),
		(746, 'usa/durham', 'Durham', 'United States'),
		(747, 'usa/greensboro', 'Greensboro', 'United States'),
		(748, 'saudi-arabia/jeddah', 'Jeddah', 'Saudi Arabia'),
		(749, 'canada/saint-john', 'Saint John', 'Canada'),
		(750, 'australia/lord-howe-island', 'Lord Howe Island', 'Australia'),
		(751, 'brazil/fernando-de-noronha', 'Fernando De Noronha', 'Brazil'),
		(752, 'brazil/rio-branco', 'Rio Branco', 'Brazil'),
		(753, 'canada/charlottetown', 'Charlottetown', 'Canada'),
		(754, 'macau/macau', 'Macau', 'Macau'),
		(755, 'pitcairn/adamstown', 'Adamstown', 'Pitcairn Islands'),
		(756, 'pakistan/lahore', 'Lahore', 'Pakistan'),
		(757, 'pakistan/karachi', 'Karachi', 'Pakistan'),
		(758, 'pakistan/faisalabad', 'Faisalabad', 'Pakistan'),
		(759, 'indonesia/jayapura', 'Jayapura', 'Indonesia'),
		(760, 'indonesia/singaraja', 'Singaraja', 'Indonesia'),
		(761, 'indonesia/denpasar', 'Denpasar', 'Indonesia'),
		(762, 'indonesia/kupang', 'Kupang', 'Indonesia'),
		(763, 'indonesia/raba', 'Raba', 'Indonesia'),
		(764, 'indonesia/ende', 'Ende', 'Indonesia'),
		(765, 'indonesia/mataram', 'Mataram', 'Indonesia'),
		(766, 'indonesia/ambon', 'Ambon', 'Indonesia'),
		(767, 'indonesia/ternate', 'Ternate', 'Indonesia'),
		(768, 'timor-leste/dili', 'Dili', 'East Timor'),
		(769, 'uk/greenwich-city', 'Greenwich City', 'United Kingdom'),
		(770, 'usa/san-diego', 'San Diego', 'United States'),
		(771, 'india/delhi', 'Delhi', 'India'),
		(772, 'greece/rhodes', 'Rhodes', 'Greece'),
		(773, 'greece/khania', 'Khania', 'Greece'),
		(774, 'greece/iraklion', 'Iraklion', 'Greece'),
		(775, 'japan/naha', 'Naha', 'Japan'),
		(776, 'united-arab-emirates/dubai', 'Dubai', 'United Arab Emirates'),
		(777, 'usa/syracuse', 'Syracuse', 'United States'),
		(778, 'usa/cheyenne', 'Cheyenne', 'United States'),
		(779, 'usa/abilene', 'Abilene', 'United States'),
		(780, 'usa/alexandria', 'Alexandria', 'United States'),
		(781, 'usa/allentown', 'Allentown', 'United States'),
		(782, 'usa/amarillo', 'Amarillo', 'United States'),
		(783, 'usa/anaheim', 'Anaheim', 'United States'),
		(784, 'usa/ann-arbor', 'Ann Arbor', 'United States'),
		(785, 'usa/arden-arcade', 'Arden Arcade', 'United States'),
		(786, 'usa/arlington', 'Arlington', 'United States'),
		(787, 'usa/aurora-co', 'Aurora Co', 'United States'),
		(788, 'usa/aurora-il', 'Aurora Il', 'United States'),
		(789, 'usa/bakersfield', 'Bakersfield', 'United States'),
		(790, 'usa/beaumont', 'Beaumont', 'United States'),
		(791, 'usa/berkeley', 'Berkeley', 'United States'),
		(792, 'usa/sunrise-manor', 'Sunrise Manor', 'United States'),
		(793, 'usa/bridgeport', 'Bridgeport', 'United States'),
		(794, 'usa/brockton', 'Brockton', 'United States'),
		(795, 'usa/brownsville', 'Brownsville', 'United States'),
		(796, 'usa/burbank', 'Burbank', 'United States'),
		(797, 'usa/cambridge', 'Cambridge', 'United States'),
		(798, 'usa/cedar-rapids', 'Cedar Rapids', 'United States'),
		(799, 'usa/chandler', 'Chandler', 'United States'),
		(800, 'usa/chattanooga', 'Chattanooga', 'United States'),
		(801, 'usa/chesapeake', 'Chesapeake', 'United States'),
		(802, 'usa/chula-vista', 'Chula Vista', 'United States'),
		(803, 'usa/citrus-heights', 'Citrus Heights', 'United States'),
		(804, 'usa/clearwater', 'Clearwater', 'United States'),
		(805, 'usa/columbus', 'Columbus', 'United States'),
		(806, 'usa/compton', 'Compton', 'United States'),
		(807, 'usa/costa-mesa', 'Costa Mesa', 'United States'),
		(808, 'usa/daly-city', 'Daly City', 'United States'),
		(809, 'usa/davenport', 'Davenport', 'United States'),
		(810, 'usa/dayton', 'Dayton', 'United States'),
		(811, 'usa/downey', 'Downey', 'United States'),
		(812, 'usa/el-monte', 'El Monte', 'United States'),
		(813, 'usa/elizabeth', 'Elizabeth', 'United States'),
		(814, 'usa/erie', 'Erie', 'United States'),
		(815, 'usa/escondido', 'Escondido', 'United States'),
		(816, 'usa/eugene', 'Eugene', 'United States'),
		(817, 'usa/evansville', 'Evansville', 'United States'),
		(818, 'usa/fall-river', 'Fall River', 'United States'),
		(819, 'usa/flint', 'Flint', 'United States'),
		(820, 'usa/fort-lauderdale', 'Fort Lauderdale', 'United States'),
		(821, 'usa/fort-wayne', 'Fort Wayne', 'United States'),
		(822, 'usa/fremont', 'Fremont', 'United States'),
		(823, 'usa/fullerton', 'Fullerton', 'United States'),
		(824, 'usa/garden-grove', 'Garden Grove', 'United States'),
		(825, 'usa/garland', 'Garland', 'United States'),
		(826, 'usa/gary', 'Gary', 'United States'),
		(827, 'usa/glendale-az', 'Glendale Az', 'United States'),
		(828, 'usa/glendale-ca', 'Glendale Ca', 'United States'),
		(829, 'usa/grand-prairie', 'Grand Prairie', 'United States'),
		(830, 'usa/grand-rapids', 'Grand Rapids', 'United States'),
		(831, 'usa/green-bay', 'Green Bay', 'United States'),
		(832, 'usa/hampton', 'Hampton', 'United States'),
		(833, 'usa/hayward', 'Hayward', 'United States'),
		(834, 'usa/hialeah', 'Hialeah', 'United States'),
		(835, 'usa/hollywood-city', 'Hollywood City', 'United States'),
		(836, 'usa/huntington-beach', 'Huntington Beach', 'United States'),
		(837, 'usa/huntsville', 'Huntsville', 'United States'),
		(838, 'usa/independence', 'Independence', 'United States'),
		(839, 'usa/inglewood', 'Inglewood', 'United States'),
		(840, 'usa/irvine', 'Irvine', 'United States'),
		(841, 'usa/irving', 'Irving', 'United States'),
		(842, 'usa/jersey-city', 'Jersey City', 'United States'),
		(843, 'usa/knoxville', 'Knoxville', 'United States'),
		(844, 'usa/lafayette', 'Lafayette', 'United States'),
		(845, 'usa/lakewood', 'Lakewood', 'United States'),
		(846, 'usa/lancaster', 'Lancaster', 'United States'),
		(847, 'usa/laredo', 'Laredo', 'United States'),
		(848, 'usa/lexington-fayette', 'Lexington Fayette', 'United States'),
		(849, 'usa/livonia', 'Livonia', 'United States'),
		(850, 'usa/long-beach', 'Long Beach', 'United States'),
		(851, 'usa/lowell', 'Lowell', 'United States'),
		(852, 'usa/macon', 'Macon', 'United States'),
		(853, 'usa/mesa', 'Mesa', 'United States'),
		(854, 'usa/mesquite', 'Mesquite', 'United States'),
		(855, 'usa/metairie', 'Metairie', 'United States'),
		(856, 'usa/tallahassee', 'Tallahassee', 'United States'),
		(857, 'usa/modesto', 'Modesto', 'United States'),
		(858, 'usa/moreno-valley', 'Moreno Valley', 'United States'),
		(859, 'usa/new-bedford', 'New Bedford', 'United States'),
		(860, 'usa/new-haven', 'New Haven', 'United States'),
		(861, 'usa/newark', 'Newark', 'United States'),
		(862, 'usa/newport-news', 'Newport News', 'United States'),
		(863, 'usa/norwalk', 'Norwalk', 'United States'),
		(864, 'usa/oceanside', 'Oceanside', 'United States'),
		(865, 'usa/ontario', 'Ontario', 'United States'),
		(866, 'usa/orange', 'Orange', 'United States'),
		(867, 'usa/orlando', 'Orlando', 'United States'),
		(868, 'usa/overland-park', 'Overland Park', 'United States'),
		(869, 'usa/oxnard', 'Oxnard', 'United States'),
		(870, 'usa/paradise', 'Paradise', 'United States'),
		(871, 'usa/pasadena-ca', 'Pasadena Ca', 'United States'),
		(872, 'usa/pasadena-tx', 'Pasadena Tx', 'United States'),
		(873, 'usa/paterson', 'Paterson', 'United States'),
		(874, 'usa/peoria', 'Peoria', 'United States'),
		(875, 'usa/plano', 'Plano', 'United States'),
		(876, 'usa/pomona', 'Pomona', 'United States'),
		(877, 'usa/portsmouth', 'Portsmouth', 'United States'),
		(878, 'usa/providence', 'Providence', 'United States'),
		(879, 'usa/rancho-cucamonga', 'Rancho Cucamonga', 'United States'),
		(880, 'usa/riverside', 'Riverside', 'United States'),
		(881, 'usa/roanoke', 'Roanoke', 'United States'),
		(882, 'usa/rockford', 'Rockford', 'United States'),
		(883, 'usa/salinas', 'Salinas', 'United States'),
		(884, 'usa/tempe', 'Tempe', 'United States'),
		(885, 'usa/san-buenaventura', 'San Buenaventura', 'United States'),
		(886, 'usa/santa-clara', 'Santa Clara', 'United States'),
		(887, 'usa/santa-clarita', 'Santa Clarita', 'United States'),
		(888, 'usa/santa-rosa', 'Santa Rosa', 'United States'),
		(889, 'usa/scottsdale', 'Scottsdale', 'United States'),
		(890, 'usa/shreveport', 'Shreveport', 'United States'),
		(891, 'usa/simi-valley', 'Simi Valley', 'United States'),
		(892, 'usa/south-bend', 'South Bend', 'United States'),
		(893, 'usa/springfield-il', 'Springfield Il', 'United States'),
		(894, 'usa/springfield-ma', 'Springfield Ma', 'United States'),
		(895, 'usa/springfield-mo', 'Springfield Mo', 'United States'),
		(896, 'usa/st-petersburg', 'St Petersburg', 'United States'),
		(897, 'usa/stamford', 'Stamford', 'United States'),
		(898, 'usa/sterling-heights', 'Sterling Heights', 'United States'),
		(899, 'usa/stockton', 'Stockton', 'United States'),
		(900, 'usa/sunnyvale', 'Sunnyvale', 'United States'),
		(901, 'usa/thousand-oaks', 'Thousand Oaks', 'United States'),
		(902, 'usa/torrance', 'Torrance', 'United States'),
		(903, 'usa/vallejo', 'Vallejo', 'United States'),
		(904, 'usa/virginia-beach', 'Virginia Beach', 'United States'),
		(905, 'usa/waco', 'Waco', 'United States'),
		(906, 'usa/warren', 'Warren', 'United States'),
		(907, 'usa/waterbury', 'Waterbury', 'United States'),
		(908, 'usa/west-covina', 'West Covina', 'United States'),
		(909, 'usa/wichita-falls', 'Wichita Falls', 'United States'),
		(910, 'usa/winston-salem', 'Winston Salem', 'United States'),
		(911, 'usa/worcester', 'Worcester', 'United States'),
		(912, 'usa/yonkers', 'Yonkers', 'United States'),
		(913, 'usa/youngstown', 'Youngstown', 'United States'),
		(914, 'chile/easter-island', 'Easter Island', 'Chile'),
		(915, 'ecuador/galapagos-islands', 'Galapagos Islands', 'Ecuador'),
		(916, 'kazakstan/aqtobe', 'Aqtobe', 'Kazakhstan'),
		(917, 'kazakstan/aktau', 'Aktau', 'Kazakhstan'),
		(918, 'china/lhasa', 'Lhasa', 'China'),
		(919, 'uk/belfast', 'Belfast', 'United Kingdom'),
		(920, 'usa/hollywood', 'Hollywood', 'United States'),
		(921, 'kazakstan/astana', 'Astana', 'Kazakhstan'),
		(922, 'mexico/campeche', 'Campeche', 'Mexico'),
		(923, 'mexico/cancun', 'Cancun', 'Mexico'),
		(924, 'mexico/villahermosa', 'Villahermosa', 'Mexico'),
		(925, 'india/vadodara', 'Vadodara', 'India'),
		(926, 'congo/brazzaville', 'Brazzaville', 'Congo'),
		(927, 'australia/cairns', 'Cairns', 'Australia'),
		(928, 'australia/uluru', 'Uluru', 'Australia'),
		(929, 'australia/alice-springs', 'Alice Springs', 'Australia'),
		(930, 'india/bhopal', 'Bhopal', 'India'),
		(931, 'usa/unalaska', 'Unalaska', 'United States'),
		(932, 'biot/diego-garcia', 'Diego Garcia', 'British Indian Ocean Territory'),
		(933, 'us-virgin/charlotte-amalie', 'Charlotte Amalie', 'US Virgin Islands'),
		(934, 'usa/saipan', 'Saipan', 'Northern Mariana Islands'),
		(935, 'cote-divoire/yamoussoukro', 'Yamoussoukro', 'Cote d''Ivoire'),
		(936, 'bangladesh/sylhet', 'Sylhet', 'Bangladesh'),
		(937, 'india/shillong', 'Shillong', 'India'),
		(938, 'bangladesh/mymensingh', 'Mymensingh', 'Bangladesh'),
		(939, 'bangladesh/saidpur', 'Saidpur', 'Bangladesh'),
		(940, 'bangladesh/pabna', 'Pabna', 'Bangladesh'),
		(941, 'bangladesh/jessore', 'Jessore', 'Bangladesh'),
		(942, 'bangladesh/barisal', 'Barisal', 'Bangladesh'),
		(943, 'bangladesh/khulna', 'Khulna', 'Bangladesh'),
		(944, 'usa/pensacola', 'Pensacola', 'United States'),
		(945, 'switzerland/lausanne', 'Lausanne', 'Switzerland'),
		(946, 'brazil/vitoria', 'Vitoria', 'Brazil'),
		(947, 'brazil/boa-vista', 'Boa Vista', 'Brazil'),
		(948, 'bangladesh/comilla', 'Comilla', 'Bangladesh'),
		(949, 'moldova/tiraspol', 'Tiraspol', 'Moldova'),
		(950, 'mongolia/hovd', 'Hovd', 'Mongolia'),
		(951, 'new-zealand/christchurch', 'Christchurch', 'New Zealand'),
		(952, 'new-zealand/dunedin', 'Dunedin', 'New Zealand'),
		(953, 'australia/wollongong', 'Wollongong', 'Australia'),
		(954, 'australia/townsville', 'Townsville', 'Australia'),
		(955, 'australia/toowoomba', 'Toowoomba', 'Australia'),
		(956, 'australia/launceston', 'Launceston', 'Australia'),
		(957, 'germany/duisburg', 'Duisburg', 'Germany'),
		(958, 'germany/bochum', 'Bochum', 'Germany'),
		(959, 'germany/wuppertal', 'Wuppertal', 'Germany'),
		(960, 'germany/bielefeld', 'Bielefeld', 'Germany'),
		(961, 'germany/mannheim', 'Mannheim', 'Germany'),
		(962, 'germany/mulheim', 'Mulheim', 'Germany'),
		(963, 'germany/gelsenkirchen', 'Gelsenkirchen', 'Germany'),
		(964, 'germany/karlsruhe', 'Karlsruhe', 'Germany'),
		(965, 'germany/halle', 'Halle', 'Germany'),
		(966, 'germany/wiesbaden', 'Wiesbaden', 'Germany'),
		(967, 'germany/monchengladbach', 'Monchengladbach', 'Germany'),
		(968, 'germany/munster', 'Munster', 'Germany'),
		(969, 'germany/chemnitz', 'Chemnitz', 'Germany'),
		(970, 'germany/augsburg', 'Augsburg', 'Germany'),
		(971, 'germany/braunschweig', 'Braunschweig', 'Germany'),
		(972, 'germany/aachen', 'Aachen', 'Germany'),
		(973, 'germany/krefeld', 'Krefeld', 'Germany'),
		(974, 'germany/magdeburg', 'Magdeburg', 'Germany'),
		(975, 'germany/oberhausen', 'Oberhausen', 'Germany'),
		(976, 'germany/lubeck', 'Lubeck', 'Germany'),
		(977, 'germany/rostock', 'Rostock', 'Germany'),
		(978, 'germany/hagen', 'Hagen', 'Germany'),
		(979, 'germany/erfurt', 'Erfurt', 'Germany'),
		(980, 'germany/freiburg', 'Freiburg', 'Germany'),
		(981, 'germany/kassel', 'Kassel', 'Germany'),
		(982, 'germany/saarbrucken', 'Saarbrucken', 'Germany'),
		(983, 'germany/mainz', 'Mainz', 'Germany'),
		(984, 'germany/hamm', 'Hamm', 'Germany'),
		(985, 'germany/osnabruck', 'Osnabruck', 'Germany'),
		(986, 'germany/ludwigshafen', 'Ludwigshafen', 'Germany'),
		(987, 'germany/solingen', 'Solingen', 'Germany'),
		(988, 'germany/leverkusen', 'Leverkusen', 'Germany'),
		(989, 'germany/oldenburg', 'Oldenburg', 'Germany'),
		(990, 'germany/neuss', 'Neuss', 'Germany'),
		(991, 'germany/heidelberg', 'Heidelberg', 'Germany'),
		(992, 'germany/darmstadt', 'Darmstadt', 'Germany'),
		(993, 'germany/potsdam', 'Potsdam', 'Germany'),
		(994, 'germany/paderborn', 'Paderborn', 'Germany'),
		(995, 'germany/gottingen', 'Gottingen', 'Germany'),
		(996, 'germany/bremerhaven', 'Bremerhaven', 'Germany'),
		(997, 'germany/wurzburg', 'Wurzburg', 'Germany'),
		(998, 'germany/recklinghausen', 'Recklinghausen', 'Germany'),
		(999, 'germany/regensburg', 'Regensburg', 'Germany'),
		(1000, 'germany/wolfsburg', 'Wolfsburg', 'Germany'),
		(1001, 'germany/bottrop', 'Bottrop', 'Germany'),
		(1002, 'germany/heilbronn', 'Heilbronn', 'Germany'),
		(1003, 'germany/remscheid', 'Remscheid', 'Germany'),
		(1004, 'germany/gera', 'Gera', 'Germany'),
		(1005, 'germany/cottbus', 'Cottbus', 'Germany'),
		(1006, 'germany/pforzheim', 'Pforzheim', 'Germany')";
		$sql3 = "INSERT INTO `".$wpdb->prefix."location` (`id`, `name`, `time_code`, `title`) VALUES
		(1007, 'germany/offenbach', 'Offenbach', 'Germany'),
		(1008, 'germany/ulm', 'Ulm', 'Germany'),
		(1009, 'germany/salzgitter', 'Salzgitter', 'Germany'),
		(1010, 'germany/ingolstadt', 'Ingolstadt', 'Germany'),
		(1011, 'germany/schwerin', 'Schwerin', 'Germany'),
		(1012, 'germany/siegen', 'Siegen', 'Germany'),
		(1013, 'germany/reutlingen', 'Reutlingen', 'Germany'),
		(1014, 'germany/furth', 'Furth', 'Germany'),
		(1015, 'germany/koblenz', 'Koblenz', 'Germany'),
		(1016, 'germany/moers', 'Moers', 'Germany'),
		(1017, 'germany/bergisch-gladbach', 'Bergisch Gladbach', 'Germany'),
		(1018, 'germany/hildesheim', 'Hildesheim', 'Germany'),
		(1019, 'germany/witten', 'Witten', 'Germany'),
		(1020, 'germany/kaiserslautern', 'Kaiserslautern', 'Germany'),
		(1021, 'germany/zwickau', 'Zwickau', 'Germany'),
		(1022, 'germany/erlangen', 'Erlangen', 'Germany'),
		(1023, 'germany/herne', 'Herne', 'Germany'),
		(1024, 'france/bastia', 'Bastia', 'France'),
		(1025, 'france/ajaccio', 'Ajaccio', 'France'),
		(1026, 'mongolia/choibalsan', 'Choibalsan', 'Mongolia'),
		(1027, 'france/taiohae', 'Taiohae', 'France'),
		(1028, 'french-polynesia/gambier-islands', 'Gambier Islands', 'French Polynesia'),
		(1029, 'usa/dover', 'Dover', 'United States'),
		(1030, 'tanzania/dodoma', 'Dodoma', 'Tanzania'),
		(1031, 'antarctica/mawson', 'Mawson', 'Antarctica'),
		(1032, 'antarctica/mcmurdo', 'Mcmurdo', 'Antarctica'),
		(1033, 'usa/pago-pago', 'Pago Pago', 'American Samoa'),
		(1034, 'antarctica/casey', 'Casey', 'Antarctica'),
		(1035, 'antarctica/davis', 'Davis', 'Antarctica'),
		(1036, 'uk/plymouth', 'Plymouth', 'United Kingdom'),
		(1037, 'india/port-blair', 'Port Blair', 'India'),
		(1038, 'india/pune', 'Pune', 'India'),
		(1039, 'india/surat', 'Surat', 'India'),
		(1040, 'india/patna', 'Patna', 'India'),
		(1041, 'india/indore', 'Indore', 'India'),
		(1042, 'india/bhubaneshwar', 'Bhubaneshwar', 'India'),
		(1043, 'india/ludhiana', 'Ludhiana', 'India'),
		(1044, 'india/visakhapatnam', 'Visakhapatnam', 'India'),
		(1045, 'india/varanasi', 'Varanasi', 'India'),
		(1046, 'india/agra', 'Agra', 'India'),
		(1047, 'india/madurai', 'Madurai', 'India'),
		(1048, 'west-bank/bethlehem', 'Bethlehem', 'West Bank'),
		(1049, 'thailand/khon-kaen', 'Khon Kaen', 'Thailand'),
		(1050, 'usa/santa-barbara', 'Santa Barbara', 'United States'),
		(1051, 'iraq/basra', 'Basra', 'Iraq'),
		(1052, 'iraq/mosul', 'Mosul', 'Iraq'),
		(1053, 'iraq/nasiriya', 'Nasiriya', 'Iraq'),
		(1054, 'iraq/irbil', 'Irbil', 'Iraq'),
		(1055, 'iraq/kirkuk', 'Kirkuk', 'Iraq'),
		(1056, 'iraq/sulaimaniya', 'Sulaimaniya', 'Iraq'),
		(1057, 'iraq/najaf', 'Najaf', 'Iraq'),
		(1058, 'iraq/karbala', 'Karbala', 'Iraq'),
		(1059, 'iraq/hilla', 'Hilla', 'Iraq'),
		(1060, 'usa/owensboro', 'Owensboro', 'United States'),
		(1061, 'iran/esfahan', 'Esfahan', 'Iran'),
		(1062, 'iran/mashhad', 'Mashhad', 'Iran'),
		(1063, 'iran/tabriz', 'Tabriz', 'Iran'),
		(1064, 'japan/hiroshima', 'Hiroshima', 'Japan'),
		(1065, 'japan/sendai', 'Sendai', 'Japan'),
		(1066, 'japan/okayama', 'Okayama', 'Japan'),
		(1067, 'taiwan/kaohsiung', 'Kaohsiung', 'Taiwan'),
		(1068, 'taiwan/taichung', 'Taichung', 'Taiwan'),
		(1069, 'micronesia/colonia', 'Colonia', 'Micronesia'),
		(1070, 'micronesia/weno', 'Weno', 'Micronesia'),
		(1071, 'micronesia/lelu', 'Lelu', 'Micronesia'),
		(1072, 'micronesia/palikir', 'Palikir', 'Micronesia'),
		(1073, 'malaysia/seremban', 'Seremban', 'Malaysia'),
		(1074, 'argentina/formosa', 'Formosa', 'Argentina'),
		(1075, 'argentina/santa-rosa', 'Santa Rosa', 'Argentina'),
		(1076, 'argentina/la-rioja', 'La Rioja', 'Argentina'),
		(1077, 'argentina/viedma', 'Viedma', 'Argentina'),
		(1078, 'argentina/san-juan', 'San Juan', 'Argentina'),
		(1079, 'argentina/rosario', 'Rosario', 'Argentina'),
		(1080, 'usa/key-west', 'Key West', 'United States'),
		(1081, 'usa/portland-me', 'Portland Me', 'United States'),
		(1082, 'usa/charleston-sc', 'Charleston Sc', 'United States'),
		(1083, 'usa/hilo', 'Hilo', 'United States'),
		(1084, 'usa/wailuku', 'Wailuku', 'United States'),
		(1085, 'canada/surrey', 'Surrey', 'Canada'),
		(1086, 'canada/burnaby', 'Burnaby', 'Canada'),
		(1087, 'canada/coquitlam', 'Coquitlam', 'Canada'),
		(1088, 'canada/richmond', 'Richmond', 'Canada'),
		(1089, 'canada/abbotsford', 'Abbotsford', 'Canada'),
		(1090, 'canada/dawson-creek', 'Dawson Creek', 'Canada'),
		(1091, 'canada/victoria', 'Victoria', 'Canada'),
		(1092, 'canada/kamloops', 'Kamloops', 'Canada'),
		(1093, 'canada/kelowna', 'Kelowna', 'Canada'),
		(1094, 'canada/nanaimo', 'Nanaimo', 'Canada'),
		(1095, 'canada/prince-george', 'Prince George', 'Canada'),
		(1096, 'canada/cranbrook', 'Cranbrook', 'Canada'),
		(1097, 'canada/banff', 'Banff', 'Canada'),
		(1098, 'canada/camrose', 'Camrose', 'Canada'),
		(1099, 'canada/grande-prairie', 'Grande Prairie', 'Canada'),
		(1100, 'canada/lethbridge', 'Lethbridge', 'Canada'),
		(1101, 'canada/lloydminster', 'Lloydminster', 'Canada'),
		(1102, 'canada/medicine-hat', 'Medicine Hat', 'Canada'),
		(1103, 'canada/red-deer', 'Red Deer', 'Canada'),
		(1104, 'canada/st-albert', 'St Albert', 'Canada'),
		(1105, 'canada/strathcona-county', 'Strathcona County', 'Canada'),
		(1106, 'canada/wood-buffalo', 'Wood Buffalo', 'Canada'),
		(1107, 'canada/chilliwack', 'Chilliwack', 'Canada'),
		(1108, 'canada/delta', 'Delta', 'Canada'),
		(1109, 'canada/langley', 'Langley', 'Canada'),
		(1110, 'canada/maple-ridge', 'Maple Ridge', 'Canada'),
		(1111, 'canada/new-westminster', 'New Westminster', 'Canada'),
		(1112, 'canada/port-coquitlam', 'Port Coquitlam', 'Canada'),
		(1113, 'canada/saanich', 'Saanich', 'Canada'),
		(1114, 'canada/whistler', 'Whistler', 'Canada'),
		(1115, 'canada/brandon', 'Brandon', 'Canada'),
		(1116, 'canada/morden', 'Morden', 'Canada'),
		(1117, 'canada/portage-la-prairie', 'Portage La Prairie', 'Canada'),
		(1118, 'canada/selkirk', 'Selkirk', 'Canada'),
		(1119, 'canada/dauphin', 'Dauphin', 'Canada'),
		(1120, 'canada/the-pas', 'The Pas', 'Canada'),
		(1121, 'canada/stonewall', 'Stonewall', 'Canada'),
		(1122, 'canada/steinbach', 'Steinbach', 'Canada'),
		(1123, 'canada/thompson', 'Thompson', 'Canada'),
		(1124, 'canada/bathurst', 'Bathurst', 'Canada'),
		(1125, 'canada/dieppe', 'Dieppe', 'Canada'),
		(1126, 'canada/edmundston', 'Edmundston', 'Canada'),
		(1127, 'canada/fredericton', 'Fredericton', 'Canada'),
		(1128, 'canada/miramichi', 'Miramichi', 'Canada'),
		(1129, 'canada/moncton', 'Moncton', 'Canada'),
		(1130, 'canada/quispamsis', 'Quispamsis', 'Canada'),
		(1131, 'canada/riverview', 'Riverview', 'Canada'),
		(1132, 'canada/rothesay', 'Rothesay', 'Canada'),
		(1133, 'canada/conception-bay-south', 'Conception Bay South', 'Canada'),
		(1134, 'canada/corner-brook', 'Corner Brook', 'Canada'),
		(1135, 'canada/gander', 'Gander', 'Canada'),
		(1136, 'canada/grand-falls-windsor', 'Grand Falls Windsor', 'Canada'),
		(1137, 'canada/happy-valley-goose-bay', 'Happy Valley Goose Bay', 'Canada'),
		(1138, 'canada/labrador-city', 'Labrador City', 'Canada'),
		(1139, 'canada/mount-pearl', 'Mount Pearl', 'Canada'),
		(1140, 'canada/paradise', 'Paradise', 'Canada'),
		(1141, 'canada/stephenville', 'Stephenville', 'Canada'),
		(1142, 'canada/fort-simpson', 'Fort Simpson', 'Canada'),
		(1143, 'canada/fort-smith', 'Fort Smith', 'Canada'),
		(1144, 'canada/hay-river', 'Hay River', 'Canada'),
		(1145, 'canada/inuvik', 'Inuvik', 'Canada'),
		(1146, 'canada/rae-edzo', 'Rae Edzo', 'Canada'),
		(1147, 'canada/annapolis-county', 'Annapolis County', 'Canada'),
		(1148, 'canada/cape-breton-regional-municipality', 'Cape Breton Regional Municipality', 'Canada'),
		(1149, 'canada/colchester-county', 'Colchester County', 'Canada'),
		(1150, 'canada/cumberland-county', 'Cumberland County', 'Canada'),
		(1151, 'canada/east-hants', 'East Hants', 'Canada'),
		(1152, 'canada/kings-county', 'Kings County', 'Canada'),
		(1153, 'canada/md-of-lunenburg', 'Md Of Lunenburg', 'Canada'),
		(1154, 'canada/pictou-county', 'Pictou County', 'Canada'),
		(1155, 'canada/yarmouth-county', 'Yarmouth County', 'Canada'),
		(1156, 'canada/arviat', 'Arviat', 'Canada'),
		(1157, 'canada/baker-lake', 'Baker Lake', 'Canada'),
		(1158, 'canada/cambridge-bay', 'Cambridge Bay', 'Canada'),
		(1159, 'canada/cape-dorset', 'Cape Dorset', 'Canada'),
		(1160, 'canada/coral-harbour', 'Coral Harbour', 'Canada'),
		(1161, 'canada/igloolik', 'Igloolik', 'Canada'),
		(1162, 'canada/kugluktuk', 'Kugluktuk', 'Canada'),
		(1163, 'canada/pangnirtung', 'Pangnirtung', 'Canada'),
		(1164, 'canada/pond-inlet', 'Pond Inlet', 'Canada'),
		(1165, 'canada/rankin-inlet', 'Rankin Inlet', 'Canada'),
		(1166, 'canada/ajax', 'Ajax', 'Canada'),
		(1167, 'canada/barrie', 'Barrie', 'Canada'),
		(1168, 'canada/belleville', 'Belleville', 'Canada'),
		(1169, 'canada/brampton', 'Brampton', 'Canada'),
		(1170, 'canada/brantford', 'Brantford', 'Canada'),
		(1171, 'canada/burlington', 'Burlington', 'Canada'),
		(1172, 'canada/caledon', 'Caledon', 'Canada'),
		(1173, 'canada/cambridge', 'Cambridge', 'Canada'),
		(1174, 'canada/chatham-kent', 'Chatham Kent', 'Canada'),
		(1175, 'canada/clarington', 'Clarington', 'Canada'),
		(1176, 'canada/cornwall', 'Cornwall', 'Canada'),
		(1177, 'canada/greater-sudbury', 'Greater Sudbury', 'Canada'),
		(1178, 'canada/guelph', 'Guelph', 'Canada'),
		(1179, 'canada/haldimand', 'Haldimand', 'Canada'),
		(1180, 'canada/halton-hills', 'Halton Hills', 'Canada'),
		(1181, 'canada/hamilton', 'Hamilton', 'Canada'),
		(1182, 'canada/kawartha-lakes', 'Kawartha Lakes', 'Canada'),
		(1183, 'canada/kingston', 'Kingston', 'Canada'),
		(1184, 'canada/kitchener', 'Kitchener', 'Canada'),
		(1185, 'canada/london', 'London', 'Canada'),
		(1186, 'canada/markham', 'Markham', 'Canada'),
		(1187, 'canada/mississauga', 'Mississauga', 'Canada'),
		(1188, 'canada/newmarket', 'Newmarket', 'Canada'),
		(1189, 'canada/niagara-falls', 'Niagara Falls', 'Canada'),
		(1190, 'canada/norfolk', 'Norfolk', 'Canada'),
		(1191, 'canada/north-bay', 'North Bay', 'Canada'),
		(1192, 'canada/oakville', 'Oakville', 'Canada'),
		(1193, 'canada/oshawa', 'Oshawa', 'Canada'),
		(1194, 'canada/peterborough', 'Peterborough', 'Canada'),
		(1195, 'canada/pickering', 'Pickering', 'Canada'),
		(1196, 'canada/richmond-hill', 'Richmond Hill', 'Canada'),
		(1197, 'canada/sarnia', 'Sarnia', 'Canada'),
		(1198, 'canada/sault-ste-marie', 'Sault Ste Marie', 'Canada'),
		(1199, 'canada/st-catharines', 'St Catharines', 'Canada'),
		(1200, 'canada/thunder-bay', 'Thunder Bay', 'Canada'),
		(1201, 'canada/timmins', 'Timmins', 'Canada'),
		(1202, 'canada/vaughan', 'Vaughan', 'Canada'),
		(1203, 'canada/waterloo', 'Waterloo', 'Canada'),
		(1204, 'canada/welland', 'Welland', 'Canada'),
		(1205, 'canada/whitby', 'Whitby', 'Canada'),
		(1206, 'canada/windsor', 'Windsor', 'Canada'),
		(1207, 'canada/summerside', 'Summerside', 'Canada'),
		(1208, 'canada/drummondville', 'Drummondville', 'Canada'),
		(1209, 'canada/gatineau', 'Gatineau', 'Canada'),
		(1210, 'canada/granby', 'Granby', 'Canada'),
		(1211, 'canada/laval', 'Laval', 'Canada'),
		(1212, 'canada/levis', 'Levis', 'Canada'),
		(1213, 'canada/longueuil', 'Longueuil', 'Canada'),
		(1214, 'canada/repentigny', 'Repentigny', 'Canada'),
		(1215, 'canada/rimouski', 'Rimouski', 'Canada'),
		(1216, 'canada/saguenay', 'Saguenay', 'Canada'),
		(1217, 'canada/saint-hyacinthe', 'Saint Hyacinthe', 'Canada'),
		(1218, 'canada/saint-jean-sur-richelieu', 'Saint Jean Sur Richelieu', 'Canada'),
		(1219, 'canada/saint-jerome', 'Saint Jerome', 'Canada'),
		(1220, 'canada/shawinigan', 'Shawinigan', 'Canada'),
		(1221, 'canada/sherbrooke', 'Sherbrooke', 'Canada'),
		(1222, 'canada/terrebonne', 'Terrebonne', 'Canada'),
		(1223, 'canada/trois-rivieres', 'Trois Rivieres', 'Canada'),
		(1224, 'canada/creighton', 'Creighton', 'Canada'),
		(1225, 'canada/denare-beach', 'Denare Beach', 'Canada'),
		(1226, 'canada/moose-jaw', 'Moose Jaw', 'Canada'),
		(1227, 'canada/saskatoon', 'Saskatoon', 'Canada'),
		(1228, 'malaysia/george-town', 'George Town', 'Malaysia'),
		(1229, 'switzerland/basel', 'Basel', 'Switzerland'),
		(1230, 'thailand/phuket', 'Phuket', 'Thailand'),
		(1231, 'thailand/pattaya', 'Pattaya', 'Thailand'),
		(1232, 'china/shenzhen', 'Shenzhen', 'China'),
		(1233, 'uk/oxford', 'Oxford', 'United Kingdom'),
		(1234, 'uk/cambridge', 'Cambridge', 'United Kingdom'),
		(1235, 'mexico/cozumel', 'Cozumel', 'Mexico'),
		(1236, 'pakistan/peshawar', 'Peshawar', 'Pakistan'),
		(1237, 'pakistan/sialkot', 'Sialkot', 'Pakistan'),
		(1238, 'philippines/cebu-city', 'Cebu City', 'Philippines'),
		(1239, 'usa/cupertino', 'Cupertino', 'United States'),
		(1240, 'usa/palo-alto', 'Palo Alto', 'United States'),
		(1241, 'usa/mountain-view', 'Mountain View', 'United States'),
		(1242, 'usa/aspen', 'Aspen', 'United States'),
		(1243, 'usa/boulder', 'Boulder', 'United States'),
		(1244, 'usa/redmond', 'Redmond', 'United States'),
		(1245, 'russia/yuzhno-sakhalinsk', 'Yuzhno Sakhalinsk', 'Russia'),
		(1246, 'belgium/ghent', 'Ghent', 'Belgium'),
		(1247, 'belgium/charleroi', 'Charleroi', 'Belgium'),
		(1248, 'belgium/liege', 'Liege', 'Belgium'),
		(1249, 'belgium/bruges', 'Bruges', 'Belgium'),
		(1250, 'belgium/namur', 'Namur', 'Belgium'),
		(1251, 'belgium/mons', 'Mons', 'Belgium'),
		(1252, 'belgium/leuven', 'Leuven', 'Belgium'),
		(1253, 'belgium/mechelen', 'Mechelen', 'Belgium'),
		(1254, 'afghanistan/kandahar', 'Kandahar', 'Afghanistan'),
		(1255, 'afghanistan/mazari-sharif', 'Mazari Sharif', 'Afghanistan'),
		(1256, 'afghanistan/herat', 'Herat', 'Afghanistan'),
		(1257, 'afghanistan/jalalabad', 'Jalalabad', 'Afghanistan'),
		(1258, 'afghanistan/kunduz', 'Kunduz', 'Afghanistan'),
		(1259, 'afghanistan/ghazni', 'Ghazni', 'Afghanistan'),
		(1260, 'afghanistan/bamyan', 'Bamyan', 'Afghanistan'),
		(1261, 'afghanistan/balkh', 'Balkh', 'Afghanistan'),
		(1262, 'afghanistan/baghlan', 'Baghlan', 'Afghanistan'),
		(1263, 'france/montpellier', 'Montpellier', 'France'),
		(1264, 'france/rennes', 'Rennes', 'France'),
		(1265, 'france/reims', 'Reims', 'France'),
		(1266, 'france/saint-etienne', 'Saint Etienne', 'France'),
		(1267, 'france/toulon', 'Toulon', 'France'),
		(1268, 'france/grenoble', 'Grenoble', 'France'),
		(1269, 'france/angers', 'Angers', 'France'),
		(1270, 'france/dijon', 'Dijon', 'France'),
		(1271, 'france/le-mans', 'Le Mans', 'France'),
		(1272, 'france/clermont-ferrand', 'Clermont Ferrand', 'France'),
		(1273, 'france/amiens', 'Amiens', 'France'),
		(1274, 'france/aix-en-provence', 'Aix En Provence', 'France'),
		(1275, 'france/limoges', 'Limoges', 'France'),
		(1276, 'france/nimes', 'Nimes', 'France'),
		(1277, 'france/tours', 'Tours', 'France'),
		(1278, 'france/saint-denis', 'Saint Denis', 'France'),
		(1279, 'france/villeurbanne', 'Villeurbanne', 'France'),
		(1280, 'france/metz', 'Metz', 'France'),
		(1281, 'france/besancon', 'Besancon', 'France'),
		(1282, 'france/caen', 'Caen', 'France'),
		(1283, 'france/orleans', 'Orleans', 'France'),
		(1284, 'france/mulhouse', 'Mulhouse', 'France'),
		(1285, 'france/rouen', 'Rouen', 'France'),
		(1286, 'france/boulogne-billancourt', 'Boulogne Billancourt', 'France'),
		(1287, 'france/perpignan', 'Perpignan', 'France'),
		(1288, 'france/nancy', 'Nancy', 'France'),
		(1289, 'france/lens', 'Lens', 'France'),
		(1290, 'france/douai', 'Douai', 'France'),
		(1291, 'france/istres', 'Istres', 'France'),
		(1292, 'netherlands/groningen', 'Groningen', 'Netherlands'),
		(1293, 'netherlands/almere', 'Almere', 'Netherlands'),
		(1294, 'netherlands/amersfoort', 'Amersfoort', 'Netherlands'),
		(1295, 'netherlands/apeldoorn', 'Apeldoorn', 'Netherlands'),
		(1296, 'netherlands/arnhem', 'Arnhem', 'Netherlands'),
		(1297, 'netherlands/breda', 'Breda', 'Netherlands'),
		(1298, 'netherlands/dordrecht', 'Dordrecht', 'Netherlands'),
		(1299, 'netherlands/ede', 'Ede', 'Netherlands'),
		(1300, 'netherlands/eindhoven', 'Eindhoven', 'Netherlands'),
		(1301, 'netherlands/emmen', 'Emmen', 'Netherlands'),
		(1302, 'netherlands/enschede', 'Enschede', 'Netherlands'),
		(1303, 'netherlands/haarlem', 'Haarlem', 'Netherlands'),
		(1304, 'netherlands/hoofddorp', 'Hoofddorp', 'Netherlands'),
		(1305, 'netherlands/s-hertogenbosch', 'S Hertogenbosch', 'Netherlands'),
		(1306, 'netherlands/leiden', 'Leiden', 'Netherlands'),
		(1307, 'netherlands/maastricht', 'Maastricht', 'Netherlands'),
		(1308, 'netherlands/nijmegen', 'Nijmegen', 'Netherlands'),
		(1309, 'netherlands/tilburg', 'Tilburg', 'Netherlands'),
		(1310, 'netherlands/utrecht', 'Utrecht', 'Netherlands'),
		(1311, 'netherlands/zaandam', 'Zaandam', 'Netherlands'),
		(1312, 'netherlands/zoetermeer', 'Zoetermeer', 'Netherlands'),
		(1313, 'netherlands/zwolle', 'Zwolle', 'Netherlands'),
		(1314, 'netherlands/the-hague', 'The Hague', 'Netherlands'),
		(1315, 'netherlands/philipsburg', 'Philipsburg', 'Sint Maarten'),
		(1316, 'uk/sheffield', 'Sheffield', 'United Kingdom'),
		(1317, 'uk/leicester', 'Leicester', 'United Kingdom'),
		(1318, 'uk/coventry', 'Coventry', 'United Kingdom'),
		(1319, 'uk/kingston-upon-hull', 'Kingston Upon Hull', 'United Kingdom'),
		(1320, 'uk/bradford', 'Bradford', 'United Kingdom'),
		(1321, 'uk/stoke-on-trent', 'Stoke On Trent', 'United Kingdom'),
		(1322, 'uk/wolverhampton', 'Wolverhampton', 'United Kingdom'),
		(1323, 'uk/nottingham', 'Nottingham', 'United Kingdom'),
		(1324, 'uk/reading', 'Reading', 'United Kingdom'),
		(1325, 'uk/derby', 'Derby', 'United Kingdom'),
		(1326, 'uk/dudley', 'Dudley', 'United Kingdom'),
		(1327, 'uk/newcastle-upon-tyne', 'Newcastle Upon Tyne', 'United Kingdom'),
		(1328, 'uk/northampton', 'Northampton', 'United Kingdom'),
		(1329, 'uk/portsmouth', 'Portsmouth', 'United Kingdom'),
		(1330, 'uk/luton', 'Luton', 'United Kingdom'),
		(1331, 'uk/preston', 'Preston', 'United Kingdom'),
		(1332, 'uk/milton-keynes', 'Milton Keynes', 'United Kingdom'),
		(1333, 'uk/sunderland', 'Sunderland', 'United Kingdom'),
		(1334, 'uk/norwich', 'Norwich', 'United Kingdom'),
		(1335, 'uk/walsall', 'Walsall', 'United Kingdom'),
		(1336, 'uk/swansea', 'Swansea', 'United Kingdom'),
		(1337, 'uk/bournemouth', 'Bournemouth', 'United Kingdom'),
		(1338, 'uk/southend-on-sea', 'Southend On Sea', 'United Kingdom'),
		(1339, 'uk/swindon', 'Swindon', 'United Kingdom'),
		(1340, 'uk/dundee', 'Dundee', 'United Kingdom'),
		(1341, 'uk/huddersfield', 'Huddersfield', 'United Kingdom'),
		(1342, 'uk/poole', 'Poole', 'United Kingdom'),
		(1343, 'uk/middlesbrough', 'Middlesbrough', 'United Kingdom'),
		(1344, 'uk/blackpool', 'Blackpool', 'United Kingdom'),
		(1345, 'uk/bolton', 'Bolton', 'United Kingdom'),
		(1346, 'uk/ipswich', 'Ipswich', 'United Kingdom'),
		(1347, 'uk/telford', 'Telford', 'United Kingdom'),
		(1348, 'uk/york', 'York', 'United Kingdom'),
		(1349, 'uk/west-bromwich', 'West Bromwich', 'United Kingdom'),
		(1350, 'uk/peterborough', 'Peterborough', 'United Kingdom'),
		(1351, 'uk/stockport', 'Stockport', 'United Kingdom'),
		(1352, 'uk/brighton', 'Brighton', 'United Kingdom'),
		(1353, 'uk/slough', 'Slough', 'United Kingdom'),
		(1354, 'uk/gloucester', 'Gloucester', 'United Kingdom'),
		(1355, 'uk/watford', 'Watford', 'United Kingdom'),
		(1356, 'uk/rotherham', 'Rotherham', 'United Kingdom'),
		(1357, 'uk/newport', 'Newport', 'United Kingdom'),
		(1358, 'uk/exeter', 'Exeter', 'United Kingdom'),
		(1359, 'uk/eastbourne', 'Eastbourne', 'United Kingdom'),
		(1360, 'uk/sutton-coldfield', 'Sutton Coldfield', 'United Kingdom'),
		(1361, 'uk/blackburn', 'Blackburn', 'United Kingdom'),
		(1362, 'uk/colchester', 'Colchester', 'United Kingdom'),
		(1363, 'uk/oldham', 'Oldham', 'United Kingdom'),
		(1364, 'uk/st-helens', 'St Helens', 'United Kingdom'),
		(1365, 'uk/crawley', 'Crawley', 'United Kingdom'),
		(1366, 'cyprus/limassol', 'Limassol', 'Cyprus'),
		(1367, 'cyprus/larnaca', 'Larnaca', 'Cyprus'),
		(1368, 'cyprus/paphos', 'Paphos', 'Cyprus'),
		(1369, 'norway/sandnes', 'Sandnes', 'Norway'),
		(1370, 'norway/drammen', 'Drammen', 'Norway'),
		(1371, 'norway/kristiansand', 'Kristiansand', 'Norway'),
		(1372, 'norway/fredrikstad', 'Fredrikstad', 'Norway'),
		(1373, 'norway/sarpsborg', 'Sarpsborg', 'Norway'),
		(1374, 'norway/bodo', 'Bodo', 'Norway'),
		(1375, 'norway/skien', 'Skien', 'Norway'),
		(1376, 'sweden/uppsala', 'Uppsala', 'Sweden'),
		(1377, 'sweden/linkoping', 'Linkoping', 'Sweden'),
		(1378, 'sweden/vasteras', 'Vasteras', 'Sweden'),
		(1379, 'sweden/orebro', 'Orebro', 'Sweden'),
		(1380, 'sweden/norrkoping', 'Norrkoping', 'Sweden'),
		(1381, 'sweden/helsingborg', 'Helsingborg', 'Sweden'),
		(1382, 'sweden/jonkoping', 'Jonkoping', 'Sweden'),
		(1383, 'sweden/umea', 'Umea', 'Sweden'),
		(1384, 'sweden/lund', 'Lund', 'Sweden'),
		(1385, 'sweden/boras', 'Boras', 'Sweden'),
		(1386, 'sweden/gavle', 'Gavle', 'Sweden'),
		(1387, 'sweden/eskilstuna', 'Eskilstuna', 'Sweden'),
		(1388, 'sweden/halmstad', 'Halmstad', 'Sweden'),
		(1389, 'sweden/karlstad', 'Karlstad', 'Sweden'),
		(1390, 'sweden/sodertalje', 'Sodertalje', 'Sweden'),
		(1391, 'sweden/vaxjo', 'Vaxjo', 'Sweden'),
		(1392, 'finland/espoo', 'Espoo', 'Finland'),
		(1393, 'finland/tampere', 'Tampere', 'Finland'),
		(1394, 'finland/vantaa', 'Vantaa', 'Finland'),
		(1395, 'finland/lahti', 'Lahti', 'Finland'),
		(1396, 'finland/kuopio', 'Kuopio', 'Finland'),
		(1397, 'finland/jyvaskyla', 'Jyvaskyla', 'Finland'),
		(1398, 'finland/pori', 'Pori', 'Finland'),
		(1399, 'finland/lappeenranta', 'Lappeenranta', 'Finland'),
		(1400, 'finland/joensuu', 'Joensuu', 'Finland'),
		(1401, 'finland/rovaniemi', 'Rovaniemi', 'Finland'),
		(1402, 'finland/vaasa', 'Vaasa', 'Finland'),
		(1403, 'finland/kotka', 'Kotka', 'Finland'),
		(1404, 'finland/mariehamn', 'Mariehamn', 'Finland'),
		(1405, 'denmark/aarhus', 'Aarhus', 'Denmark'),
		(1406, 'denmark/odense', 'Odense', 'Denmark'),
		(1407, 'denmark/aalborg', 'Aalborg', 'Denmark'),
		(1408, 'denmark/esbjerg', 'Esbjerg', 'Denmark'),
		(1409, 'denmark/randers', 'Randers', 'Denmark'),
		(1410, 'denmark/kolding', 'Kolding', 'Denmark'),
		(1411, 'denmark/horsens', 'Horsens', 'Denmark'),
		(1412, 'denmark/vejle', 'Vejle', 'Denmark'),
		(1413, 'denmark/roskilde', 'Roskilde', 'Denmark'),
		(1414, 'portugal/amadora', 'Amadora', 'Portugal'),
		(1415, 'portugal/braga', 'Braga', 'Portugal'),
		(1416, 'portugal/coimbra', 'Coimbra', 'Portugal'),
		(1417, 'portugal/setubal', 'Setubal', 'Portugal'),
		(1418, 'portugal/faro', 'Faro', 'Portugal'),
		(1419, 'portugal/guimaraes', 'Guimaraes', 'Portugal'),
		(1420, 'portugal/cascais', 'Cascais', 'Portugal'),
		(1421, 'portugal/loures', 'Loures', 'Portugal'),
		(1422, 'portugal/viseu', 'Viseu', 'Portugal'),
		(1423, 'portugal/vila-nova-de-gaia', 'Vila Nova De Gaia', 'Portugal'),
		(1424, 'switzerland/winterthur', 'Winterthur', 'Switzerland'),
		(1425, 'switzerland/st-gallen', 'St Gallen', 'Switzerland'),
		(1426, 'switzerland/lucerne', 'Lucerne', 'Switzerland'),
		(1427, 'switzerland/biel', 'Biel', 'Switzerland'),
		(1428, 'greece/thessaloniki', 'Thessaloniki', 'Greece'),
		(1429, 'greece/piraeus', 'Piraeus', 'Greece'),
		(1430, 'greece/patras', 'Patras', 'Greece'),
		(1431, 'greece/heraklion', 'Heraklion', 'Greece'),
		(1432, 'greece/peristeri', 'Peristeri', 'Greece'),
		(1433, 'greece/larissa', 'Larissa', 'Greece'),
		(1434, 'greece/kallithea', 'Kallithea', 'Greece'),
		(1435, 'greece/nikaia', 'Nikaia', 'Greece'),
		(1436, 'greece/kalamaria', 'Kalamaria', 'Greece'),
		(1437, 'greece/glyfada', 'Glyfada', 'Greece'),
		(1438, 'greece/acharnes', 'Acharnes', 'Greece'),
		(1439, 'greece/volos', 'Volos', 'Greece'),
		(1440, '/utc', 'Utc', ' '),
		(1441, 'greece/ilio', 'Ilio', 'Greece'),
		(1442, 'greece/keratsini', 'Keratsini', 'Greece'),
		(1443, 'greece/ilioupoli', 'Ilioupoli', 'Greece'),
		(1444, 'greece/nea-smyrni', 'Nea Smyrni', 'Greece'),
		(1445, 'poland/bydgoszcz', 'Bydgoszcz', 'Poland'),
		(1446, 'poland/lublin', 'Lublin', 'Poland'),
		(1447, 'poland/katowice', 'Katowice', 'Poland'),
		(1448, 'poland/bialystok', 'Bialystok', 'Poland'),
		(1449, 'poland/gdynia', 'Gdynia', 'Poland'),
		(1450, 'poland/czestochowa', 'Czestochowa', 'Poland'),
		(1451, 'poland/sosnowiec', 'Sosnowiec', 'Poland'),
		(1452, 'poland/radom', 'Radom', 'Poland'),
		(1453, 'poland/kielce', 'Kielce', 'Poland'),
		(1454, 'poland/torun', 'Torun', 'Poland'),
		(1455, 'poland/gliwice', 'Gliwice', 'Poland'),
		(1456, 'poland/bytom', 'Bytom', 'Poland'),
		(1457, 'poland/zabrze', 'Zabrze', 'Poland'),
		(1458, 'poland/bielsko-biala', 'Bielsko Biala', 'Poland'),
		(1459, 'poland/olsztyn', 'Olsztyn', 'Poland'),
		(1460, 'poland/rzeszow', 'Rzeszow', 'Poland'),
		(1461, 'poland/ruda-slaska', 'Ruda Slaska', 'Poland'),
		(1462, 'poland/rybnik', 'Rybnik', 'Poland'),
		(1463, 'poland/tychy', 'Tychy', 'Poland'),
		(1464, 'poland/dabrowa-gornicza', 'Dabrowa Gornicza', 'Poland'),
		(1465, 'poland/opole', 'Opole', 'Poland'),
		(1466, 'poland/walbrzych', 'Walbrzych', 'Poland'),
		(1467, 'poland/plock', 'Plock', 'Poland'),
		(1468, 'poland/elblag', 'Elblag', 'Poland'),
		(1469, 'poland/gorzow-wielkopolski', 'Gorzow Wielkopolski', 'Poland'),
		(1470, 'poland/wloclawek', 'Wloclawek', 'Poland'),
		(1471, 'poland/zielona-gora', 'Zielona Gora', 'Poland'),
		(1472, 'poland/tarnow', 'Tarnow', 'Poland'),
		(1473, 'poland/chorzow', 'Chorzow', 'Poland'),
		(1474, 'poland/kalisz', 'Kalisz', 'Poland'),
		(1475, 'poland/koszalin', 'Koszalin', 'Poland'),
		(1476, 'poland/legnica', 'Legnica', 'Poland'),
		(1477, 'poland/slupsk', 'Slupsk', 'Poland'),
		(1478, 'poland/grudziadz', 'Grudziadz', 'Poland'),
		(1479, 'poland/jastrzebie-zdroj', 'Jastrzebie Zdroj', 'Poland'),
		(1480, 'united-arab-emirates/ajman', 'Ajman', 'United Arab Emirates'),
		(1481, 'united-arab-emirates/al-ain', 'Al Ain', 'United Arab Emirates'),
		(1482, 'united-arab-emirates/sharjah', 'Sharjah', 'United Arab Emirates'),
		(1483, 'united-arab-emirates/ras-al-khaimah', 'Ras Al Khaimah', 'United Arab Emirates'),
		(1484, 'south-africa/bloemfontein', 'Bloemfontein', 'South Africa'),
		(1485, 'south-africa/port-elizabeth', 'Port Elizabeth', 'South Africa'),
		(1486, 'south-africa/east-london', 'East London', 'South Africa'),
		(1487, 'south-africa/durban', 'Durban', 'South Africa'),
		(1488, 'south-africa/pietermaritzburg', 'Pietermaritzburg', 'South Africa'),
		(1489, 'south-africa/vereeniging', 'Vereeniging', 'South Africa'),
		(1490, 'australia/gold-coast', 'Gold Coast', 'Australia'),
		(1491, 'australia/sunshine-coast', 'Sunshine Coast', 'Australia'),
		(1492, 'australia/geelong', 'Geelong', 'Australia'),
		(1493, 'australia/mandurah', 'Mandurah', 'Australia'),
		(1494, 'australia/shepparton', 'Shepparton', 'Australia'),
		(1495, 'australia/albury', 'Albury', 'Australia'),
		(1496, 'australia/wodonga', 'Wodonga', 'Australia'),
		(1497, 'australia/mackay', 'Mackay', 'Australia'),
		(1498, 'australia/rockhampton', 'Rockhampton', 'Australia'),
		(1499, 'australia/bundaberg', 'Bundaberg', 'Australia'),
		(1500, 'australia/bunbury', 'Bunbury', 'Australia'),
		(1501, 'australia/coffs-harbour', 'Coffs Harbour', 'Australia'),
		(1502, 'australia/hervey-bay', 'Hervey Bay', 'Australia'),
		(1503, 'cocos/bantam', 'Bantam', 'Cocos (Keeling) Islands'),
		(1504, 'israel/haifa', 'Haifa', 'Israel'),
		(1505, 'israel/rishon-lezion', 'Rishon Lezion', 'Israel'),
		(1506, 'israel/ashdod', 'Ashdod', 'Israel'),
		(1507, 'israel/beersheba', 'Beersheba', 'Israel'),
		(1508, 'israel/petah-tikva', 'Petah Tikva', 'Israel'),
		(1509, 'israel/netanya', 'Netanya', 'Israel'),
		(1510, 'israel/holon', 'Holon', 'Israel'),
		(1511, 'israel/bnei-brak', 'Bnei Brak', 'Israel'),
		(1512, 'israel/bat-yam', 'Bat Yam', 'Israel'),
		(1513, 'israel/ramat-gan', 'Ramat Gan', 'Israel'),
		(1514, 'israel/ashkelon', 'Ashkelon', 'Israel'),
		(1515, 'israel/rehovot', 'Rehovot', 'Israel'),
		(1516, 'israel/herzliya', 'Herzliya', 'Israel'),
		(1517, 'israel/kfar-saba', 'Kfar Saba', 'Israel'),
		(1518, 'israel/hadera', 'Hadera', 'Israel'),
		(1519, 'israel/raanana', 'Raanana', 'Israel'),
		(1520, 'india/guntur', 'Guntur', 'India'),
		(1521, 'india/tirumala', 'Tirumala', 'India'),
		(1522, 'india/vijayawada', 'Vijayawada', 'India'),
		(1523, 'india/warangal', 'Warangal', 'India'),
		(1524, 'india/itanagar', 'Itanagar', 'India'),
		(1525, 'india/dispur', 'Dispur', 'India'),
		(1526, 'india/dibrugarh', 'Dibrugarh', 'India'),
		(1527, 'india/guwahati', 'Guwahati', 'India'),
		(1528, 'india/nagaon', 'Nagaon', 'India'),
		(1529, 'india/sibsagar', 'Sibsagar', 'India'),
		(1530, 'india/silchar', 'Silchar', 'India'),
		(1531, 'india/tinsukia', 'Tinsukia', 'India'),
		(1532, 'india/raipur', 'Raipur', 'India'),
		(1533, 'india/motihari', 'Motihari', 'India'),
		(1534, 'india/muzaffarpur', 'Muzaffarpur', 'India'),
		(1535, 'india/madhubani', 'Madhubani', 'India'),
		(1536, 'india/gaya', 'Gaya', 'India'),
		(1537, 'india/samastipur', 'Samastipur', 'India'),
		(1538, 'india/darbhanga', 'Darbhanga', 'India'),
		(1539, 'india/chhapra', 'Chhapra', 'India'),
		(1540, 'india/bettiah', 'Bettiah', 'India'),
		(1541, 'india/hajipur', 'Hajipur', 'India'),
		(1542, 'india/siwan', 'Siwan', 'India'),
		(1543, 'india/sitamarhi', 'Sitamarhi', 'India'),
		(1544, 'india/purnia', 'Purnia', 'India'),
		(1545, 'india/sasaram', 'Sasaram', 'India'),
		(1546, 'india/bhagalpur', 'Bhagalpur', 'India'),
		(1547, 'india/katihar', 'Katihar', 'India'),
		(1548, 'india/nalanda', 'Nalanda', 'India'),
		(1549, 'india/begusarai', 'Begusarai', 'India'),
		(1550, 'india/arrah', 'Arrah', 'India'),
		(1551, 'india/gopalganj', 'Gopalganj', 'India'),
		(1552, 'india/araria', 'Araria', 'India'),
		(1553, 'india/aurangabad-bihar', 'Aurangabad Bihar', 'India'),
		(1554, 'india/nawada', 'Nawada', 'India'),
		(1555, 'india/supaul', 'Supaul', 'India'),
		(1556, 'india/banka', 'Banka', 'India'),
		(1557, 'india/madhepura', 'Madhepura', 'India'),
		(1558, 'india/jehanabad', 'Jehanabad', 'India'),
		(1559, 'india/saharsa', 'Saharsa', 'India'),
		(1560, 'india/buxar', 'Buxar', 'India'),
		(1561, 'india/jamui', 'Jamui', 'India'),
		(1562, 'india/kishanganj', 'Kishanganj', 'India'),
		(1563, 'india/bhabua', 'Bhabua', 'India'),
		(1564, 'india/khagaria', 'Khagaria', 'India'),
		(1565, 'india/munger', 'Munger', 'India'),
		(1566, 'india/lakhisarai', 'Lakhisarai', 'India'),
		(1567, 'india/sheikhpura', 'Sheikhpura', 'India'),
		(1568, 'india/sheohar', 'Sheohar', 'India'),
		(1569, 'india/panaji', 'Panaji', 'India'),
		(1570, 'india/vasco-da-gama', 'Vasco Da Gama', 'India'),
		(1571, 'india/margao', 'Margao', 'India'),
		(1572, 'india/gandhinagar', 'Gandhinagar', 'India'),
		(1573, 'india/junagadh', 'Junagadh', 'India'),
		(1574, 'india/jamnagar', 'Jamnagar', 'India'),
		(1575, 'india/bhavnagar', 'Bhavnagar', 'India'),
		(1576, 'india/rajkot', 'Rajkot', 'India'),
		(1577, 'india/nadiad', 'Nadiad', 'India'),
		(1578, 'india/anand', 'Anand', 'India'),
		(1579, 'india/bharuch', 'Bharuch', 'India'),
		(1580, 'india/navsari', 'Navsari', 'India'),
		(1581, 'india/bhuj', 'Bhuj', 'India'),
		(1582, 'india/chandigarh', 'Chandigarh', 'India'),
		(1583, 'india/gurgaon', 'Gurgaon', 'India'),
		(1584, 'india/panipat', 'Panipat', 'India'),
		(1585, 'india/panchkula', 'Panchkula', 'India'),
		(1586, 'india/faridabad', 'Faridabad', 'India'),
		(1587, 'india/jammu', 'Jammu', 'India'),
		(1588, 'india/anantnag', 'Anantnag', 'India'),
		(1589, 'india/baramulla', 'Baramulla', 'India'),
		(1590, 'india/kathua', 'Kathua', 'India'),
		(1591, 'india/pampore', 'Pampore', 'India'),
		(1592, 'india/sopore', 'Sopore', 'India'),
		(1593, 'india/srinagar', 'Srinagar', 'India'),
		(1594, 'india/udhampur', 'Udhampur', 'India'),
		(1595, 'india/ranchi', 'Ranchi', 'India'),
		(1596, 'india/jamshedpur', 'Jamshedpur', 'India'),
		(1597, 'india/bokaro-steel-city', 'Bokaro Steel City', 'India'),
		(1598, 'india/sindri', 'Sindri', 'India'),
		(1599, 'india/giridih', 'Giridih', 'India'),
		(1600, 'india/gumla', 'Gumla', 'India'),
		(1601, 'india/deoghar', 'Deoghar', 'India'),
		(1602, 'india/hazaribagh', 'Hazaribagh', 'India'),
		(1603, 'india/dhanbad', 'Dhanbad', 'India'),
		(1604, 'india/balaghat', 'Balaghat', 'India'),
		(1605, 'india/barwani', 'Barwani', 'India'),
		(1606, 'india/betul', 'Betul', 'India'),
		(1607, 'india/bhind', 'Bhind', 'India'),
		(1608, 'india/burhanpur', 'Burhanpur', 'India'),
		(1609, 'india/chhatarpur', 'Chhatarpur', 'India'),
		(1610, 'india/mandla', 'Mandla', 'India'),
		(1611, 'india/chhindwara', 'Chhindwara', 'India'),
		(1612, 'india/damoh', 'Damoh', 'India'),
		(1613, 'india/datia', 'Datia', 'India'),
		(1614, 'india/dewas', 'Dewas', 'India'),
		(1615, 'india/dhar', 'Dhar', 'India'),
		(1616, 'india/guna', 'Guna', 'India'),
		(1617, 'india/gwalior', 'Gwalior', 'India'),
		(1618, 'india/harda', 'Harda', 'India'),
		(1619, 'india/hoshangabad', 'Hoshangabad', 'India'),
		(1620, 'india/jabalpur', 'Jabalpur', 'India'),
		(1621, 'india/jhabua', 'Jhabua', 'India'),
		(1622, 'india/katni', 'Katni', 'India'),
		(1623, 'india/khandwa', 'Khandwa', 'India'),
		(1624, 'india/khargone', 'Khargone', 'India'),
		(1625, 'india/mandsaur', 'Mandsaur', 'India'),
		(1626, 'india/morena', 'Morena', 'India'),
		(1627, 'india/narsinghpur', 'Narsinghpur', 'India'),
		(1628, 'india/neemuch', 'Neemuch', 'India'),
		(1629, 'india/panna', 'Panna', 'India'),
		(1630, 'india/rajgarh', 'Rajgarh', 'India'),
		(1631, 'india/ratlam', 'Ratlam', 'India'),
		(1632, 'india/rewa', 'Rewa', 'India'),
		(1633, 'india/sagar', 'Sagar', 'India'),
		(1634, 'india/satna', 'Satna', 'India'),
		(1635, 'india/sehore', 'Sehore', 'India'),
		(1636, 'india/seoni', 'Seoni', 'India'),
		(1637, 'india/shahdol', 'Shahdol', 'India'),
		(1638, 'india/shajapur', 'Shajapur', 'India'),
		(1639, 'india/sheopur', 'Sheopur', 'India'),
		(1640, 'india/shivpuri', 'Shivpuri', 'India'),
		(1641, 'india/sidhi', 'Sidhi', 'India'),
		(1642, 'india/tikamgarh', 'Tikamgarh', 'India'),
		(1643, 'india/ujjain', 'Ujjain', 'India'),
		(1644, 'india/vidisha', 'Vidisha', 'India'),
		(1645, 'india/akola', 'Akola', 'India'),
		(1646, 'india/amravati', 'Amravati', 'India'),
		(1647, 'india/buldhana', 'Buldhana', 'India'),
		(1648, 'india/washim', 'Washim', 'India'),
		(1649, 'india/yavatmal', 'Yavatmal', 'India'),
		(1650, 'india/aurangabad', 'Aurangabad', 'India'),
		(1651, 'india/beed', 'Beed', 'India'),
		(1652, 'india/hingoli', 'Hingoli', 'India'),
		(1653, 'india/jalna', 'Jalna', 'India'),
		(1654, 'india/latur', 'Latur', 'India'),
		(1655, 'india/nanded', 'Nanded', 'India'),
		(1656, 'india/osmanabad', 'Osmanabad', 'India'),
		(1657, 'india/parbhani', 'Parbhani', 'India'),
		(1658, 'india/karjat', 'Karjat', 'India'),
		(1659, 'india/panvel', 'Panvel', 'India'),
		(1660, 'india/ratnagiri', 'Ratnagiri', 'India'),
		(1661, 'india/navi-mumbai', 'Navi Mumbai', 'India'),
		(1662, 'india/thane', 'Thane', 'India'),
		(1663, 'india/dhule', 'Dhule', 'India'),
		(1664, 'india/jalgaon', 'Jalgaon', 'India'),
		(1665, 'india/nandurbar', 'Nandurbar', 'India'),
		(1666, 'india/nashik', 'Nashik', 'India'),
		(1667, 'india/bhandara', 'Bhandara', 'India'),
		(1668, 'india/chandrapur', 'Chandrapur', 'India'),
		(1669, 'india/gadchiroli', 'Gadchiroli', 'India'),
		(1670, 'india/gondia', 'Gondia', 'India'),
		(1671, 'india/wardha', 'Wardha', 'India'),
		(1672, 'india/kolhapur', 'Kolhapur', 'India'),
		(1673, 'india/sangli', 'Sangli', 'India'),
		(1674, 'india/satara', 'Satara', 'India'),
		(1675, 'india/solapur', 'Solapur', 'India'),
		(1676, 'india/imphal', 'Imphal', 'India'),
		(1677, 'india/aizawl', 'Aizawl', 'India'),
		(1678, 'india/angul', 'Angul', 'India'),
		(1679, 'india/balangir', 'Balangir', 'India'),
		(1680, 'india/balasore', 'Balasore', 'India'),
		(1681, 'india/bargarh', 'Bargarh', 'India'),
		(1682, 'india/boudh', 'Boudh', 'India'),
		(1683, 'india/bhadrak', 'Bhadrak', 'India'),
		(1684, 'india/cuttack', 'Cuttack', 'India'),
		(1685, 'india/debagarh', 'Debagarh', 'India'),
		(1686, 'india/dhenkanal', 'Dhenkanal', 'India'),
		(1687, 'india/paralakhemundi', 'Paralakhemundi', 'India'),
		(1688, 'india/chhatrapur', 'Chhatrapur', 'India'),
		(1689, 'india/jagatsinghpur', 'Jagatsinghpur', 'India'),
		(1690, 'india/jharsuguda', 'Jharsuguda', 'India'),
		(1691, 'india/bhawanipatna', 'Bhawanipatna', 'India'),
		(1692, 'india/kendrapara', 'Kendrapara', 'India'),
		(1693, 'india/kendujhar', 'Kendujhar', 'India'),
		(1694, 'india/khordha', 'Khordha', 'India'),
		(1695, 'india/koraput', 'Koraput', 'India'),
		(1696, 'india/malkangiri', 'Malkangiri', 'India'),
		(1697, 'india/baripada', 'Baripada', 'India'),
		(1698, 'india/nabarangpur', 'Nabarangpur', 'India'),
		(1699, 'india/nayagarh', 'Nayagarh', 'India'),
		(1700, 'india/nuapada', 'Nuapada', 'India'),
		(1701, 'india/phulbani', 'Phulbani', 'India'),
		(1702, 'india/puri', 'Puri', 'India'),
		(1703, 'india/rayagada', 'Rayagada', 'India'),
		(1704, 'india/sambalpur', 'Sambalpur', 'India'),
		(1705, 'india/sonepur', 'Sonepur', 'India'),
		(1706, 'india/sundergarh', 'Sundergarh', 'India'),
		(1707, 'india/rourkela', 'Rourkela', 'India'),
		(1708, 'india/bhubaneswar', 'Bhubaneswar', 'India'),
		(1709, 'india/berhampur', 'Berhampur', 'India'),
		(1710, 'india/kohima', 'Kohima', 'India'),
		(1711, 'india/dimapur', 'Dimapur', 'India'),
		(1712, 'india/amritsar', 'Amritsar', 'India'),
		(1713, 'india/barnala', 'Barnala', 'India'),
		(1714, 'india/bathinda', 'Bathinda', 'India'),
		(1715, 'india/firozpur', 'Firozpur', 'India'),
		(1716, 'india/fatehgarh-sahib', 'Fatehgarh Sahib', 'India'),
		(1717, 'india/faridkot', 'Faridkot', 'India'),
		(1718, 'india/gurdaspur', 'Gurdaspur', 'India'),
		(1719, 'india/hoshiarpur', 'Hoshiarpur', 'India'),
		(1720, 'india/jalandhar', 'Jalandhar', 'India'),
		(1721, 'india/kapurthala', 'Kapurthala', 'India'),
		(1722, 'india/puducherry', 'Puducherry', 'India'),
		(1723, 'india/mansa', 'Mansa', 'India'),
		(1724, 'india/moga', 'Moga', 'India'),
		(1725, 'india/mohali', 'Mohali', 'India'),
		(1726, 'india/muktsar', 'Muktsar', 'India'),
		(1727, 'india/nawanshahr', 'Nawanshahr', 'India'),
		(1728, 'india/patiala', 'Patiala', 'India'),
		(1729, 'india/rupnagar', 'Rupnagar', 'India'),
		(1730, 'india/sangrur', 'Sangrur', 'India'),
		(1731, 'india/tarn-taran-sahib', 'Tarn Taran Sahib', 'India'),
		(1732, 'india/ajmer', 'Ajmer', 'India'),
		(1733, 'india/alwar', 'Alwar', 'India'),
		(1734, 'india/banswara', 'Banswara', 'India'),
		(1735, 'india/baran', 'Baran', 'India'),
		(1736, 'india/barmer', 'Barmer', 'India'),
		(1737, 'india/bharatpur', 'Bharatpur', 'India'),
		(1738, 'india/bhilwara', 'Bhilwara', 'India'),
		(1739, 'india/bikaner', 'Bikaner', 'India'),
		(1740, 'india/bundi', 'Bundi', 'India'),
		(1741, 'india/chittorgarh', 'Chittorgarh', 'India'),
		(1742, 'india/churu', 'Churu', 'India'),
		(1743, 'india/dausa', 'Dausa', 'India'),
		(1744, 'india/dholpur', 'Dholpur', 'India'),
		(1745, 'india/dungarpur', 'Dungarpur', 'India'),
		(1746, 'india/hanumangarh', 'Hanumangarh', 'India'),
		(1747, 'india/jaisalmer', 'Jaisalmer', 'India'),
		(1748, 'india/jalore', 'Jalore', 'India'),
		(1749, 'india/jhalawar', 'Jhalawar', 'India'),
		(1750, 'india/jhunjhunu', 'Jhunjhunu', 'India'),
		(1751, 'india/jodhpur', 'Jodhpur', 'India'),
		(1752, 'india/karauli', 'Karauli', 'India'),
		(1753, 'india/kota', 'Kota', 'India'),
		(1754, 'india/nagaur', 'Nagaur', 'India'),
		(1755, 'india/pali', 'Pali', 'India'),
		(1756, 'india/rajsamand', 'Rajsamand', 'India'),
		(1757, 'india/sawai-madhopur', 'Sawai Madhopur', 'India'),
		(1758, 'india/sikar', 'Sikar', 'India'),
		(1759, 'india/ganganagar', 'Ganganagar', 'India'),
		(1760, 'india/tonk', 'Tonk', 'India'),
		(1761, 'india/udaipur', 'Udaipur', 'India'),
		(1762, 'india/gangtok', 'Gangtok', 'India'),
		(1763, 'india/coimbatore', 'Coimbatore', 'India'),
		(1764, 'india/cuddalore', 'Cuddalore', 'India'),
		(1765, 'india/dharmapuri', 'Dharmapuri', 'India'),
		(1766, 'india/dindigul', 'Dindigul', 'India'),
		(1767, 'india/erode', 'Erode', 'India'),
		(1768, 'india/kanchipuram', 'Kanchipuram', 'India'),
		(1769, 'india/nagercoil', 'Nagercoil', 'India'),
		(1770, 'india/karur', 'Karur', 'India'),
		(1771, 'india/krishnagiri', 'Krishnagiri', 'India'),
		(1772, 'india/eluru', 'Eluru', 'India'),
		(1773, 'india/nagapattinam', 'Nagapattinam', 'India'),
		(1774, 'india/namakkal', 'Namakkal', 'India'),
		(1775, 'india/perambalur', 'Perambalur', 'India'),
		(1776, 'india/pudukkottai', 'Pudukkottai', 'India'),
		(1777, 'india/ramanathapuram', 'Ramanathapuram', 'India'),
		(1778, 'india/salem', 'Salem', 'India'),
		(1779, 'india/sivaganga', 'Sivaganga', 'India'),
		(1780, 'india/thanjavur', 'Thanjavur', 'India'),
		(1781, 'india/ootacamund', 'Ootacamund', 'India'),
		(1782, 'india/theni', 'Theni', 'India'),
		(1783, 'india/thoothukudi', 'Thoothukudi', 'India'),
		(1784, 'india/tiruchirapalli', 'Tiruchirapalli', 'India'),
		(1785, 'india/tirunelveli', 'Tirunelveli', 'India'),
		(1786, 'india/tiruvallur', 'Tiruvallur', 'India'),
		(1787, 'india/thiruvannaamalai', 'Thiruvannaamalai', 'India'),
		(1788, 'india/tiruvarur', 'Tiruvarur', 'India'),
		(1789, 'india/vellore', 'Vellore', 'India'),
		(1790, 'india/viluppuram', 'Viluppuram', 'India'),
		(1791, 'india/virudhunagar', 'Virudhunagar', 'India'),
		(1792, 'india/agartala', 'Agartala', 'India'),
		(1793, 'india/daman', 'Daman', 'India'),
		(1794, 'india/aligarh', 'Aligarh', 'India'),
		(1795, 'india/etah', 'Etah', 'India'),
		(1796, 'india/firozabad', 'Firozabad', 'India'),
		(1797, 'india/mainpuri', 'Mainpuri', 'India'),
		(1798, 'india/hathras', 'Hathras', 'India'),
		(1799, 'india/mathura', 'Mathura', 'India'),
		(1800, 'india/fatehpur', 'Fatehpur', 'India'),
		(1801, 'india/manjhanpur', 'Manjhanpur', 'India'),
		(1802, 'india/pratapgarh', 'Pratapgarh', 'India'),
		(1803, 'india/azamgarh', 'Azamgarh', 'India'),
		(1804, 'india/ballia', 'Ballia', 'India'),
		(1805, 'india/mau', 'Mau', 'India'),
		(1806, 'india/badaun', 'Badaun', 'India'),
		(1807, 'india/bareilly', 'Bareilly', 'India'),
		(1808, 'india/pilibhit', 'Pilibhit', 'India'),
		(1809, 'india/shahjahanpur', 'Shahjahanpur', 'India'),
		(1810, 'india/basti', 'Basti', 'India'),
		(1811, 'india/khalilabad', 'Khalilabad', 'India'),
		(1812, 'india/naugarh', 'Naugarh', 'India'),
		(1813, 'india/banda', 'Banda', 'India'),
		(1814, 'india/chitrakuta', 'Chitrakuta', 'India'),
		(1815, 'india/hamirpur', 'Hamirpur', 'India'),
		(1816, 'india/mahoba', 'Mahoba', 'India'),
		(1817, 'india/bahraich', 'Bahraich', 'India'),
		(1818, 'india/balrampur', 'Balrampur', 'India'),
		(1819, 'india/gonda', 'Gonda', 'India'),
		(1820, 'india/bhinga', 'Bhinga', 'India'),
		(1821, 'india/akbarpur-ambedkar', 'Akbarpur Ambedkar', 'India'),
		(1822, 'india/barabanki', 'Barabanki', 'India'),
		(1823, 'india/faizabad', 'Faizabad', 'India'),
		(1824, 'india/sultanpur', 'Sultanpur', 'India'),
		(1825, 'india/deoria', 'Deoria', 'India'),
		(1826, 'india/gorakhpur', 'Gorakhpur', 'India'),
		(1827, 'india/padrauna', 'Padrauna', 'India'),
		(1828, 'india/maharajganj', 'Maharajganj', 'India'),
		(1829, 'india/orai', 'Orai', 'India'),
		(1830, 'india/jhansi', 'Jhansi', 'India'),
		(1831, 'india/lalitpur', 'Lalitpur', 'India'),
		(1832, 'india/auraiya', 'Auraiya', 'India'),
		(1833, 'india/etawah', 'Etawah', 'India'),
		(1834, 'india/fatehgarh', 'Fatehgarh', 'India'),
		(1835, 'india/kannauj', 'Kannauj', 'India'),
		(1836, 'india/akbarpur-kanpur', 'Akbarpur Kanpur', 'India'),
		(1837, 'india/hardoi', 'Hardoi', 'India'),
		(1838, 'india/lakhimpur', 'Lakhimpur', 'India'),
		(1839, 'india/raebareli', 'Raebareli', 'India'),
		(1840, 'india/sitapur', 'Sitapur', 'India'),
		(1841, 'india/unnao', 'Unnao', 'India'),
		(1842, 'india/bagpat', 'Bagpat', 'India'),
		(1843, 'india/bulandshahr', 'Bulandshahr', 'India'),
		(1844, 'india/noida', 'Noida', 'India'),
		(1845, 'india/ghaziabad', 'Ghaziabad', 'India'),
		(1846, 'india/meerut', 'Meerut', 'India'),
		(1847, 'india/mirzapur', 'Mirzapur', 'India'),
		(1848, 'india/gyanpur', 'Gyanpur', 'India'),
		(1849, 'india/robertsganj', 'Robertsganj', 'India'),
		(1850, 'india/bijnor', 'Bijnor', 'India'),
		(1851, 'india/amroha', 'Amroha', 'India'),
		(1852, 'india/moradabad', 'Moradabad', 'India'),
		(1853, 'india/rampur', 'Rampur', 'India'),
		(1854, 'india/muzaffarnagar', 'Muzaffarnagar', 'India'),
		(1855, 'india/saharanpur', 'Saharanpur', 'India'),
		(1856, 'india/chandauli', 'Chandauli', 'India'),
		(1857, 'india/ghazipur', 'Ghazipur', 'India'),
		(1858, 'india/jaunpur', 'Jaunpur', 'India'),
		(1859, 'india/bhadrachalam', 'Bhadrachalam', 'India'),
		(1860, 'india/dehradun', 'Dehradun', 'India'),
		(1861, 'india/haridwar', 'Haridwar', 'India'),
		(1862, 'india/haldwani', 'Haldwani', 'India'),
		(1863, 'india/roorkee', 'Roorkee', 'India'),
		(1864, 'india/bankura', 'Bankura', 'India'),
		(1865, 'india/bardhaman', 'Bardhaman', 'India'),
		(1866, 'india/kulti', 'Kulti', 'India'),
		(1867, 'india/asansol', 'Asansol', 'India'),
		(1868, 'india/suri', 'Suri', 'India'),
		(1869, 'india/cooch-behar', 'Cooch Behar', 'India'),
		(1870, 'india/darjeeling', 'Darjeeling', 'India'),
		(1871, 'india/tamluk', 'Tamluk', 'India'),
		(1872, 'india/panskura', 'Panskura', 'India'),
		(1873, 'india/hugli-chuchura', 'Hugli Chuchura', 'India'),
		(1874, 'india/howrah', 'Howrah', 'India'),
		(1875, 'india/jalpaiguri', 'Jalpaiguri', 'India'),
		(1876, 'india/malda', 'Malda', 'India'),
		(1877, 'india/baharampur', 'Baharampur', 'India'),
		(1878, 'india/krishnanagar', 'Krishnanagar', 'India'),
		(1879, 'india/barasat', 'Barasat', 'India'),
		(1880, 'india/raiganj', 'Raiganj', 'India'),
		(1881, 'india/purulia', 'Purulia', 'India'),
		(1882, 'india/alipore', 'Alipore', 'India'),
		(1883, 'india/balurghat', 'Balurghat', 'India'),
		(1884, 'india/midnapore', 'Midnapore', 'India'),
		(1885, 'india/kharagpur', 'Kharagpur', 'India'),
		(1886, 'india/silvassa', 'Silvassa', 'India'),
		(1887, 'india/kavaratti', 'Kavaratti', 'India'),
		(1888, 'bolivia/sucre', 'Sucre', 'Bolivia'),
		(1889, 'austria/innsbruck', 'Innsbruck', 'Austria'),
		(1890, 'usa/midway', 'Midway', 'United States'),
		(1891, 'germany/ludwigsburg', 'Ludwigsburg', 'Germany'),
		(1892, 'india/thiruvananthapuram', 'Thiruvananthapuram', 'India'),
		(1893, 'usa/temple', 'Temple', 'United States'),
		(1894, 'india/kochi', 'Kochi', 'India'),
		(1895, 'india/kozhikode', 'Kozhikode', 'India'),
		(1896, 'india/kollam', 'Kollam', 'India'),
		(1897, 'india/thrissur', 'Thrissur', 'India'),
		(1898, 'india/alappuzha', 'Alappuzha', 'India'),
		(1899, 'india/palakkad', 'Palakkad', 'India'),
		(1900, 'india/thalassery', 'Thalassery', 'India'),
		(1901, 'india/ponnani', 'Ponnani', 'India'),
		(1902, 'india/kasaragod', 'Kasaragod', 'India'),
		(1903, 'india/kalpetta', 'Kalpetta', 'India'),
		(1904, 'india/painavu', 'Painavu', 'India'),
		(1905, 'india/kottayam', 'Kottayam', 'India'),
		(1906, 'india/pathanamthitta', 'Pathanamthitta', 'India'),
		(1907, 'russia/yakutsk', 'Yakutsk', 'Russia'),
		(1908, 'russia/nizhny-novgorod', 'Nizhny Novgorod', 'Russia'),
		(1909, 'russia/barnaul', 'Barnaul', 'Russia'),
		(1910, 'russia/ryazan', 'Ryazan', 'Russia'),
		(1911, 'russia/tyumen', 'Tyumen', 'Russia'),
		(1912, 'russia/naberezhnye-chelny', 'Naberezhnye Chelny', 'Russia'),
		(1913, 'russia/lipetsk', 'Lipetsk', 'Russia'),
		(1914, 'russia/astrakhan', 'Astrakhan', 'Russia'),
		(1915, 'russia/tomsk', 'Tomsk', 'Russia'),
		(1916, 'russia/kemerovo', 'Kemerovo', 'Russia'),
		(1917, 'russia/tula', 'Tula', 'Russia'),
		(1918, 'canada/qikiqtarjuaq', 'Qikiqtarjuaq', 'Canada'),
		(1919, 'argentina/neuquen', 'Neuquen', 'Argentina'),
		(1920, 'usa/rapid-city', 'Rapid City', 'United States'),
		(1921, 'usa/midland', 'Midland', 'United States'),
		(1922, 'canada/blanc-sablon', 'Blanc Sablon', 'Canada'),
		(1923, 'brazil/araguaina', 'Araguaina', 'Brazil'),
		(1924, 'brazil/palmas', 'Palmas', 'Brazil'),
		(1925, 'sri-lanka/sri-jayawardenapura-kotte', 'Sri Jayawardenapura Kotte', 'Sri Lanka'),
		(1926, 'greenland/ilulissat', 'Ilulissat', 'Greenland'),
		(1927, 'russia/cheboksary', 'Cheboksary', 'Russia'),
		(1928, 'usa/annapolis', 'Annapolis', 'United States'),
		(1929, 'india/shimla', 'Shimla', 'India'),
		(1930, 'china/hefei', 'Hefei', 'China'),
		(1931, 'china/lanzhou', 'Lanzhou', 'China'),
		(1932, 'china/haikou', 'Haikou', 'China'),
		(1933, 'china/nanning', 'Nanning', 'China'),
		(1934, 'china/nanjing', 'Nanjing', 'China'),
		(1935, 'china/shenyang', 'Shenyang', 'China'),
		(1936, 'china/hohhot', 'Hohhot', 'China'),
		(1937, 'china/yinchuan', 'Yinchuan', 'China'),
		(1938, 'china/xining', 'Xining', 'China'),
		(1939, 'angola/lubango', 'Lubango', 'Angola'),
		(1940, 'bangladesh/chandpur', 'Chandpur', 'Bangladesh'),
		(1941, 'cambodia/siem-reap', 'Siem Reap', 'Cambodia'),
		(1942, 'saudi-arabia/medina', 'Medina', 'Saudi Arabia'),
		(1943, 'iran/rasht', 'Rasht', 'Iran'),
		(1944, 'tanzania/arusha', 'Arusha', 'Tanzania'),
		(1945, 'usa/flagstaff', 'Flagstaff', 'United States'),
		(1946, 'vietnam/hai-phong', 'Hai Phong', 'Vietnam'),
		(1947, 'usa/fort-collins', 'Fort Collins', 'United States'),
		(1948, 'uk/canvey-island', 'Canvey Island', 'United Kingdom'),
		(1949, 'turkey/bursa', 'Bursa', 'Turkey'),
		(1950, 'syria/aleppo', 'Aleppo', 'Syria'),
		(1951, 'russia/arkhangelsk', 'Arkhangelsk', 'Russia'),
		(1952, 'philippines/davao', 'Davao', 'Philippines'),
		(1953, 'ukraine/kryvyi-rih', 'Kryvyi Rih', 'Ukraine'),
		(1954, 'kazakstan/atyrau', 'Atyrau', 'Kazakhstan'),
		(1955, 'thailand/chiang-mai', 'Chiang Mai', 'Thailand'),
		(1956, 'usa/sedona', 'Sedona', 'United States'),
		(1957, 'india/anantapur', 'Anantapur', 'India'),
		(1958, 'philippines/makati', 'Makati', 'Philippines'),
		(1959, 'argentina/bariloche', 'Bariloche', 'Argentina'),
		(1960, 'czech-republic/brno', 'Brno', 'Czech Republic'),
		(1961, 'chile/la-serena', 'La Serena', 'Chile'),
		(1962, 'croatia/dubrovnik', 'Dubrovnik', 'Croatia'),
		(1963, 'cyprus/famagusta', 'Famagusta', 'Cyprus'),
		(1964, 'ireland/limerick', 'Limerick', 'Ireland'),
		(1965, 'israel/safed', 'Safed', 'Israel'),
		(1966, 'japan/yokosuka', 'Yokosuka', 'Japan'),
		(1967, 'kazakstan/baikonur', 'Baikonur', 'Kazakhstan'),
		(1968, 'kazakstan/arkalyk', 'Arkalyk', 'Kazakhstan'),
		(1969, 'kenya/mombasa', 'Mombasa', 'Kenya'),
		(1970, 'malawi/zomba', 'Zomba', 'Malawi'),
		(1971, 'morocco/agadir', 'Agadir', 'Morocco'),
		(1972, 'nigeria/kaduna', 'Kaduna', 'Nigeria'),
		(1973, 'pakistan/rawalpindi', 'Rawalpindi', 'Pakistan'),
		(1974, 'philippines/bacolod', 'Bacolod', 'Philippines'),
		(1975, 'saudi-arabia/dammam', 'Dammam', 'Saudi Arabia'),
		(1976, 'spain/alicante', 'Alicante', 'Spain'),
		(1977, 'switzerland/lugano', 'Lugano', 'Switzerland'),
		(1978, 'benin/cotonou', 'Cotonou', 'Benin'),
		(1979, 'india/cherrapunji', 'Cherrapunji', 'India'),
		(1980, 'australia/eucla', 'Eucla', 'Australia'),
		(1981, 'myanmar/naypyidaw', 'Naypyidaw', 'Myanmar'),
		(1982, 'philippines/quezon', 'Quezon', 'Philippines'),
		(1983, 'australia/macquarie-island', 'Macquarie Island', 'Australia'),
		(1984, 'russia/sochi', 'Sochi', 'Russia'),
		(1985, 'south-georgia-sandwich/king-edward-point', 'King Edward Point', 'South Georgia/Sandwich Is.'),
		(1986, 'usa/fargo', 'Fargo', 'United States'),
		(1987, 'mexico/oaxaca', 'Oaxaca', 'Mexico'),
		(1988, 'russia/magnitogorsk', 'Magnitogorsk', 'Russia'),
		(1989, 'usa/lynchburg', 'Lynchburg', 'United States'),
		(1990, 'tanzania/zanzibar-city', 'Zanzibar City', 'Tanzania'),
		(1991, 'usa/olathe', 'Olathe', 'United States'),
		(1992, 'south-africa/rustenburg', 'Rustenburg', 'South Africa'),
		(1993, 'india/durgapur', 'Durgapur', 'India'),
		(1994, 'canada/kenora', 'Kenora', 'Canada'),
		(1995, 'usa/everett', 'Everett', 'United States'),
		(1996, 'morocco/marrakech', 'Marrakech', 'Morocco'),
		(1997, 'south-africa/stellenbosch', 'Stellenbosch', 'South Africa'),
		(1998, 'morocco/fes', 'Fes', 'Morocco'),
		(1999, 'ireland/galway', 'Galway', 'Ireland'),
		(2000, 'south-africa/thabazimbi', 'Thabazimbi', 'South Africa'),
		(2001, 'russia/vladimir', 'Vladimir', 'Russia'),
		(2002, 'russia/stavropol', 'Stavropol', 'Russia'),
		(2003, 'russia/surgut', 'Surgut', 'Russia'),
		(2004, 'china/xiamen', 'Xiamen', 'China'),
		(2005, 'usa/pembroke-pines', 'Pembroke Pines', 'United States'),
		(2006, 'iran/sanandaj', 'Sanandaj', 'Iran'),
		(2007, 'india/vedaranyam', 'Vedaranyam', 'India'),
		(2008, 'ukraine/kharkiv', 'Kharkiv', 'Ukraine'),
		(2009, 'germany/trier', 'Trier', 'Germany'),
		(2010, 'germany/jena', 'Jena', 'Germany'),
		(2011, 'germany/mulheim-ruhr', 'Mulheim Ruhr', 'Germany'),
		(2012, 'germany/gutersloh', 'Gutersloh', 'Germany'),
		(2013, 'germany/iserlohn', 'Iserlohn', 'Germany'),
		(2014, 'germany/duren', 'Duren', 'Germany'),
		(2015, 'germany/flensburg', 'Flensburg', 'Germany'),
		(2016, 'germany/dessau-rosslau', 'Dessau Rosslau', 'Germany'),
		(2017, 'germany/konstanz', 'Konstanz', 'Germany'),
		(2018, 'germany/villingen-schwenningen', 'Villingen Schwenningen', 'Germany'),
		(2019, 'germany/wilhelmshaven', 'Wilhelmshaven', 'Germany'),
		(2020, 'germany/marburg', 'Marburg', 'Germany'),
		(2021, 'spain/san-sebastian', 'San Sebastian', 'Spain'),
		(2022, 'malaysia/kuching', 'Kuching', 'Malaysia'),
		(2023, 'nigeria/benin-city', 'Benin City', 'Nigeria'),
		(2024, 'slovenia/maribor', 'Maribor', 'Slovenia'),
		(2025, 'slovenia/celje', 'Celje', 'Slovenia'),
		(2026, 'slovenia/kranj', 'Kranj', 'Slovenia'),
		(2027, 'india/mahesana', 'Mahesana', 'India'),
		(2028, 'mexico/la-paz', 'La Paz', 'Mexico'),
		(2029, 'mexico/cabo-san-lucas', 'Cabo San Lucas', 'Mexico'),
		(2030, 'nigeria/enugu', 'Enugu', 'Nigeria'),
		(2031, 'somalia/hargeisa', 'Hargeisa', 'Somalia'),
		(2032, 'india/veraval', 'Veraval', 'India'),
		(2033, 'uk/truro', 'Truro', 'United Kingdom'),
		(2034, 'iran/shiraz', 'Shiraz', 'Iran'),
		(2035, 'usa/pullman', 'Pullman', 'United States'),
		(2036, 'usa/bloomington', 'Bloomington', 'United States'),
		(2037, 'cuba/holguin', 'Holguin', 'Cuba'),
		(2038, 'usa/perth-amboy', 'Perth Amboy', 'United States'),
		(2039, 'honduras/tela', 'Tela', 'Honduras'),
		(2040, 'germany/neubrandenburg', 'Neubrandenburg', 'Germany'),
		(2041, 'austria/klagenfurt', 'Klagenfurt', 'Austria')";
		$sql4 = "INSERT INTO `".$wpdb->prefix."location` (`id`, `name`, `time_code`, `title`) VALUES
		(2042, 'uk/inverness', 'Inverness', 'United Kingdom'),
		(2043, 'malaysia/kota-kinabalu', 'Kota Kinabalu', 'Malaysia'),
		(2044, 'kenya/kisumu', 'Kisumu', 'Kenya'),
		(2045, 'honduras/roatan', 'Roatan', 'Honduras'),
		(2046, 'united-arab-emirates/fujairah', 'Fujairah', 'United Arab Emirates'),
		(2047, 'united-arab-emirates/umm-al-quwain', 'Umm Al Quwain', 'United Arab Emirates'),
		(2048, 'austria/villach', 'Villach', 'Austria'),
		(2049, 'austria/wels', 'Wels', 'Austria'),
		(2050, 'austria/st-polten', 'St Polten', 'Austria'),
		(2051, 'austria/dornbirn', 'Dornbirn', 'Austria'),
		(2052, 'austria/wiener-neustadt', 'Wiener Neustadt', 'Austria'),
		(2053, 'austria/steyr', 'Steyr', 'Austria'),
		(2054, 'austria/bregenz', 'Bregenz', 'Austria'),
		(2055, 'india/north-lakhimpur', 'North Lakhimpur', 'India'),
		(2056, 'austria/wolfsberg', 'Wolfsberg', 'Austria'),
		(2057, 'austria/leoben', 'Leoben', 'Austria'),
		(2058, 'austria/bischofshofen', 'Bischofshofen', 'Austria'),
		(2059, 'austria/krems', 'Krems', 'Austria'),
		(2060, 'austria/spittal-an-der-drau', 'Spittal An Der Drau', 'Austria'),
		(2061, 'austria/zwettl', 'Zwettl', 'Austria'),
		(2062, 'austria/amstetten', 'Amstetten', 'Austria'),
		(2063, 'austria/kapfenberg', 'Kapfenberg', 'Austria'),
		(2064, 'switzerland/baden', 'Baden', 'Switzerland'),
		(2065, 'usa/kalamazoo', 'Kalamazoo', 'United States'),
		(2066, 'pakistan/quetta', 'Quetta', 'Pakistan'),
		(2067, 'usa/binghamton', 'Binghamton', 'United States'),
		(2068, 'switzerland/thun', 'Thun', 'Switzerland'),
		(2069, 'switzerland/la-chaux-de-fonds', 'La Chaux De Fonds', 'Switzerland'),
		(2070, 'switzerland/fribourg', 'Fribourg', 'Switzerland'),
		(2071, 'switzerland/schaffhausen', 'Schaffhausen', 'Switzerland'),
		(2072, 'switzerland/chur', 'Chur', 'Switzerland'),
		(2073, 'switzerland/sion', 'Sion', 'Switzerland'),
		(2074, 'switzerland/st-moritz', 'St Moritz', 'Switzerland'),
		(2075, 'switzerland/davos', 'Davos', 'Switzerland'),
		(2076, 'switzerland/neuchatel', 'Neuchatel', 'Switzerland'),
		(2077, 'switzerland/airolo', 'Airolo', 'Switzerland'),
		(2078, 'germany/fulda', 'Fulda', 'Germany'),
		(2079, 'germany/landshut', 'Landshut', 'Germany'),
		(2080, 'italy/bolzano', 'Bolzano', 'Italy'),
		(2081, 'belgium/eupen', 'Eupen', 'Belgium'),
		(2082, 'luxembourg/esch-sur-alzette', 'Esch Sur Alzette', 'Luxembourg'),
		(2083, 'luxembourg/ettelbruck', 'Ettelbruck', 'Luxembourg'),
		(2084, 'germany/bayreuth', 'Bayreuth', 'Germany'),
		(2085, 'germany/frankfurt-oder', 'Frankfurt Oder', 'Germany'),
		(2086, 'germany/brandenburg-an-der-havel', 'Brandenburg An Der Havel', 'Germany'),
		(2087, 'germany/luneburg', 'Luneburg', 'Germany'),
		(2088, 'germany/rheine', 'Rheine', 'Germany'),
		(2089, 'germany/giessen', 'Giessen', 'Germany'),
		(2090, 'germany/homburg-saar', 'Homburg Saar', 'Germany'),
		(2091, 'australia/traralgon', 'Traralgon', 'Australia'),
		(2092, 'usa/wilmington', 'Wilmington', 'United States'),
		(2093, 'ireland/cork', 'Cork', 'Ireland'),
		(2094, 'new-zealand/tauranga', 'Tauranga', 'New Zealand'),
		(2095, 'new-zealand/palmerston-north', 'Palmerston North', 'New Zealand'),
		(2096, 'new-zealand/nelson', 'Nelson', 'New Zealand'),
		(2097, 'new-zealand/rotorua', 'Rotorua', 'New Zealand'),
		(2098, 'new-zealand/new-plymouth', 'New Plymouth', 'New Zealand'),
		(2099, 'new-zealand/whangarei', 'Whangarei', 'New Zealand'),
		(2100, 'new-zealand/greymouth', 'Greymouth', 'New Zealand'),
		(2101, 'new-zealand/taupo', 'Taupo', 'New Zealand'),
		(2102, 'new-zealand/wanganui', 'Wanganui', 'New Zealand'),
		(2103, 'new-zealand/gisborne', 'Gisborne', 'New Zealand'),
		(2104, 'usa/casper', 'Casper', 'United States'),
		(2105, 'new-zealand/queenstown', 'Queenstown', 'New Zealand'),
		(2106, 'canada/campbell-river', 'Campbell River', 'Canada'),
		(2107, 'canada/williams-lake', 'Williams Lake', 'Canada'),
		(2108, 'ukraine/zaporizhia', 'Zaporizhia', 'Ukraine'),
		(2109, 'usa/fort-smith', 'Fort Smith', 'United States'),
		(2110, 'bulgaria/burgas', 'Burgas', 'Bulgaria'),
		(2111, 'australia/mildura', 'Mildura', 'Australia'),
		(2112, 'mexico/tuxtla-gutierrez', 'Tuxtla Gutierrez', 'Mexico'),
		(2113, 'mexico/san-cristobal-de-las-casas', 'San Cristobal De Las Casas', 'Mexico'),
		(2114, 'greenland/danmarkshavn', 'Danmarkshavn', 'Greenland'),
		(2115, 'canada/prince-rupert', 'Prince Rupert', 'Canada'),
		(2116, 'canada/rouyn-noranda', 'Rouyn Noranda', 'Canada'),
		(2117, 'canada/prince-albert', 'Prince Albert', 'Canada'),
		(2118, 'usa/fayetteville', 'Fayetteville', 'United States'),
		(2119, 'usa/augusta-ga', 'Augusta Ga', 'United States'),
		(2120, 'indonesia/pontianak', 'Pontianak', 'Indonesia'),
		(2121, 'usa/columbus-ga', 'Columbus Ga', 'United States'),
		(2122, 'usa/port-st-lucie', 'Port St Lucie', 'United States'),
		(2123, 'usa/cape-coral', 'Cape Coral', 'United States'),
		(2124, 'uk/whitstable', 'Whitstable', 'United Kingdom'),
		(2125, 'uk/loughton', 'Loughton', 'United Kingdom'),
		(2126, 'usa/clarksville', 'Clarksville', 'United States'),
		(2127, 'usa/visalia', 'Visalia', 'United States'),
		(2128, 'usa/provo', 'Provo', 'United States'),
		(2129, 'uk/taunton', 'Taunton', 'United Kingdom'),
		(2130, 'morocco/el-jadida', 'El Jadida', 'Morocco'),
		(2131, 'usa/wake-island', 'Wake Island', 'United States'),
		(2132, 'usa/gainesville', 'Gainesville', 'United States'),
		(2133, 'usa/athens', 'Athens', 'United States'),
		(2134, 'usa/victorville', 'Victorville', 'United States'),
		(2135, 'pakistan/bahawalpur', 'Bahawalpur', 'Pakistan'),
		(2136, 'iceland/akureyri', 'Akureyri', 'Iceland'),
		(2137, 'india/gudalur-theni', 'Gudalur Theni', 'India'),
		(2138, 'germany/esslingen', 'Esslingen', 'Germany'),
		(2139, 'germany/ratingen', 'Ratingen', 'Germany'),
		(2140, 'germany/hanau', 'Hanau', 'Germany'),
		(2141, 'germany/marl', 'Marl', 'Germany'),
		(2142, 'germany/tuebingen', 'Tuebingen', 'Germany'),
		(2143, 'mexico/puerto-vallarta', 'Puerto Vallarta', 'Mexico'),
		(2144, 'brazil/pirassununga', 'Pirassununga', 'Brazil'),
		(2145, 'uk/caversham', 'Caversham', 'United Kingdom'),
		(2146, 'slovakia/prievidza', 'Prievidza', 'Slovakia'),
		(2147, 'usa/scranton', 'Scranton', 'United States'),
		(2148, 'china/suzhou', 'Suzhou', 'China'),
		(2149, 'germany/lunen', 'Lunen', 'Germany'),
		(2150, 'germany/velbert', 'Velbert', 'Germany'),
		(2151, 'germany/minden', 'Minden', 'Germany'),
		(2152, 'germany/worms', 'Worms', 'Germany'),
		(2153, 'germany/dorsten', 'Dorsten', 'Germany'),
		(2154, 'germany/neumunster', 'Neumunster', 'Germany'),
		(2155, 'japan/fukushima', 'Fukushima', 'Japan'),
		(2156, 'japan/minamisoma', 'Minamisoma', 'Japan'),
		(2157, 'usa/sarasota', 'Sarasota', 'United States'),
		(2158, 'uk/bangor', 'Bangor', 'United Kingdom'),
		(2159, 'usa/palm-springs', 'Palm Springs', 'United States'),
		(2160, 'brazil/criciuma', 'Criciuma', 'Brazil'),
		(2161, 'japan/niigata', 'Niigata', 'Japan'),
		(2162, 'japan/hamamatsu', 'Hamamatsu', 'Japan'),
		(2163, 'japan/shizuoka', 'Shizuoka', 'Japan'),
		(2164, 'japan/sagamihara', 'Sagamihara', 'Japan'),
		(2165, 'japan/kumamoto', 'Kumamoto', 'Japan'),
		(2166, 'japan/kagoshima', 'Kagoshima', 'Japan'),
		(2167, 'japan/himeji', 'Himeji', 'Japan'),
		(2168, 'japan/matsuyama', 'Matsuyama', 'Japan'),
		(2169, 'japan/utsunomiya', 'Utsunomiya', 'Japan'),
		(2170, 'portugal/portimao', 'Portimao', 'Portugal'),
		(2171, 'south-sudan/juba', 'Juba', 'South Sudan'),
		(2172, 'czech-republic/plzen', 'Plzen', 'Czech Republic'),
		(2173, 'india/nalbari', 'Nalbari', 'India'),
		(2174, 'palau/melekeok', 'Melekeok', 'Palau'),
		(2175, 'usa/french-lick', 'French Lick', 'United States'),
		(2176, 'germany/neunkirchen-saar', 'Neunkirchen Saar', 'Germany'),
		(2177, 'italy/verona', 'Verona', 'Italy'),
		(2178, 'libya/benghazi', 'Benghazi', 'Libya'),
		(2179, 'libya/misrata', 'Misrata', 'Libya'),
		(2180, 'uk/lerwick', 'Lerwick', 'United Kingdom'),
		(2181, 'uk/wakefield', 'Wakefield', 'United Kingdom'),
		(2182, 'usa/spartanburg', 'Spartanburg', 'United States'),
		(2183, 'syria/daraa', 'Daraa', 'Syria'),
		(2184, 'china/xinyang', 'Xinyang', 'China'),
		(2185, 'china/shantou', 'Shantou', 'China'),
		(2186, 'china/handan', 'Handan', 'China'),
		(2187, 'china/xuzhou', 'Xuzhou', 'China'),
		(2188, 'china/huainan', 'Huainan', 'China'),
		(2189, 'china/baoding', 'Baoding', 'China'),
		(2190, 'china/datong', 'Datong', 'China'),
		(2191, 'china/benxi', 'Benxi', 'China'),
		(2192, 'china/huaibei', 'Huaibei', 'China'),
		(2193, 'mexico/ciudad-juarez', 'Ciudad Juarez', 'Mexico'),
		(2194, 'italy/sassari', 'Sassari', 'Italy'),
		(2195, 'usa/kailua-kona', 'Kailua Kona', 'United States'),
		(2196, 'norway/haugesund', 'Haugesund', 'Norway'),
		(2197, 'norway/tonsberg', 'Tonsberg', 'Norway'),
		(2198, 'norway/alesund', 'Alesund', 'Norway'),
		(2199, 'norway/moss', 'Moss', 'Norway'),
		(2200, 'usa/hereford', 'Hereford', 'United States'),
		(2201, 'czech-republic/tabor', 'Tabor', 'Czech Republic'),
		(2202, 'czech-republic/ostrava', 'Ostrava', 'Czech Republic'),
		(2203, 'usa/loma-linda', 'Loma Linda', 'United States'),
		(2204, 'ethiopia/dire-dawa', 'Dire Dawa', 'Ethiopia'),
		(2205, 'norway/sandefjord', 'Sandefjord', 'Norway'),
		(2206, 'ireland/waterford', 'Waterford', 'Ireland'),
		(2207, 'ireland/dundalk', 'Dundalk', 'Ireland'),
		(2208, 'uk/londonderry', 'Londonderry', 'United Kingdom'),
		(2209, 'romania/iasi', 'Iasi', 'Romania'),
		(2210, 'romania/cluj-napoca', 'Cluj Napoca', 'Romania'),
		(2211, 'libya/sabha', 'Sabha', 'Libya'),
		(2212, 'libya/kufra', 'Kufra', 'Libya'),
		(2213, 'usa/corvallis', 'Corvallis', 'United States'),
		(2214, 'usa/bethesda', 'Bethesda', 'United States'),
		(2215, 'usa/west-palm-beach', 'West Palm Beach', 'United States'),
		(2216, 'thailand/chiang-rai', 'Chiang Rai', 'Thailand'),
		(2217, 'india/tadepalligudem', 'Tadepalligudem', 'India'),
		(2218, 'malaysia/kuantan', 'Kuantan', 'Malaysia'),
		(2219, 'colombia/pereira', 'Pereira', 'Colombia'),
		(2220, 'russia/ulan-ude', 'Ulan Ude', 'Russia'),
		(2221, 'uk/chester', 'Chester', 'United Kingdom'),
		(2222, 'usa/atlantic-city', 'Atlantic City', 'United States'),
		(2223, 'usa/grand-junction', 'Grand Junction', 'United States'),
		(2224, 'russia/syktyvkar', 'Syktyvkar', 'Russia'),
		(2225, 'india/mangalore', 'Mangalore', 'India'),
		(2226, 'iran/bandar-abbas', 'Bandar Abbas', 'Iran'),
		(2227, 'india/amalner', 'Amalner', 'India'),
		(2228, 'canada/fort-frances', 'Fort Frances', 'Canada'),
		(2229, 'U4/ramallah', 'Ramallah', 'West Bank'),
		(2230, 'india/porbandar', 'Porbandar', 'India'),
		(2231, 'sri-lanka/galle', 'Galle', 'Sri Lanka'),
		(2232, 'usa/naples', 'Naples', 'United States'),
		(2233, 'pakistan/abbottabad', 'Abbottabad', 'Pakistan'),
		(2234, 'italy/avellino', 'Avellino', 'Italy'),
		(2235, 'turkey/dalyan', 'Dalyan', 'Turkey'),
		(2236, 'india/gandhidham', 'Gandhidham', 'India'),
		(2237, 'usa/daytona-beach', 'Daytona Beach', 'United States'),
		(2238, 'turkey/gelibolu', 'Gelibolu', 'Turkey'),
		(2239, 'netherlands/kralendijk-bonaire', 'Kralendijk Bonaire', 'Netherlands'),
		(2240, 'norway/barentsburg', 'Barentsburg', 'Norway'),
		(2241, 'australia/blacktown', 'Blacktown', 'Australia'),
		(2242, 'australia/mosman', 'Mosman', 'Australia'),
		(2243, 'marshall-islands/kwajalein', 'Kwajalein', 'Marshall Islands'),
		(2244, 'canada/yorkton', 'Yorkton', 'Canada'),
		(2245, 'uk/cheltenham', 'Cheltenham', 'United Kingdom'),
		(2246, 'south-africa/grahamstown', 'Grahamstown', 'South Africa'),
		(2247, 'india/leh', 'Leh', 'India'),
		(2248, 'australia/samford', 'Samford', 'Australia'),
		(2249, 'uganda/entebbe', 'Entebbe', 'Uganda'),
		(2250, 'greece/kalamata', 'Kalamata', 'Greece'),
		(2251, 'sri-lanka/trincomalee', 'Trincomalee', 'Sri Lanka'),
		(2252, 'turkey/antalya', 'Antalya', 'Turkey'),
		(2253, 'uzbekistan/uchkuduk', 'Uchkuduk', 'Uzbekistan'),
		(2254, 'australia/broken-hill', 'Broken Hill', 'Australia'),
		(2255, 'ukraine/luhansk', 'Luhansk', 'Ukraine'),
		(2256, 'australia/geraldton', 'Geraldton', 'Australia'),
		(2257, 'australia/kalgoorlie', 'Kalgoorlie', 'Australia'),
		(2258, 'greece/igoumenitsa', 'Igoumenitsa', 'Greece'),
		(2259, 'greece/ioannina', 'Ioannina', 'Greece'),
		(2260, 'greece/naxos', 'Naxos', 'Greece'),
		(2261, 'croatia/zadar', 'Zadar', 'Croatia'),
		(2262, 'usa/osage-city', 'Osage City', 'United States'),
		(2263, 'usa/idaho-falls', 'Idaho Falls', 'United States'),
		(2264, 'mexico/playa-del-carmen', 'Playa Del Carmen', 'Mexico'),
		(2265, 'philippines/baguio-city', 'Baguio City', 'Philippines'),
		(2266, 'netherlands/montfoort', 'Montfoort', 'Netherlands'),
		(2267, 'iran/sari', 'Sari', 'Iran'),
		(2268, 'usa/freehold', 'Freehold', 'United States'),
		(2269, 'india/dwarka', 'Dwarka', 'India'),
		(2270, 'south-korea/gunsan', 'Gunsan', 'South Korea'),
		(2271, 'israel/acre', 'Acre', 'Israel'),
		(2272, 'bulgaria/varna', 'Varna', 'Bulgaria'),
		(2273, 'usa/cape-canaveral', 'Cape Canaveral', 'United States'),
		(2274, 'canada/creston', 'Creston', 'Canada'),
		(2275, 'usa/canton', 'Canton', 'United States'),
		(2276, 'spain/almeria', 'Almeria', 'Spain'),
		(2277, 'saudi-arabia/qatif', 'Qatif', 'Saudi Arabia'),
		(2278, 'usa/germantown', 'Germantown', 'United States'),
		(2279, 'uk/chichester', 'Chichester', 'United Kingdom'),
		(2280, 'philippines/angeles', 'Angeles', 'Philippines'),
		(2281, 'philippines/olongapo', 'Olongapo', 'Philippines'),
		(2282, 'australia/canterbury', 'Canterbury', 'Australia'),
		(2283, 'germany/wittenberge', 'Wittenberge', 'Germany'),
		(2284, 'usa/bryan-college-station', 'Bryan College Station', 'United States'),
		(2285, 'canada/high-level', 'High Level', 'Canada'),
		(2286, 'china/guilin', 'Guilin', 'China'),
		(2287, 'india/sihora-road', 'Sihora Road', 'India'),
		(2288, 'russia/bryansk', 'Bryansk', 'Russia'),
		(2289, 'usa/salina', 'Salina', 'United States'),
		(2290, 'usa/pocatello', 'Pocatello', 'United States'),
		(2291, 'pakistan/sahiwal', 'Sahiwal', 'Pakistan'),
		(2292, 'germany/nordkirchen', 'Nordkirchen', 'Germany'),
		(2293, 'usa/yuma', 'Yuma', 'United States'),
		(2294, 'belize/belize-city', 'Belize City', 'Belize'),
		(2295, 'usa/lihue', 'Lihue', 'United States'),
		(2296, 'usa/winder', 'Winder', 'United States'),
		(2297, 'india/jorhat', 'Jorhat', 'India'),
		(2298, 'australia/mudgee', 'Mudgee', 'Australia'),
		(2299, 'uk/bridlington', 'Bridlington', 'United Kingdom'),
		(2300, 'hungary/sopron', 'Sopron', 'Hungary'),
		(2301, 'india/dharamshala', 'Dharamshala', 'India'),
		(2302, 'bosnia-herzegovina/banja-luka', 'Banja Luka', 'Bosnia and Herzegovina'),
		(2303, 'usa/racine', 'Racine', 'United States'),
		(2304, 'indonesia/ubud', 'Ubud', 'Indonesia'),
		(2305, 'mongolia/tsomog', 'Tsomog', 'Mongolia'),
		(2306, 'usa/acworth', 'Acworth', 'United States'),
		(2307, 'india/fazilka', 'Fazilka', 'India'),
		(2308, 'uk/fort-william', 'Fort William', 'United Kingdom'),
		(2309, 'uk/stornoway', 'Stornoway', 'United Kingdom'),
		(2310, 'usa/kennebunk', 'Kennebunk', 'United States'),
		(2311, 'uk/weymouth', 'Weymouth', 'United Kingdom'),
		(2312, 'south-africa/nelspruit', 'Nelspruit', 'South Africa'),
		(2313, 'usa/manassas', 'Manassas', 'United States'),
		(2314, 'uk/hinckley', 'Hinckley', 'United Kingdom'),
		(2315, 'pakistan/sargodha', 'Sargodha', 'Pakistan'),
		(2316, 'argentina/rio-grande', 'Rio Grande', 'Argentina'),
		(2317, 'russia/mineralnye-vody', 'Mineralnye Vody', 'Russia'),
		(2318, 'dominican-republic/santiago-de-los-caballeros', 'Santiago De Los Caballeros', 'Dominican Republic'),
		(2319, 'denmark/skagen', 'Skagen', 'Denmark'),
		(2320, 'denmark/hirtshals', 'Hirtshals', 'Denmark'),
		(2321, 'uk/bury', 'Bury', 'United Kingdom'),
		(2322, 'spain/granada', 'Granada', 'Spain'),
		(2323, 'west-bank/nablus', 'Nablus', 'West Bank'),
		(2324, 'usa/babylon', 'Babylon', 'United States'),
		(2325, 'new-zealand/te-awamutu', 'Te Awamutu', 'New Zealand'),
		(2326, 'australia/broome', 'Broome', 'Australia'),
		(2327, 'australia/port-hedland', 'Port Hedland', 'Australia'),
		(2328, 'mali/timbuktu', 'Timbuktu', 'Mali'),
		(2329, 'canada/dawson-city', 'Dawson City', 'Canada'),
		(2330, 'bolivia/trinidad', 'Trinidad', 'Bolivia'),
		(2331, 'norway/kirkenes', 'Kirkenes', 'Norway'),
		(2332, 'norway/hammerfest', 'Hammerfest', 'Norway'),
		(2333, 'norway/narvik', 'Narvik', 'Norway'),
		(2334, 'norway/mo-i-rana', 'Mo I Rana', 'Norway'),
		(2335, 'norway/namsos', 'Namsos', 'Norway'),
		(2336, 'australia/tamworth', 'Tamworth', 'Australia'),
		(2337, 'spain/arrecife', 'Arrecife', 'Spain'),
		(2338, 'iran/bushehr', 'Bushehr', 'Iran'),
		(2339, 'russia/gelendzhik', 'Gelendzhik', 'Russia'),
		(2340, 'russia/khanty-mansiysk', 'Khanty Mansiysk', 'Russia'),
		(2341, 'usa/paradise-ca', 'Paradise Ca', 'United States'),
		(2342, 'usa/barnstable', 'Barnstable', 'United States'),
		(2343, 'usa/minot', 'Minot', 'United States'),
		(2344, 'spain/ceuta', 'Ceuta', 'Spain'),
		(2345, 'cameroon/douala', 'Douala', 'Cameroon'),
		(2346, 'canada/atikokan', 'Atikokan', 'Canada'),
		(2347, 'brazil/eirunepa', 'Eirunepa', 'Brazil'),
		(2348, 'mexico/matamoros', 'Matamoros', 'Mexico'),
		(2349, 'mexico/ojinaga', 'Ojinaga', 'Mexico'),
		(2350, 'brazil/santarem', 'Santarem', 'Brazil'),
		(2351, 'china/kashgar', 'Kashgar', 'China'),
		(2352, 'kazakhstan/oral', 'Oral', 'Kazakhstan'),
		(2353, 'nigeria/port-harcourt', 'Port Harcourt', 'Nigeria'),
		(2354, 'greece/corfu', 'Corfu', 'Greece'),
		(2355, 'russia/tura', 'Tura', 'Russia'),
		(2356, 'india/hisar', 'Hisar', 'India'),
		(2357, 'india/sirsa', 'Sirsa', 'India'),
		(2358, 'india/bijapur', 'Bijapur', 'India'),
		(2359, 'usa/bend', 'Bend', 'United States'),
		(2360, 'romania/targu-mures', 'Targu Mures', 'Romania'),
		(2361, 'philippines/marawi-city', 'Marawi City', 'Philippines'),
		(2362, 'mexico/fresnillo', 'Fresnillo', 'Mexico'),
		(2363, 'germany/bamberg', 'Bamberg', 'Germany'),
		(2364, 'west-bank/hebron', 'Hebron', 'West Bank'),
		(2365, 'malawi/blantyre', 'Blantyre', 'Malawi'),
		(2366, 'canada/glace-bay', 'Glace Bay', 'Canada'),
		(2367, 'usa/knox', 'Knox', 'United States'),
		(2368, 'usa/marengo', 'Marengo', 'United States'),
		(2369, 'usa/petersburg', 'Petersburg', 'United States'),
		(2370, 'usa/vevay', 'Vevay', 'United States'),
		(2371, 'usa/vincennes', 'Vincennes', 'United States'),
		(2372, 'usa/winamac', 'Winamac', 'United States'),
		(2373, 'usa/monticello', 'Monticello', 'United States'),
		(2374, 'usa/menominee', 'Menominee', 'United States'),
		(2375, 'canada/nipigon', 'Nipigon', 'Canada'),
		(2376, 'usa/center', 'Center', 'United States'),
		(2377, 'usa/new-salem', 'New Salem', 'United States'),
		(2378, 'canada/rainy-river', 'Rainy River', 'Canada'),
		(2379, 'kazakhstan/qyzylorda', 'Qyzylorda', 'Kazakhstan'),
		(2380, 'canada/resolute', 'Resolute', 'Canada'),
		(2381, 'canada/swift-current', 'Swift Current', 'Canada'),
		(2382, 'usa/yakutat', 'Yakutat', 'United States'),
		(2383, 'australia/currie', 'Currie', 'Australia'),
		(2384, 'australia/lindeman-island', 'Lindeman Island', 'Australia'),
		(2385, 'ukraine/uzhgorod', 'Uzhgorod', 'Ukraine'),
		(2386, 'iran/urmia', 'Urmia', 'Iran'),
		(2387, 'belgium/kortrijk', 'Kortrijk', 'Belgium'),
		(2388, 'india/mayiladuthurai', 'Mayiladuthurai', 'India'),
		(2389, 'australia/campbelltown', 'Campbelltown', 'Australia'),
		(2390, 'croatia/split', 'Split', 'Croatia'),
		(2391, 'canada/owen-sound', 'Owen Sound', 'Canada'),
		(2392, 'usa/provincetown', 'Provincetown', 'United States'),
		(2393, 'australia/armidale', 'Armidale', 'Australia'),
		(2394, 'norway/nannestad', 'Nannestad', 'Norway'),
		(2395, 'brazil/barra-do-garcas', 'Barra Do Garcas', 'Brazil'),
		(2396, 'colombia/villavicencio', 'Villavicencio', 'Colombia'),
		(2397, 'usa/myrtle-beach', 'Myrtle Beach', 'United States'),
		(2398, 'austria/kufstein', 'Kufstein', 'Austria'),
		(2399, 'philippines/iloilo-city', 'Iloilo City', 'Philippines'),
		(2400, 'usa/st-augustine', 'St Augustine', 'United States'),
		(2401, 'malaysia/miri', 'Miri', 'Malaysia'),
		(2402, 'japan/nagasaki', 'Nagasaki', 'Japan'),
		(2403, 'india/sirohi', 'Sirohi', 'India'),
		(2404, 'india/mount-abu', 'Mount Abu', 'India'),
		(2405, 'canada/milton', 'Milton', 'Canada'),
		(2406, 'usa/bridgewater', 'Bridgewater', 'United States'),
		(2407, 'zimbabwe/bulawayo', 'Bulawayo', 'Zimbabwe'),
		(2408, 'india/allahabad', 'Allahabad', 'India'),
		(2409, 'turkey/mersin', 'Mersin', 'Turkey'),
		(2410, 'nepal/pokhara', 'Pokhara', 'Nepal'),
		(2411, 'greece/alexandroupoli', 'Alexandroupoli', 'Greece'),
		(2412, 'usa/passaic', 'Passaic', 'United States'),
		(2413, 'uk/lichfield', 'Lichfield', 'United Kingdom'),
		(2414, 'romania/braila', 'Braila', 'Romania'),
		(2415, 'bulgaria/razgrad', 'Razgrad', 'Bulgaria'),
		(2416, 'usa/new-city', 'New City', 'United States'),
		(2417, 'usa/grand-island', 'Grand Island', 'United States'),
		(2418, 'israel/modiin-maccabim-reut', 'Modiin Maccabim Reut', 'Israel'),
		(2419, 'usa/warminster-township', 'Warminster Township', 'United States'),
		(2420, 'usa/glennallen', 'Glennallen', 'United States'),
		(2421, 'iran/kerman', 'Kerman', 'Iran'),
		(2422, 'uk/ely', 'Ely', 'United Kingdom'),
		(2423, 'germany/russelsheim', 'Russelsheim', 'Germany'),
		(2424, 'spain/mahon', 'Mahon', 'Spain'),
		(2425, 'usa/hudson', 'Hudson', 'United States'),
		(2426, 'usa/st-croix-falls', 'St Croix Falls', 'United States'),
		(2427, 'russia/grozny', 'Grozny', 'Russia'),
		(2428, 'usa/cocoa-beach', 'Cocoa Beach', 'United States'),
		(2429, 'new-zealand/blenheim', 'Blenheim', 'New Zealand'),
		(2430, 'russia/pyatigorsk', 'Pyatigorsk', 'Russia'),
		(2431, 'india/mandi-gobindgarh', 'Mandi Gobindgarh', 'India'),
		(2432, 'honduras/la-ceiba', 'La Ceiba', 'Honduras'),
		(2433, 'usa/oberlin', 'Oberlin', 'United States'),
		(2434, 'uk/canterbury', 'Canterbury', 'United Kingdom'),
		(2435, 'usa/decatur', 'Decatur', 'United States'),
		(2436, 'indonesia/manokwari', 'Manokwari', 'Indonesia'),
		(2437, 'russia/belushya-guba', 'Belushya Guba', 'Russia'),
		(2438, 'canada/chibougamau', 'Chibougamau', 'Canada'),
		(2439, 'russia/komsomolsk-on-amur', 'Komsomolsk On Amur', 'Russia'),
		(2440, 'usa/post-falls', 'Post Falls', 'United States'),
		(2441, 'china/foshan', 'Foshan', 'China'),
		(2442, 'germany/kaufbeuren', 'Kaufbeuren', 'Germany'),
		(2443, 'ecuador/cuenca', 'Cuenca', 'Ecuador'),
		(2444, 'mexico/ensenada', 'Ensenada', 'Mexico'),
		(2445, 'russia/salekhard', 'Salekhard', 'Russia'),
		(2446, 'mexico/manzanillo', 'Manzanillo', 'Mexico'),
		(2447, 'usa/bellingham', 'Bellingham', 'United States'),
		(2448, 'australia/albany', 'Albany', 'Australia'),
		(2449, 'india/gondal', 'Gondal', 'India'),
		(2450, 'romania/constanta', 'Constanta', 'Romania'),
		(2451, 'usa/paramus', 'Paramus', 'United States'),
		(2452, 'india/mysore', 'Mysore', 'India'),
		(2453, 'uruguay/maldonado', 'Maldonado', 'Uruguay'),
		(2454, 'uruguay/melo', 'Melo', 'Uruguay'),
		(2455, 'usa/alpena', 'Alpena', 'United States'),
		(2456, 'brazil/itumbiara', 'Itumbiara', 'Brazil'),
		(2457, 'india/rishra', 'Rishra', 'India'),
		(2458, 'india/hugli-chinsurah', 'Hugli Chinsurah', 'India'),
		(2459, 'sri-lanka/jaffna', 'Jaffna', 'Sri Lanka'),
		(2460, 'australia/dubbo', 'Dubbo', 'Australia'),
		(2461, 'australia/cobar', 'Cobar', 'Australia'),
		(2462, 'romania/brasov', 'Brasov', 'Romania'),
		(2463, 'usa/fort-bragg-ca', 'Fort Bragg Ca', 'United States'),
		(2464, 'usa/taylors', 'Taylors', 'United States'),
		(2465, 'usa/greenville', 'Greenville', 'United States'),
		(2466, 'usa/bristol', 'Bristol', 'United States'),
		(2467, 'usa/butte', 'Butte', 'United States'),
		(2468, 'usa/stillwater', 'Stillwater', 'United States'),
		(2469, 'thailand/sakon-nakhon', 'Sakon Nakhon', 'Thailand'),
		(2470, 'ukraine/khmelnytskyi', 'Khmelnytskyi', 'Ukraine'),
		(2471, 'haiti/labadee', 'Labadee', 'Haiti'),
		(2472, 'haiti/cap-haitien', 'Cap Haitien', 'Haiti'),
		(2473, 'usa/aliso-viejo', 'Aliso Viejo', 'United States'),
		(2474, 'equatorial-guinea/mongomo', 'Mongomo', 'Equatorial Guinea'),
		(2475, 'equatorial-guinea/bata', 'Bata', 'Equatorial Guinea'),
		(2476, 'greece/preveza', 'Preveza', 'Greece'),
		(2477, 'uk/bath', 'Bath', 'United Kingdom'),
		(2478, 'uk/newport-iow', 'Newport Iow', 'United Kingdom'),
		(2479, 'cyprus/kyrenia', 'Kyrenia', 'Cyprus'),
		(2480, 'pakistan/multan', 'Multan', 'Pakistan'),
		(2481, 'usa/mansfield', 'Mansfield', 'United States'),
		(2482, 'thailand/wanon-niwat', 'Wanon Niwat', 'Thailand'),
		(2483, 'uk/aylesbury', 'Aylesbury', 'United Kingdom'),
		(2484, 'usa/pasco', 'Pasco', 'United States'),
		(2485, 'usa/lawrence', 'Lawrence', 'United States'),
		(2486, 'thailand/na-thon-ko-samui', 'Na Thon Ko Samui', 'Thailand'),
		(2487, 'greece/lamia', 'Lamia', 'Greece'),
		(2488, 'sweden/lulea', 'Lulea', 'Sweden'),
		(2489, 'sweden/boden', 'Boden', 'Sweden'),
		(2490, 'sweden/kiruna', 'Kiruna', 'Sweden'),
		(2491, 'syria/homs', 'Homs', 'Syria'),
		(2492, 'south-korea/jeju', 'Jeju', 'South Korea'),
		(2493, 'uk/horsham', 'Horsham', 'United Kingdom'),
		(2494, 'usa/anderson', 'Anderson', 'United States'),
		(2495, 'mexico/colima', 'Colima', 'Mexico'),
		(2496, 'us-virgin/christiansted', 'Christiansted', 'US Virgin Islands'),
		(2497, 'us-virgin/cruz-bay', 'Cruz Bay', 'US Virgin Islands'),
		(2498, 'australia/wagga-wagga', 'Wagga Wagga', 'Australia'),
		(2499, 'usa/kodiak', 'Kodiak', 'United States'),
		(2500, 'italy/varese', 'Varese', 'Italy'),
		(2501, 'germany/boblingen', 'Boblingen', 'Germany'),
		(2502, 'costa-rica/limon', 'Limon', 'Costa Rica'),
		(2503, 'malaysia/langkawi', 'Langkawi', 'Malaysia'),
		(2504, 'ukraine/pavlograd', 'Pavlograd', 'Ukraine'),
		(2505, 'netherlands/hilversum', 'Hilversum', 'Netherlands'),
		(2506, 'costa-rica/liberia', 'Liberia', 'Costa Rica'),
		(2507, 'pakistan/chenab-nagar', 'Chenab Nagar', 'Pakistan'),
		(2508, 'usa/bowling-green', 'Bowling Green', 'United States'),
		(2509, 'usa/mason', 'Mason', 'United States'),
		(2510, 'azerbaijan/stepanakert', 'Stepanakert', 'Azerbaijan'),
		(2511, 'oman/nizwa', 'Nizwa', 'Oman'),
		(2512, 'zimbabwe/mutare', 'Mutare', 'Zimbabwe'),
		(2513, 'norway/alta', 'Alta', 'Norway'),
		(2514, 'norway/arendal', 'Arendal', 'Norway'),
		(2515, 'norway/asker', 'Asker', 'Norway'),
		(2516, 'norway/askim', 'Askim', 'Norway'),
		(2517, 'norway/kleppesto', 'Kleppesto', 'Norway'),
		(2518, 'norway/langesund', 'Langesund', 'Norway'),
		(2519, 'spain/melilla', 'Melilla', 'Spain'),
		(2520, 'italy/albenga', 'Albenga', 'Italy'),
		(2521, 'croatia/karlovac', 'Karlovac', 'Croatia'),
		(2522, 'norway/brandbu-jaren', 'Brandbu Jaren', 'Norway'),
		(2523, 'norway/brumunddal', 'Brumunddal', 'Norway'),
		(2524, 'norway/bryne', 'Bryne', 'Norway'),
		(2525, 'norway/bronnoysund', 'Bronnoysund', 'Norway'),
		(2526, 'norway/sandvika', 'Sandvika', 'Norway'),
		(2527, 'norway/drobak', 'Drobak', 'Norway'),
		(2528, 'norway/eidsvoll', 'Eidsvoll', 'Norway'),
		(2529, 'norway/egersund', 'Egersund', 'Norway'),
		(2530, 'indonesia/banda-aceh', 'Banda Aceh', 'Indonesia'),
		(2531, 'indonesia/pangkal-pinang', 'Pangkal Pinang', 'Indonesia'),
		(2532, 'norway/elverum', 'Elverum', 'Norway'),
		(2533, 'norway/fauske', 'Fauske', 'Norway'),
		(2534, 'norway/fetsund', 'Fetsund', 'Norway'),
		(2535, 'norway/fevik', 'Fevik', 'Norway'),
		(2536, 'norway/flekkefjord', 'Flekkefjord', 'Norway'),
		(2537, 'norway/floro', 'Floro', 'Norway'),
		(2538, 'norway/forde', 'Forde', 'Norway'),
		(2539, 'norway/aalgaard', 'Aalgaard', 'Norway'),
		(2540, 'norway/gjovik', 'Gjovik', 'Norway'),
		(2541, 'norway/grimstad', 'Grimstad', 'Norway'),
		(2542, 'norway/halden', 'Halden', 'Norway'),
		(2543, 'norway/hamar', 'Hamar', 'Norway'),
		(2544, 'norway/harstad', 'Harstad', 'Norway'),
		(2545, 'norway/holmestrand', 'Holmestrand', 'Norway'),
		(2546, 'norway/hommersaak', 'Hommersaak', 'Norway'),
		(2547, 'norway/horten', 'Horten', 'Norway'),
		(2548, 'norway/honefoss', 'Honefoss', 'Norway'),
		(2549, 'norway/indre-arna', 'Indre Arna', 'Norway'),
		(2550, 'norway/jessheim', 'Jessheim', 'Norway'),
		(2551, 'norway/jorpeland', 'Jorpeland', 'Norway'),
		(2552, 'norway/kopervik', 'Kopervik', 'Norway'),
		(2553, 'norway/kleppe', 'Kleppe', 'Norway'),
		(2554, 'norway/klofta', 'Klofta', 'Norway'),
		(2555, 'norway/knarrevik-straume', 'Knarrevik Straume', 'Norway'),
		(2556, 'norway/knarvik', 'Knarvik', 'Norway'),
		(2557, 'norway/kongsberg', 'Kongsberg', 'Norway'),
		(2558, 'norway/kongsvinger', 'Kongsvinger', 'Norway'),
		(2559, 'norway/kragero', 'Kragero', 'Norway'),
		(2560, 'norway/kristiansund', 'Kristiansund', 'Norway'),
		(2561, 'norway/kvernaland', 'Kvernaland', 'Norway'),
		(2562, 'norway/larvik', 'Larvik', 'Norway'),
		(2563, 'norway/leirvik', 'Leirvik', 'Norway'),
		(2564, 'norway/levanger', 'Levanger', 'Norway'),
		(2565, 'norway/lierbyen', 'Lierbyen', 'Norway'),
		(2566, 'norway/lillehammer', 'Lillehammer', 'Norway'),
		(2567, 'norway/lillesand', 'Lillesand', 'Norway'),
		(2568, 'norway/lorenskog', 'Lorenskog', 'Norway'),
		(2569, 'norway/hommelvik', 'Hommelvik', 'Norway'),
		(2570, 'norway/mandal', 'Mandal', 'Norway'),
		(2571, 'norway/melhus', 'Melhus', 'Norway'),
		(2572, 'norway/molde', 'Molde', 'Norway'),
		(2573, 'norway/mosjoen', 'Mosjoen', 'Norway'),
		(2574, 'norway/mysen', 'Mysen', 'Norway'),
		(2575, 'norway/mjondalen', 'Mjondalen', 'Norway'),
		(2576, 'norway/nesodden', 'Nesodden', 'Norway'),
		(2577, 'norway/rotnes', 'Rotnes', 'Norway'),
		(2578, 'norway/notodden', 'Notodden', 'Norway'),
		(2579, 'norway/naerbo', 'Naerbo', 'Norway'),
		(2580, 'norway/notteroy', 'Notteroy', 'Norway'),
		(2581, 'norway/odda', 'Odda', 'Norway'),
		(2582, 'norway/kolbotn', 'Kolbotn', 'Norway'),
		(2583, 'norway/orkanger-fannrem', 'Orkanger Fannrem', 'Norway'),
		(2584, 'norway/osoyro', 'Osoyro', 'Norway'),
		(2585, 'norway/porsgrunn', 'Porsgrunn', 'Norway'),
		(2586, 'norway/randaberg', 'Randaberg', 'Norway'),
		(2587, 'norway/raufoss', 'Raufoss', 'Norway'),
		(2588, 'norway/rygge', 'Rygge', 'Norway'),
		(2589, 'norway/fjerdingby', 'Fjerdingby', 'Norway'),
		(2590, 'norway/royken', 'Royken', 'Norway'),
		(2591, 'norway/raaholt', 'Raaholt', 'Norway'),
		(2592, 'norway/sandnessjoen', 'Sandnessjoen', 'Norway'),
		(2593, 'norway/lillestrom', 'Lillestrom', 'Norway'),
		(2594, 'norway/ski', 'Ski', 'Norway'),
		(2595, 'norway/sola', 'Sola', 'Norway'),
		(2596, 'norway/sortland', 'Sortland', 'Norway'),
		(2597, 'norway/spydeberg', 'Spydeberg', 'Norway'),
		(2598, 'norway/stange', 'Stange', 'Norway'),
		(2599, 'norway/stavern', 'Stavern', 'Norway'),
		(2600, 'norway/steinkjer', 'Steinkjer', 'Norway'),
		(2601, 'norway/stjordal', 'Stjordal', 'Norway'),
		(2602, 'norway/langevaag', 'Langevaag', 'Norway'),
		(2603, 'norway/sogne', 'Sogne', 'Norway'),
		(2604, 'norway/sorumsand', 'Sorumsand', 'Norway'),
		(2605, 'norway/tananger', 'Tananger', 'Norway'),
		(2606, 'norway/ulsteinvik', 'Ulsteinvik', 'Norway'),
		(2607, 'norway/vadso', 'Vadso', 'Norway'),
		(2608, 'norway/vennesla', 'Vennesla', 'Norway'),
		(2609, 'norway/verdalsora', 'Verdalsora', 'Norway'),
		(2610, 'norway/vestby', 'Vestby', 'Norway'),
		(2611, 'norway/volda', 'Volda', 'Norway'),
		(2612, 'norway/vossevangen', 'Vossevangen', 'Norway'),
		(2613, 'norway/orsta', 'Orsta', 'Norway'),
		(2614, 'norway/hokksund', 'Hokksund', 'Norway'),
		(2615, 'norway/aamot-geithus', 'Aamot Geithus', 'Norway'),
		(2616, 'norway/aas', 'Aas', 'Norway'),
		(2617, 'norway/finse', 'Finse', 'Norway'),
		(2618, 'norway/svolvaer', 'Svolvaer', 'Norway'),
		(2619, 'usa/angels-camp', 'Angels Camp', 'United States'),
		(2620, 'germany/luedenscheid', 'Luedenscheid', 'Germany'),
		(2621, 'germany/castrop-rauxel', 'Castrop Rauxel', 'Germany'),
		(2622, 'germany/troisdorf', 'Troisdorf', 'Germany'),
		(2623, 'germany/viersen', 'Viersen', 'Germany'),
		(2624, 'germany/gladbeck', 'Gladbeck', 'Germany'),
		(2625, 'germany/delmenhorst', 'Delmenhorst', 'Germany'),
		(2626, 'germany/arnsberg', 'Arnsberg', 'Germany'),
		(2627, 'germany/bocholt', 'Bocholt', 'Germany'),
		(2628, 'germany/detmold', 'Detmold', 'Germany'),
		(2629, 'germany/norderstedt', 'Norderstedt', 'Germany'),
		(2630, 'germany/celle', 'Celle', 'Germany'),
		(2631, 'germany/dinslaken', 'Dinslaken', 'Germany'),
		(2632, 'germany/aschaffenburg', 'Aschaffenburg', 'Germany'),
		(2633, 'germany/lippstadt', 'Lippstadt', 'Germany'),
		(2634, 'germany/unna', 'Unna', 'Germany'),
		(2635, 'germany/aalen', 'Aalen', 'Germany'),
		(2636, 'germany/plauen', 'Plauen', 'Germany'),
		(2637, 'germany/weimar', 'Weimar', 'Germany'),
		(2638, 'germany/kerpen', 'Kerpen', 'Germany'),
		(2639, 'germany/neuwied', 'Neuwied', 'Germany'),
		(2640, 'germany/herford', 'Herford', 'Germany'),
		(2641, 'germany/grevenbroich', 'Grevenbroich', 'Germany'),
		(2642, 'germany/dormagen', 'Dormagen', 'Germany'),
		(2643, 'germany/herten', 'Herten', 'Germany'),
		(2644, 'indonesia/serang', 'Serang', 'Indonesia'),
		(2645, 'indonesia/bengkulu', 'Bengkulu', 'Indonesia'),
		(2646, 'indonesia/palangkaraya', 'Palangkaraya', 'Indonesia'),
		(2647, 'indonesia/palu', 'Palu', 'Indonesia'),
		(2648, 'indonesia/gorontalo', 'Gorontalo', 'Indonesia'),
		(2649, 'indonesia/sofifi', 'Sofifi', 'Indonesia'),
		(2650, 'indonesia/tanjung-pinang', 'Tanjung Pinang', 'Indonesia'),
		(2651, 'indonesia/kendari', 'Kendari', 'Indonesia'),
		(2652, 'indonesia/mamuju', 'Mamuju', 'Indonesia'),
		(2653, 'germany/bergheim', 'Bergheim', 'Germany'),
		(2654, 'germany/kempten', 'Kempten', 'Germany'),
		(2655, 'germany/garbsen', 'Garbsen', 'Germany'),
		(2656, 'germany/rosenheim', 'Rosenheim', 'Germany'),
		(2657, 'germany/wesel', 'Wesel', 'Germany'),
		(2658, 'germany/sindelfingen', 'Sindelfingen', 'Germany'),
		(2659, 'germany/schwaebisch-gmuend', 'Schwaebisch Gmuend', 'Germany'),
		(2660, 'germany/offenburg', 'Offenburg', 'Germany'),
		(2661, 'germany/langenfeld-rheinland', 'Langenfeld Rheinland', 'Germany'),
		(2662, 'germany/friedrichshafen', 'Friedrichshafen', 'Germany'),
		(2663, 'germany/huerth', 'Huerth', 'Germany'),
		(2664, 'germany/hameln', 'Hameln', 'Germany'),
		(2665, 'germany/stralsund', 'Stralsund', 'Germany'),
		(2666, 'germany/stolberg-rheinland', 'Stolberg Rheinland', 'Germany'),
		(2667, 'germany/goeppingen', 'Goeppingen', 'Germany'),
		(2668, 'germany/euskirchen', 'Euskirchen', 'Germany'),
		(2669, 'germany/goerlitz', 'Goerlitz', 'Germany'),
		(2670, 'germany/hattingen', 'Hattingen', 'Germany'),
		(2671, 'germany/eschweiler', 'Eschweiler', 'Germany'),
		(2672, 'germany/menden-sauerland', 'Menden Sauerland', 'Germany'),
		(2673, 'germany/sankt-augustin', 'Sankt Augustin', 'Germany'),
		(2674, 'germany/hilden', 'Hilden', 'Germany'),
		(2675, 'germany/greifswald', 'Greifswald', 'Germany'),
		(2676, 'germany/baden-baden', 'Baden Baden', 'Germany'),
		(2677, 'germany/meerbusch', 'Meerbusch', 'Germany'),
		(2678, 'germany/bad-salzuflen', 'Bad Salzuflen', 'Germany'),
		(2679, 'germany/pulheim', 'Pulheim', 'Germany'),
		(2680, 'germany/neu-ulm', 'Neu Ulm', 'Germany'),
		(2681, 'germany/wolfenbuettel', 'Wolfenbuettel', 'Germany'),
		(2682, 'germany/schweinfurt', 'Schweinfurt', 'Germany'),
		(2683, 'germany/ahlen', 'Ahlen', 'Germany'),
		(2684, 'germany/nordhorn', 'Nordhorn', 'Germany'),
		(2685, 'germany/waiblingen', 'Waiblingen', 'Germany'),
		(2686, 'germany/neustadt-an-der-weinstrasse', 'Neustadt An Der Weinstrasse', 'Germany'),
		(2687, 'germany/langenhagen', 'Langenhagen', 'Germany'),
		(2688, 'germany/bad-homburg', 'Bad Homburg', 'Germany'),
		(2689, 'germany/willich', 'Willich', 'Germany'),
		(2690, 'germany/emden', 'Emden', 'Germany'),
		(2691, 'germany/ibbenbueren', 'Ibbenbueren', 'Germany'),
		(2692, 'germany/wetzlar', 'Wetzlar', 'Germany'),
		(2693, 'germany/gummersbach', 'Gummersbach', 'Germany'),
		(2694, 'germany/lingen-ems', 'Lingen Ems', 'Germany'),
		(2695, 'germany/passau', 'Passau', 'Germany'),
		(2696, 'germany/bergkamen', 'Bergkamen', 'Germany'),
		(2697, 'germany/erftstadt', 'Erftstadt', 'Germany'),
		(2698, 'germany/cuxhaven', 'Cuxhaven', 'Germany'),
		(2699, 'australia/bairnsdale', 'Bairnsdale', 'Australia'),
		(2700, 'germany/frechen', 'Frechen', 'Germany'),
		(2701, 'germany/speyer', 'Speyer', 'Germany'),
		(2702, 'germany/ravensburg', 'Ravensburg', 'Germany'),
		(2703, 'germany/wittenberg', 'Wittenberg', 'Germany'),
		(2704, 'germany/kleve', 'Kleve', 'Germany'),
		(2705, 'germany/elmshorn', 'Elmshorn', 'Germany'),
		(2706, 'germany/peine', 'Peine', 'Germany'),
		(2707, 'germany/soest', 'Soest', 'Germany'),
		(2708, 'germany/bornheim', 'Bornheim', 'Germany'),
		(2709, 'germany/loerrach', 'Loerrach', 'Germany'),
		(2710, 'germany/bad-oeynhausen', 'Bad Oeynhausen', 'Germany'),
		(2711, 'germany/schwerte', 'Schwerte', 'Germany'),
		(2712, 'germany/heidenheim-an-der-brenz', 'Heidenheim An Der Brenz', 'Germany'),
		(2713, 'germany/rastatt', 'Rastatt', 'Germany'),
		(2714, 'germany/rheda-wiedenbrueck', 'Rheda Wiedenbrueck', 'Germany'),
		(2715, 'germany/frankenthal-pfalz', 'Frankenthal Pfalz', 'Germany'),
		(2716, 'germany/duelmen', 'Duelmen', 'Germany'),
		(2717, 'germany/herzogenrath', 'Herzogenrath', 'Germany'),
		(2718, 'austria/eisenstadt', 'Eisenstadt', 'Austria'),
		(2719, 'austria/feldkirch', 'Feldkirch', 'Austria'),
		(2720, 'austria/klosterneuburg', 'Klosterneuburg', 'Austria'),
		(2721, 'austria/leonding', 'Leonding', 'Austria'),
		(2722, 'austria/baden', 'Baden', 'Austria'),
		(2723, 'austria/traun', 'Traun', 'Austria'),
		(2724, 'austria/lustenau', 'Lustenau', 'Austria'),
		(2725, 'austria/moedling', 'Moedling', 'Austria'),
		(2726, 'austria/hallein', 'Hallein', 'Austria'),
		(2727, 'austria/traiskirchen', 'Traiskirchen', 'Austria'),
		(2728, 'austria/schwechat', 'Schwechat', 'Austria'),
		(2729, 'austria/braunau-am-inn', 'Braunau Am Inn', 'Austria'),
		(2730, 'austria/saalfelden-am-steinernen-meer', 'Saalfelden Am Steinernen Meer', 'Austria'),
		(2731, 'austria/ansfelden', 'Ansfelden', 'Austria'),
		(2732, 'austria/stockerau', 'Stockerau', 'Austria'),
		(2733, 'austria/hohenems', 'Hohenems', 'Austria'),
		(2734, 'austria/tulln-an-der-donau', 'Tulln An Der Donau', 'Austria'),
		(2735, 'austria/ternitz', 'Ternitz', 'Austria'),
		(2736, 'austria/telfs', 'Telfs', 'Austria'),
		(2737, 'india/raisinghnagar', 'Raisinghnagar', 'India'),
		(2738, 'austria/perchtoldsdorf', 'Perchtoldsdorf', 'Austria'),
		(2739, 'austria/feldkirchen-in-kaernten', 'Feldkirchen In Kaernten', 'Austria'),
		(2740, 'austria/bad-ischl', 'Bad Ischl', 'Austria'),
		(2741, 'austria/bludenz', 'Bludenz', 'Austria'),
		(2742, 'austria/gmunden', 'Gmunden', 'Austria'),
		(2743, 'austria/schwaz', 'Schwaz', 'Austria'),
		(2744, 'austria/bruck-an-der-mur', 'Bruck An Der Mur', 'Austria'),
		(2745, 'austria/st-veit-an-der-glan', 'St Veit An Der Glan', 'Austria'),
		(2746, 'austria/hall-in-tirol', 'Hall In Tirol', 'Austria'),
		(2747, 'austria/woergl', 'Woergl', 'Austria'),
		(2748, 'austria/hard', 'Hard', 'Austria'),
		(2749, 'austria/neunkirchen', 'Neunkirchen', 'Austria'),
		(2750, 'switzerland/koeniz', 'Koeniz', 'Switzerland'),
		(2751, 'switzerland/vernier', 'Vernier', 'Switzerland'),
		(2752, 'switzerland/uster', 'Uster', 'Switzerland'),
		(2753, 'switzerland/lancy', 'Lancy', 'Switzerland'),
		(2754, 'switzerland/emmen', 'Emmen', 'Switzerland'),
		(2755, 'switzerland/yverdon-les-bains', 'Yverdon Les Bains', 'Switzerland'),
		(2756, 'switzerland/zug', 'Zug', 'Switzerland'),
		(2757, 'germany/gronau-westfalen', 'Gronau Westfalen', 'Germany'),
		(2758, 'germany/hof-saale', 'Hof Saale', 'Germany'),
		(2759, 'germany/stade', 'Stade', 'Germany'),
		(2760, 'germany/melle', 'Melle', 'Germany'),
		(2761, 'germany/hennef-sieg', 'Hennef Sieg', 'Germany'),
		(2762, 'germany/erkrath', 'Erkrath', 'Germany'),
		(2763, 'germany/singen-hohentwiel', 'Singen Hohentwiel', 'Germany'),
		(2764, 'germany/gotha', 'Gotha', 'Germany'),
		(2765, 'germany/alsdorf', 'Alsdorf', 'Germany'),
		(2766, 'germany/freising', 'Freising', 'Germany'),
		(2767, 'germany/bitterfeld-wolfen', 'Bitterfeld Wolfen', 'Germany'),
		(2768, 'germany/leonberg', 'Leonberg', 'Germany'),
		(2769, 'germany/neustadt-am-ruebenberge', 'Neustadt Am Ruebenberge', 'Germany'),
		(2770, 'usa/port-angeles', 'Port Angeles', 'United States'),
		(2771, 'germany/albstadt', 'Albstadt', 'Germany'),
		(2772, 'germany/buende', 'Buende', 'Germany'),
		(2773, 'germany/fellbach', 'Fellbach', 'Germany'),
		(2774, 'germany/erkelenz', 'Erkelenz', 'Germany'),
		(2775, 'germany/straubing', 'Straubing', 'Germany'),
		(2776, 'germany/kamen', 'Kamen', 'Germany'),
		(2777, 'germany/wismar', 'Wismar', 'Germany'),
		(2778, 'germany/filderstadt', 'Filderstadt', 'Germany'),
		(2779, 'germany/nordhausen', 'Nordhausen', 'Germany'),
		(2780, 'germany/bruehl-rheinland', 'Bruehl Rheinland', 'Germany'),
		(2781, 'germany/lahr-schwarzwald', 'Lahr Schwarzwald', 'Germany'),
		(2782, 'germany/amberg', 'Amberg', 'Germany'),
		(2783, 'germany/oberursel-taunus', 'Oberursel Taunus', 'Germany'),
		(2784, 'germany/witzenhausen', 'Witzenhausen', 'Germany'),
		(2785, 'germany/bad-kreuznach', 'Bad Kreuznach', 'Germany'),
		(2786, 'germany/weinheim', 'Weinheim', 'Germany'),
		(2787, 'germany/landau-in-der-pfalz', 'Landau In Der Pfalz', 'Germany'),
		(2788, 'germany/rodgau', 'Rodgau', 'Germany'),
		(2789, 'germany/lehrte', 'Lehrte', 'Germany'),
		(2790, 'germany/bruchsal', 'Bruchsal', 'Germany'),
		(2791, 'germany/monheim-am-rhein', 'Monheim Am Rhein', 'Germany'),
		(2792, 'germany/bietigheim-bissingen', 'Bietigheim Bissingen', 'Germany'),
		(2793, 'germany/eisenach', 'Eisenach', 'Germany'),
		(2794, 'germany/halberstadt', 'Halberstadt', 'Germany'),
		(2795, 'germany/pinneberg', 'Pinneberg', 'Germany'),
		(2796, 'germany/dachau', 'Dachau', 'Germany'),
		(2797, 'germany/rottenburg-am-neckar', 'Rottenburg Am Neckar', 'Germany'),
		(2798, 'germany/stendal', 'Stendal', 'Germany'),
		(2799, 'germany/seevetal', 'Seevetal', 'Germany'),
		(2800, 'germany/kaarst', 'Kaarst', 'Germany'),
		(2801, 'germany/weiden-in-der-oberpfalz', 'Weiden In Der Oberpfalz', 'Germany'),
		(2802, 'germany/oranienburg', 'Oranienburg', 'Germany'),
		(2803, 'germany/nettetal', 'Nettetal', 'Germany'),
		(2804, 'germany/gifhorn', 'Gifhorn', 'Germany'),
		(2805, 'germany/weissenfels', 'Weissenfels', 'Germany'),
		(2806, 'germany/lemgo', 'Lemgo', 'Germany'),
		(2807, 'germany/freiberg', 'Freiberg', 'Germany'),
		(2808, 'germany/borken', 'Borken', 'Germany'),
		(2809, 'germany/coburg', 'Coburg', 'Germany'),
		(2810, 'germany/memmingen', 'Memmingen', 'Germany'),
		(2811, 'germany/wunstorf', 'Wunstorf', 'Germany'),
		(2812, 'germany/goslar', 'Goslar', 'Germany'),
		(2813, 'germany/eberswalde', 'Eberswalde', 'Germany'),
		(2814, 'germany/koenigswinter', 'Koenigswinter', 'Germany'),
		(2815, 'germany/heinsberg', 'Heinsberg', 'Germany'),
		(2816, 'germany/bautzen', 'Bautzen', 'Germany'),
		(2817, 'germany/aurich', 'Aurich', 'Germany'),
		(2818, 'germany/falkensee', 'Falkensee', 'Germany'),
		(2819, 'germany/dreieich', 'Dreieich', 'Germany'),
		(2820, 'germany/pirmasens', 'Pirmasens', 'Germany'),
		(2821, 'germany/nuertingen', 'Nuertingen', 'Germany'),
		(2822, 'germany/laatzen', 'Laatzen', 'Germany'),
		(2823, 'germany/ansbach', 'Ansbach', 'Germany'),
		(2824, 'germany/loehne', 'Loehne', 'Germany'),
		(2825, 'germany/kirchheim-unter-teck', 'Kirchheim Unter Teck', 'Germany'),
		(2826, 'germany/buxtehude', 'Buxtehude', 'Germany'),
		(2827, 'germany/siegburg', 'Siegburg', 'Germany'),
		(2828, 'germany/bensheim', 'Bensheim', 'Germany'),
		(2829, 'germany/voelklingen', 'Voelklingen', 'Germany'),
		(2830, 'germany/mettmann', 'Mettmann', 'Germany'),
		(2831, 'germany/freital', 'Freital', 'Germany'),
		(2832, 'germany/schorndorf', 'Schorndorf', 'Germany'),
		(2833, 'germany/hueckelhoven', 'Hueckelhoven', 'Germany'),
		(2834, 'germany/neumarkt-in-der-oberpfalz', 'Neumarkt In Der Oberpfalz', 'Germany'),
		(2835, 'germany/ahaus', 'Ahaus', 'Germany'),
		(2836, 'germany/schwabach', 'Schwabach', 'Germany'),
		(2837, 'germany/suhl', 'Suhl', 'Germany'),
		(2838, 'germany/buchholz-in-der-nordheide', 'Buchholz In Der Nordheide', 'Germany'),
		(2839, 'germany/pirna', 'Pirna', 'Germany'),
		(2840, 'germany/ettlingen', 'Ettlingen', 'Germany'),
		(2841, 'germany/kamp-lintfort', 'Kamp Lintfort', 'Germany'),
		(2842, 'germany/hofheim-am-taunus', 'Hofheim Am Taunus', 'Germany'),
		(2843, 'germany/warendorf', 'Warendorf', 'Germany'),
		(2844, 'germany/maintal', 'Maintal', 'Germany'),
		(2845, 'germany/germering', 'Germering', 'Germany'),
		(2846, 'germany/haltern-am-see', 'Haltern Am See', 'Germany'),
		(2847, 'germany/hemer', 'Hemer', 'Germany'),
		(2848, 'germany/wuerselen', 'Wuerselen', 'Germany'),
		(2849, 'germany/niederkassel', 'Niederkassel', 'Germany'),
		(2850, 'germany/voerde-niederrhein', 'Voerde Niederrhein', 'Germany'),
		(2851, 'germany/hoyerswerda', 'Hoyerswerda', 'Germany'),
		(2852, 'germany/leinfelden-echterdingen', 'Leinfelden Echterdingen', 'Germany'),
		(2853, 'germany/sankt-ingbert', 'Sankt Ingbert', 'Germany'),
		(2854, 'germany/schwaebisch-hall', 'Schwaebisch Hall', 'Germany'),
		(2855, 'mexico/chetumal', 'Chetumal', 'Mexico'),
		(2856, 'germany/saarlouis', 'Saarlouis', 'Germany'),
		(2857, 'germany/beckum', 'Beckum', 'Germany'),
		(2858, 'germany/coesfeld', 'Coesfeld', 'Germany'),
		(2859, 'germany/bernau-bei-berlin', 'Bernau Bei Berlin', 'Germany'),
		(2860, 'germany/ostfildern', 'Ostfildern', 'Germany'),
		(2861, 'germany/greven', 'Greven', 'Germany'),
		(2862, 'germany/neu-isenburg', 'Neu Isenburg', 'Germany'),
		(2863, 'germany/muehlhausen-thueringen', 'Muehlhausen Thueringen', 'Germany'),
		(2864, 'india/jagraon', 'Jagraon', 'India'),
		(2865, 'bangladesh/dinajpur', 'Dinajpur', 'Bangladesh'),
		(2866, 'germany/kempen', 'Kempen', 'Germany'),
		(2867, 'germany/langen', 'Langen', 'Germany'),
		(2868, 'germany/emsdetten', 'Emsdetten', 'Germany'),
		(2869, 'germany/bernburg-saale', 'Bernburg Saale', 'Germany'),
		(2870, 'germany/datteln', 'Datteln', 'Germany'),
		(2871, 'germany/wermelskirchen', 'Wermelskirchen', 'Germany'),
		(2872, 'germany/merseburg', 'Merseburg', 'Germany'),
		(2873, 'germany/backnang', 'Backnang', 'Germany'),
		(2874, 'germany/sinsheim', 'Sinsheim', 'Germany'),
		(2875, 'germany/lage', 'Lage', 'Germany'),
		(2876, 'germany/porta-westfalica', 'Porta Westfalica', 'Germany'),
		(2877, 'germany/wesseling', 'Wesseling', 'Germany'),
		(2878, 'germany/papenburg', 'Papenburg', 'Germany'),
		(2879, 'germany/altenburg', 'Altenburg', 'Germany'),
		(2880, 'germany/meppen', 'Meppen', 'Germany'),
		(2881, 'germany/kehl', 'Kehl', 'Germany'),
		(2882, 'germany/erding', 'Erding', 'Germany'),
		(2883, 'germany/wernigerode', 'Wernigerode', 'Germany'),
		(2884, 'germany/leer', 'Leer', 'Germany'),
		(2885, 'germany/naumburg-saale', 'Naumburg Saale', 'Germany'),
		(2886, 'germany/tuttlingen', 'Tuttlingen', 'Germany'),
		(2887, 'germany/uelzen', 'Uelzen', 'Germany'),
		(2888, 'germany/winsen-luhe', 'Winsen Luhe', 'Germany'),
		(2889, 'germany/fuerstenfeldbruck', 'Fuerstenfeldbruck', 'Germany'),
		(2890, 'germany/goch', 'Goch', 'Germany'),
		(2891, 'germany/moerfelden-walldorf', 'Moerfelden Walldorf', 'Germany'),
		(2892, 'germany/schwedt-oder', 'Schwedt Oder', 'Germany'),
		(2893, 'germany/riesa', 'Riesa', 'Germany'),
		(2894, 'germany/koenigs-wusterhausen', 'Koenigs Wusterhausen', 'Germany'),
		(2895, 'germany/balingen', 'Balingen', 'Germany'),
		(2896, 'germany/zweibruecken', 'Zweibruecken', 'Germany'),
		(2897, 'germany/steinfurt', 'Steinfurt', 'Germany'),
		(2898, 'germany/schoenebeck', 'Schoenebeck', 'Germany'),
		(2899, 'germany/radebeul', 'Radebeul', 'Germany'),
		(2900, 'germany/barsinghausen', 'Barsinghausen', 'Germany'),
		(2901, 'germany/geldern', 'Geldern', 'Germany'),
		(2902, 'germany/limburg-an-der-lahn', 'Limburg An Der Lahn', 'Germany'),
		(2903, 'germany/stuhr', 'Stuhr', 'Germany'),
		(2904, 'germany/dietzenbach', 'Dietzenbach', 'Germany'),
		(2905, 'germany/korschenbroich', 'Korschenbroich', 'Germany'),
		(2906, 'germany/juelich', 'Juelich', 'Germany'),
		(2907, 'germany/crailsheim', 'Crailsheim', 'Germany'),
		(2908, 'germany/seelze', 'Seelze', 'Germany'),
		(2909, 'germany/viernheim', 'Viernheim', 'Germany'),
		(2910, 'germany/cloppenburg', 'Cloppenburg', 'Germany'),
		(2911, 'germany/fuerstenwalde-spree', 'Fuerstenwalde Spree', 'Germany'),
		(2912, 'germany/biberach-an-der-riss', 'Biberach An Der Riss', 'Germany'),
		(2913, 'germany/itzehoe', 'Itzehoe', 'Germany'),
		(2914, 'germany/rheinfelden-baden', 'Rheinfelden Baden', 'Germany'),
		(2915, 'germany/wedel', 'Wedel', 'Germany'),
		(2916, 'germany/georgsmarienhuette', 'Georgsmarienhuette', 'Germany'),
		(2917, 'germany/nienburg-weser', 'Nienburg Weser', 'Germany'),
		(2918, 'germany/bad-vilbel', 'Bad Vilbel', 'Germany'),
		(2919, 'germany/deggendorf', 'Deggendorf', 'Germany'),
		(2920, 'germany/werl', 'Werl', 'Germany'),
		(2921, 'germany/neuruppin', 'Neuruppin', 'Germany'),
		(2922, 'germany/rheinberg', 'Rheinberg', 'Germany'),
		(2923, 'germany/zeitz', 'Zeitz', 'Germany'),
		(2924, 'germany/gevelsberg', 'Gevelsberg', 'Germany'),
		(2925, 'germany/vechta', 'Vechta', 'Germany'),
		(2926, 'germany/lampertheim', 'Lampertheim', 'Germany'),
		(2927, 'germany/herrenberg', 'Herrenberg', 'Germany'),
		(2928, 'germany/kornwestheim', 'Kornwestheim', 'Germany'),
		(2929, 'germany/ahrensburg', 'Ahrensburg', 'Germany'),
		(2930, 'germany/bad-nauheim', 'Bad Nauheim', 'Germany'),
		(2931, 'germany/eisenhuettenstadt', 'Eisenhuettenstadt', 'Germany'),
		(2932, 'germany/lohmar', 'Lohmar', 'Germany'),
		(2933, 'germany/hoexter', 'Hoexter', 'Germany'),
		(2934, 'germany/kreuztal', 'Kreuztal', 'Germany'),
		(2935, 'germany/bramsche', 'Bramsche', 'Germany'),
		(2936, 'germany/ganderkesee', 'Ganderkesee', 'Germany'),
		(2937, 'germany/meschede', 'Meschede', 'Germany'),
		(2938, 'germany/radolfzell-am-bodensee', 'Radolfzell Am Bodensee', 'Germany'),
		(2939, 'germany/ennepetal', 'Ennepetal', 'Germany'),
		(2940, 'germany/forchheim', 'Forchheim', 'Germany'),
		(2941, 'germany/idar-oberstein', 'Idar Oberstein', 'Germany'),
		(2942, 'germany/weyhe', 'Weyhe', 'Germany'),
		(2943, 'germany/merzig', 'Merzig', 'Germany'),
		(2944, 'germany/guestrow', 'Guestrow', 'Germany'),
		(2945, 'germany/oer-erkenschwick', 'Oer Erkenschwick', 'Germany'),
		(2946, 'germany/osterholz-scharmbeck', 'Osterholz Scharmbeck', 'Germany'),
		(2947, 'germany/achim', 'Achim', 'Germany'),
		(2948, 'germany/bad-hersfeld', 'Bad Hersfeld', 'Germany'),
		(2949, 'germany/delbrueck', 'Delbrueck', 'Germany'),
		(2950, 'germany/weil-am-rhein', 'Weil Am Rhein', 'Germany'),
		(2951, 'germany/werne', 'Werne', 'Germany'),
		(2952, 'germany/burgdorf', 'Burgdorf', 'Germany'),
		(2953, 'germany/toenisvorst', 'Toenisvorst', 'Germany'),
		(2954, 'germany/sangerhausen', 'Sangerhausen', 'Germany'),
		(2955, 'germany/waltrop', 'Waltrop', 'Germany'),
		(2956, 'germany/emmerich-am-rhein', 'Emmerich Am Rhein', 'Germany'),
		(2957, 'germany/andernach', 'Andernach', 'Germany'),
		(2958, 'germany/buehl', 'Buehl', 'Germany'),
		(2959, 'germany/northeim', 'Northeim', 'Germany'),
		(2960, 'germany/springe', 'Springe', 'Germany'),
		(2961, 'germany/oelde', 'Oelde', 'Germany'),
		(2962, 'germany/geesthacht', 'Geesthacht', 'Germany'),
		(2963, 'germany/haan', 'Haan', 'Germany'),
		(2964, 'germany/wegberg', 'Wegberg', 'Germany'),
		(2965, 'germany/aschersleben', 'Aschersleben', 'Germany'),
		(2966, 'usa/fort-myers', 'Fort Myers', 'United States'),
		(2967, 'indonesia/bukittinggi', 'Bukittinggi', 'Indonesia'),
		(2968, 'germany/gaggenau', 'Gaggenau', 'Germany'),
		(2969, 'germany/taunusstein', 'Taunusstein', 'Germany'),
		(2970, 'germany/rietberg', 'Rietberg', 'Germany'),
		(2971, 'germany/vaihingen-an-der-enz', 'Vaihingen An Der Enz', 'Germany'),
		(2972, 'germany/sundern-sauerland', 'Sundern Sauerland', 'Germany'),
		(2973, 'germany/stassfurt', 'Stassfurt', 'Germany'),
		(2974, 'germany/bretten', 'Bretten', 'Germany'),
		(2975, 'germany/rendsburg', 'Rendsburg', 'Germany'),
		(2976, 'germany/zittau', 'Zittau', 'Germany'),
		(2977, 'germany/neuburg-an-der-donau', 'Neuburg An Der Donau', 'Germany'),
		(2978, 'germany/landsberg-am-lech', 'Landsberg Am Lech', 'Germany'),
		(2979, 'germany/meissen', 'Meissen', 'Germany'),
		(2980, 'germany/bad-neuenahr-ahrweiler', 'Bad Neuenahr Ahrweiler', 'Germany'),
		(2981, 'germany/leimen', 'Leimen', 'Germany'),
		(2982, 'germany/warstein', 'Warstein', 'Germany'),
		(2983, 'germany/mechernich', 'Mechernich', 'Germany'),
		(2984, 'germany/lennestadt', 'Lennestadt', 'Germany'),
		(2985, 'germany/emmendingen', 'Emmendingen', 'Germany'),
		(2986, 'germany/geislingen-an-der-steige', 'Geislingen An Der Steige', 'Germany'),
		(2987, 'germany/verden-aller', 'Verden Aller', 'Germany'),
		(2988, 'germany/kulmbach', 'Kulmbach', 'Germany'),
		(2989, 'germany/saalfeld-saale', 'Saalfeld Saale', 'Germany'),
		(2990, 'germany/senftenberg', 'Senftenberg', 'Germany'),
		(2991, 'germany/einbeck', 'Einbeck', 'Germany'),
		(2992, 'germany/brilon', 'Brilon', 'Germany'),
		(2993, 'germany/plettenberg', 'Plettenberg', 'Germany'),
		(2994, 'germany/st-wendel', 'St Wendel', 'Germany'),
		(2995, 'germany/strausberg', 'Strausberg', 'Germany'),
		(2996, 'germany/schloss-holte-stukenbrock', 'Schloss Holte Stukenbrock', 'Germany'),
		(2997, 'germany/garmisch-partenkirchen', 'Garmisch Partenkirchen', 'Germany'),
		(2998, 'germany/lohne-oldenburg', 'Lohne Oldenburg', 'Germany'),
		(2999, 'germany/wiesloch', 'Wiesloch', 'Germany'),
		(3000, 'germany/ilmenau', 'Ilmenau', 'Germany'),
		(3001, 'germany/luebbecke', 'Luebbecke', 'Germany'),
		(3002, 'germany/ehingen-donau', 'Ehingen Donau', 'Germany'),
		(3003, 'germany/rottweil', 'Rottweil', 'Germany'),
		(3004, 'germany/wiehl', 'Wiehl', 'Germany'),
		(3005, 'germany/horb-am-neckar', 'Horb Am Neckar', 'Germany')";
		$sql5 = "INSERT INTO `".$wpdb->prefix."location` (`id`, `name`, `time_code`, `title`) VALUES
		(3006, 'germany/lutherstadt-eisleben', 'Lutherstadt Eisleben', 'Germany'),
		(3007, 'germany/schleswig', 'Schleswig', 'Germany'),
		(3008, 'germany/westerland', 'Westerland', 'Germany'),
		(3009, 'germany/olpe', 'Olpe', 'Germany'),
		(3010, 'germany/muehlacker', 'Muehlacker', 'Germany'),
		(3011, 'germany/rathenow', 'Rathenow', 'Germany'),
		(3012, 'germany/schmallenberg', 'Schmallenberg', 'Germany'),
		(3013, 'germany/norden', 'Norden', 'Germany'),
		(3014, 'germany/achern', 'Achern', 'Germany'),
		(3015, 'germany/arnstadt', 'Arnstadt', 'Germany'),
		(3016, 'germany/lindau-bodensee', 'Lindau Bodensee', 'Germany'),
		(3017, 'germany/ellwangen-jagst', 'Ellwangen Jagst', 'Germany'),
		(3018, 'germany/varel', 'Varel', 'Germany'),
		(3019, 'germany/mosbach', 'Mosbach', 'Germany'),
		(3020, 'germany/bad-oldesloe', 'Bad Oldesloe', 'Germany'),
		(3021, 'germany/bingen-am-rhein', 'Bingen Am Rhein', 'Germany'),
		(3022, 'iran/mahabad', 'Mahabad', 'Iran'),
		(3023, 'germany/burg', 'Burg', 'Germany'),
		(3024, 'germany/pfaffenhofen-an-der-ilm', 'Pfaffenhofen-an-der-ilm', 'Germany'),
		(3025, 'germany/salzwedel', 'Salzwedel', 'Germany'),
		(3026, 'germany/dannenberg', 'Dannenberg', 'Germany'),
		(3027, 'germany/gorleben', 'Gorleben', 'Germany'),
		(3028, 'germany/ingelheim-am-rhein', 'Ingelheim-am-rhein', 'Germany'),
		(3029, 'germany/ludwigsfelde', 'Ludwigsfelde', 'Germany'),
		(3030, 'germany/walsrode', 'Walsrode', 'Germany'),
		(3031, 'germany/helmstedt', 'Helmstedt', 'Germany'),
		(3032, 'germany/waldkraiburg', 'Waldkraiburg', 'Germany'),
		(3033, 'germany/dillenburg', 'Dillenburg', 'Germany'),
		(3034, 'germany/korbach', 'Korbach', 'Germany'),
		(3035, 'germany/wertheim', 'Wertheim', 'Germany'),
		(3036, 'germany/freudenstadt', 'Freudenstadt', 'Germany'),
		(3037, 'germany/titisee-neustadt', 'Titisee-neustadt', 'Germany'),
		(3038, 'germany/osterode-am-harz', 'Osterode-am-harz', 'Germany'),
		(3039, 'germany/warburg', 'Warburg', 'Germany'),
		(3040, 'germany/gross-gerau', 'Gross-gerau', 'Germany'),
		(3041, 'germany/geretsried', 'Geretsried', 'Germany'),
		(3042, 'germany/calw', 'Calw', 'Germany'),
		(3043, 'germany/wipperfuerth', 'Wipperfuerth', 'Germany'),
		(3044, 'germany/zerbst-anhalt', 'Zerbst-anhalt', 'Germany'),
		(3045, 'germany/starnberg', 'Starnberg', 'Germany'),
		(3046, 'germany/sondershausen', 'Sondershausen', 'Germany'),
		(3047, 'germany/apolda', 'Apolda', 'Germany'),
		(3048, 'germany/waldshut-tiengen', 'Waldshut-tiengen', 'Germany'),
		(3049, 'germany/oehringen', 'Oehringen', 'Germany'),
		(3050, 'germany/eckernfoerde', 'Eckernfoerde', 'Germany'),
		(3051, 'germany/vreden', 'Vreden', 'Germany'),
		(3052, 'germany/nagold', 'Nagold', 'Germany'),
		(3053, 'germany/bad-mergentheim', 'Bad-mergentheim', 'Germany'),
		(3054, 'germany/sonneberg', 'Sonneberg', 'Germany'),
		(3055, 'germany/husum', 'Husum', 'Germany'),
		(3056, 'germany/lindlar', 'Lindlar', 'Germany'),
		(3057, 'germany/westerstede', 'Westerstede', 'Germany'),
		(3058, 'germany/leutkirch-im-allgaeu', 'Leutkirch-im-allgaeu', 'Germany'),
		(3059, 'germany/annaberg-buchholz', 'Annaberg-buchholz', 'Germany'),
		(3060, 'germany/soltau', 'Soltau', 'Germany'),
		(3061, 'germany/rotenburg-wuemme', 'Rotenburg-wuemme', 'Germany'),
		(3062, 'germany/weilheim-in-oberbayern', 'Weilheim-in-oberbayern', 'Germany'),
		(3063, 'germany/meiningen', 'Meiningen', 'Germany'),
		(3064, 'germany/neustrelitz', 'Neustrelitz', 'Germany'),
		(3065, 'germany/waren-mueritz', 'Waren-mueritz', 'Germany'),
		(3066, 'germany/heide', 'Heide', 'Germany'),
		(3067, 'germany/sonthofen', 'Sonthofen', 'Germany'),
		(3068, 'germany/bad-kissingen', 'Bad-kissingen', 'Germany'),
		(3069, 'germany/wittmund', 'Wittmund', 'Germany'),
		(3070, 'germany/friesoythe', 'Friesoythe', 'Germany'),
		(3071, 'germany/luckenwalde', 'Luckenwalde', 'Germany'),
		(3072, 'germany/alfeld-leine', 'Alfeld-leine', 'Germany'),
		(3073, 'germany/prenzlau', 'Prenzlau', 'Germany'),
		(3074, 'germany/demmin', 'Demmin', 'Germany'),
		(3075, 'germany/wittlich', 'Wittlich', 'Germany'),
		(3076, 'germany/bitburg', 'Bitburg', 'Germany'),
		(3077, 'germany/mayen', 'Mayen', 'Germany'),
		(3078, 'germany/gerolstein', 'Gerolstein', 'Germany'),
		(3079, 'germany/homberg-efze', 'Homberg-efze', 'Germany'),
		(3080, 'germany/alsfeld', 'Alsfeld', 'Germany'),
		(3081, 'austria/korneuburg', 'Korneuburg', 'Austria'),
		(3082, 'austria/marchtrenk', 'Marchtrenk', 'Austria'),
		(3083, 'austria/wals-siezenheim', 'Wals-siezenheim', 'Austria'),
		(3084, 'austria/lienz', 'Lienz', 'Austria'),
		(3085, 'austria/voecklabruck', 'Voecklabruck', 'Austria'),
		(3086, 'austria/knittelfeld', 'Knittelfeld', 'Austria'),
		(3087, 'austria/hollabrunn', 'Hollabrunn', 'Austria'),
		(3088, 'austria/rankweil', 'Rankweil', 'Austria'),
		(3089, 'austria/waidhofen-an-der-ybbs', 'Waidhofen-an-der-ybbs', 'Austria'),
		(3090, 'austria/ried-im-innkreis', 'Ried-im-innkreis', 'Austria'),
		(3091, 'austria/bad-voeslau', 'Bad-voeslau', 'Austria'),
		(3092, 'austria/enns', 'Enns', 'Austria'),
		(3093, 'austria/voelkermarkt', 'Voelkermarkt', 'Austria'),
		(3094, 'usa/neenah', 'Neenah', 'United States'),
		(3095, 'austria/brunn-am-gebirge', 'Brunn-am-gebirge', 'Austria'),
		(3096, 'austria/mistelbach', 'Mistelbach', 'Austria'),
		(3097, 'austria/st-johann-im-pongau', 'St-johann-im-pongau', 'Austria'),
		(3098, 'austria/goetzis', 'Goetzis', 'Austria'),
		(3099, 'austria/st-andrae', 'St-andrae', 'Austria'),
		(3100, 'austria/gerasdorf-bei-wien', 'Gerasdorf-bei-wien', 'Austria'),
		(3101, 'austria/gaenserndorf', 'Gaenserndorf', 'Austria'),
		(3102, 'austria/bruck-an-der-leitha', 'Bruck-an-der-leitha', 'Austria'),
		(3103, 'austria/deutschlandsberg', 'Deutschlandsberg', 'Austria'),
		(3104, 'austria/eferding', 'Eferding', 'Austria'),
		(3105, 'austria/feldbach', 'Feldbach', 'Austria'),
		(3106, 'austria/freistadt', 'Freistadt', 'Austria'),
		(3107, 'austria/fuerstenfeld', 'Fuerstenfeld', 'Austria'),
		(3108, 'austria/gmuend', 'Gmuend', 'Austria'),
		(3109, 'austria/grieskirchen', 'Grieskirchen', 'Austria'),
		(3110, 'austria/groebming', 'Groebming', 'Austria'),
		(3111, 'austria/guessing', 'Guessing', 'Austria'),
		(3112, 'austria/hartberg', 'Hartberg', 'Austria'),
		(3113, 'austria/hermagor-pressegger-see', 'Hermagor-pressegger-see', 'Austria'),
		(3114, 'austria/horn', 'Horn', 'Austria'),
		(3115, 'austria/imst', 'Imst', 'Austria'),
		(3116, 'austria/jennersdorf', 'Jennersdorf', 'Austria'),
		(3117, 'austria/kirchdorf-an-der-krems', 'Kirchdorf-an-der-krems', 'Austria'),
		(3118, 'austria/kitzbuehel', 'Kitzbuehel', 'Austria'),
		(3119, 'austria/landeck', 'Landeck', 'Austria'),
		(3120, 'austria/leibnitz', 'Leibnitz', 'Austria'),
		(3121, 'austria/liezen', 'Liezen', 'Austria'),
		(3122, 'austria/lilienfeld', 'Lilienfeld', 'Austria'),
		(3123, 'austria/mattersburg', 'Mattersburg', 'Austria'),
		(3124, 'austria/melk', 'Melk', 'Austria'),
		(3125, 'austria/murau', 'Murau', 'Austria'),
		(3126, 'austria/judenburg', 'Judenburg', 'Austria'),
		(3127, 'austria/muerzzuschlag', 'Muerzzuschlag', 'Austria'),
		(3128, 'austria/neusiedl-am-see', 'Neusiedl-am-see', 'Austria'),
		(3129, 'austria/oberpullendorf', 'Oberpullendorf', 'Austria'),
		(3130, 'austria/oberwart', 'Oberwart', 'Austria'),
		(3131, 'austria/perg', 'Perg', 'Austria'),
		(3132, 'austria/bad-radkersburg', 'Bad-radkersburg', 'Austria'),
		(3133, 'austria/reutte', 'Reutte', 'Austria'),
		(3134, 'austria/rohrbach-in-oberoesterreich', 'Rohrbach-in-oberoesterreich', 'Austria'),
		(3135, 'austria/rust', 'Rust', 'Austria'),
		(3136, 'austria/schaerding', 'Schaerding', 'Austria'),
		(3137, 'austria/scheibbs', 'Scheibbs', 'Austria'),
		(3138, 'austria/tamsweg', 'Tamsweg', 'Austria'),
		(3139, 'austria/voitsberg', 'Voitsberg', 'Austria'),
		(3140, 'austria/waidhofen-an-der-thaya', 'Waidhofen-an-der-thaya', 'Austria'),
		(3141, 'austria/weiz', 'Weiz', 'Austria'),
		(3142, 'austria/zell-am-see', 'Zell-am-see', 'Austria'),
		(3143, 'switzerland/kriens', 'Kriens', 'Switzerland'),
		(3144, 'switzerland/rapperswil-jona', 'Rapperswil-jona', 'Switzerland'),
		(3145, 'switzerland/duebendorf', 'Duebendorf', 'Switzerland'),
		(3146, 'switzerland/montreux', 'Montreux', 'Switzerland'),
		(3147, 'switzerland/dietikon', 'Dietikon', 'Switzerland'),
		(3148, 'switzerland/frauenfeld', 'Frauenfeld', 'Switzerland'),
		(3149, 'switzerland/wetzikon', 'Wetzikon', 'Switzerland'),
		(3150, 'switzerland/baar', 'Baar', 'Switzerland'),
		(3151, 'switzerland/meyrin', 'Meyrin', 'Switzerland'),
		(3152, 'switzerland/riehen', 'Riehen', 'Switzerland'),
		(3153, 'switzerland/waedenswil', 'Waedenswil', 'Switzerland'),
		(3154, 'switzerland/wettingen', 'Wettingen', 'Switzerland'),
		(3155, 'switzerland/carouge', 'Carouge', 'Switzerland'),
		(3156, 'switzerland/renens', 'Renens', 'Switzerland'),
		(3157, 'switzerland/kreuzlingen', 'Kreuzlingen', 'Switzerland'),
		(3158, 'switzerland/aarau', 'Aarau', 'Switzerland'),
		(3159, 'switzerland/allschwil', 'Allschwil', 'Switzerland'),
		(3160, 'switzerland/bulle', 'Bulle', 'Switzerland'),
		(3161, 'switzerland/horgen', 'Horgen', 'Switzerland'),
		(3162, 'switzerland/nyon', 'Nyon', 'Switzerland'),
		(3163, 'switzerland/reinach', 'Reinach', 'Switzerland'),
		(3164, 'switzerland/vevey', 'Vevey', 'Switzerland'),
		(3165, 'switzerland/kloten', 'Kloten', 'Switzerland'),
		(3166, 'switzerland/wil', 'Wil', 'Switzerland'),
		(3167, 'switzerland/gossau', 'Gossau', 'Switzerland'),
		(3168, 'switzerland/onex', 'Onex', 'Switzerland'),
		(3169, 'switzerland/buelach', 'Buelach', 'Switzerland'),
		(3170, 'switzerland/volketswil', 'Volketswil', 'Switzerland'),
		(3171, 'switzerland/bellinzona', 'Bellinzona', 'Switzerland'),
		(3172, 'switzerland/muttenz', 'Muttenz', 'Switzerland'),
		(3173, 'switzerland/thalwil', 'Thalwil', 'Switzerland'),
		(3174, 'switzerland/pully', 'Pully', 'Switzerland'),
		(3175, 'switzerland/olten', 'Olten', 'Switzerland'),
		(3176, 'switzerland/regensdorf', 'Regensdorf', 'Switzerland'),
		(3177, 'switzerland/adliswil', 'Adliswil', 'Switzerland'),
		(3178, 'switzerland/monthey', 'Monthey', 'Switzerland'),
		(3179, 'switzerland/schlieren', 'Schlieren', 'Switzerland'),
		(3180, 'switzerland/martigny', 'Martigny', 'Switzerland'),
		(3181, 'switzerland/solothurn', 'Solothurn', 'Switzerland'),
		(3182, 'switzerland/grenchen', 'Grenchen', 'Switzerland'),
		(3183, 'switzerland/freienbach', 'Freienbach', 'Switzerland'),
		(3184, 'switzerland/illnau-effretikon', 'Illnau-effretikon', 'Switzerland'),
		(3185, 'switzerland/opfikon', 'Opfikon', 'Switzerland'),
		(3186, 'switzerland/sierre', 'Sierre', 'Switzerland'),
		(3187, 'switzerland/ostermundigen', 'Ostermundigen', 'Switzerland'),
		(3188, 'switzerland/steffisburg', 'Steffisburg', 'Switzerland'),
		(3189, 'switzerland/burgdorf', 'Burgdorf', 'Switzerland'),
		(3190, 'switzerland/pratteln', 'Pratteln', 'Switzerland'),
		(3191, 'switzerland/herisau', 'Herisau', 'Switzerland'),
		(3192, 'switzerland/locarno', 'Locarno', 'Switzerland'),
		(3193, 'switzerland/langenthal', 'Langenthal', 'Switzerland'),
		(3194, 'switzerland/cham', 'Cham', 'Switzerland'),
		(3195, 'switzerland/morges', 'Morges', 'Switzerland'),
		(3196, 'switzerland/binningen', 'Binningen', 'Switzerland'),
		(3197, 'switzerland/wohlen', 'Wohlen', 'Switzerland'),
		(3198, 'switzerland/schwyz', 'Schwyz', 'Switzerland'),
		(3199, 'switzerland/einsiedeln', 'Einsiedeln', 'Switzerland'),
		(3200, 'switzerland/staefa', 'Staefa', 'Switzerland'),
		(3201, 'switzerland/wallisellen', 'Wallisellen', 'Switzerland'),
		(3202, 'switzerland/arbon', 'Arbon', 'Switzerland'),
		(3203, 'switzerland/liestal', 'Liestal', 'Switzerland'),
		(3204, 'switzerland/thonex', 'Thonex', 'Switzerland'),
		(3205, 'switzerland/kuesnacht', 'Kuesnacht', 'Switzerland'),
		(3206, 'switzerland/horw', 'Horw', 'Switzerland'),
		(3207, 'switzerland/versoix', 'Versoix', 'Switzerland'),
		(3208, 'switzerland/uzwil', 'Uzwil', 'Switzerland'),
		(3209, 'switzerland/meilen', 'Meilen', 'Switzerland'),
		(3210, 'switzerland/spiez', 'Spiez', 'Switzerland'),
		(3211, 'switzerland/brig-glis', 'Brig-glis', 'Switzerland'),
		(3212, 'switzerland/richterswil', 'Richterswil', 'Switzerland'),
		(3213, 'switzerland/oftringen', 'Oftringen', 'Switzerland'),
		(3214, 'switzerland/amriswil', 'Amriswil', 'Switzerland'),
		(3215, 'switzerland/kuessnacht', 'Kuessnacht', 'Switzerland'),
		(3216, 'switzerland/rueti', 'Rueti', 'Switzerland'),
		(3217, 'switzerland/delemont', 'Delemont', 'Switzerland'),
		(3218, 'switzerland/mendrisio', 'Mendrisio', 'Switzerland'),
		(3219, 'switzerland/worb', 'Worb', 'Switzerland'),
		(3220, 'switzerland/buchs', 'Buchs', 'Switzerland'),
		(3221, 'switzerland/affoltern-am-albis', 'Affoltern-am-albis', 'Switzerland'),
		(3222, 'switzerland/altstaetten', 'Altstaetten', 'Switzerland'),
		(3223, 'switzerland/val-de-travers', 'Val-de-travers', 'Switzerland'),
		(3224, 'switzerland/arth', 'Arth', 'Switzerland'),
		(3225, 'switzerland/brugg', 'Brugg', 'Switzerland'),
		(3226, 'switzerland/weinfelden', 'Weinfelden', 'Switzerland'),
		(3227, 'switzerland/altdorf', 'Altdorf', 'Switzerland'),
		(3228, 'switzerland/sarnen', 'Sarnen', 'Switzerland'),
		(3229, 'switzerland/stans', 'Stans', 'Switzerland'),
		(3230, 'switzerland/glarus', 'Glarus', 'Switzerland'),
		(3231, 'switzerland/appenzell', 'Appenzell', 'Switzerland'),
		(3232, 'switzerland/thusis', 'Thusis', 'Switzerland'),
		(3233, 'switzerland/ilanz', 'Ilanz', 'Switzerland'),
		(3234, 'switzerland/zermatt', 'Zermatt', 'Switzerland'),
		(3235, 'germany/nuerburg', 'Nuerburg', 'Germany'),
		(3236, 'new-zealand/oban', 'Oban', 'New Zealand'),
		(3237, 'usa/vancouver', 'Vancouver', 'United States'),
		(3238, 'uruguay/canelones', 'Canelones', 'Uruguay'),
		(3239, 'uruguay/rocha', 'Rocha', 'Uruguay'),
		(3240, 'uruguay/treinta-y-tres', 'Treinta-y-tres', 'Uruguay'),
		(3241, 'uruguay/rivera', 'Rivera', 'Uruguay'),
		(3242, 'uruguay/artigas', 'Artigas', 'Uruguay'),
		(3243, 'uruguay/fray-bentos', 'Fray-bentos', 'Uruguay'),
		(3244, 'uruguay/mercedes', 'Mercedes', 'Uruguay'),
		(3245, 'uruguay/colonia-del-sacramento', 'Colonia-del-sacramento', 'Uruguay'),
		(3246, 'usa/lakeland', 'Lakeland', 'United States'),
		(3247, 'uruguay/san-jose-de-mayo', 'San-jose-de-mayo', 'Uruguay'),
		(3248, 'uruguay/trinidad', 'Trinidad', 'Uruguay'),
		(3249, 'uruguay/florida', 'Florida', 'Uruguay'),
		(3250, 'uruguay/minas', 'Minas', 'Uruguay'),
		(3251, 'uruguay/durazno', 'Durazno', 'Uruguay'),
		(3252, 'uruguay/tacuarembo', 'Tacuarembo', 'Uruguay'),
		(3253, 'uk/silverstone', 'Silverstone', 'United Kingdom'),
		(3254, 'germany/hockenheim', 'Hockenheim', 'Germany'),
		(3255, 'belgium/spa', 'Spa', 'Belgium'),
		(3256, 'italy/monza', 'Monza', 'Italy'),
		(3257, 'japan/suzuka', 'Suzuka', 'Japan'),
		(3258, 'south-korea/mokpo', 'Mokpo', 'South Korea'),
		(3259, 'india/greater-noida', 'Greater-noida', 'India'),
		(3260, 'usa/redding', 'Redding', 'United States'),
		(3261, 'usa/jacksonville-nc', 'Jacksonville-nc', 'United States'),
		(3262, 'myanmar/mandalay', 'Mandalay', 'Myanmar'),
		(3263, 'usa/st-george', 'St-george', 'United States'),
		(3264, 'usa/eureka', 'Eureka', 'United States'),
		(3265, 'usa/chico', 'Chico', 'United States'),
		(3266, 'usa/farmington', 'Farmington', 'United States'),
		(3267, 'usa/roswell', 'Roswell', 'United States'),
		(3268, 'usa/odessa', 'Odessa', 'United States'),
		(3269, 'usa/clovis', 'Clovis', 'United States'),
		(3270, 'ukraine/yalta', 'Yalta', 'Ukraine'),
		(3271, 'india/gulmarg', 'Gulmarg', 'India'),
		(3272, 'egypt/hurghada', 'Hurghada', 'Egypt'),
		(3273, 'usa/greeley', 'Greeley', 'United States'),
		(3274, 'slovakia/kosice', 'Kosice', 'Slovakia'),
		(3275, 'pakistan/murree', 'Murree', 'Pakistan'),
		(3276, 'slovakia/piestany', 'Piestany', 'Slovakia'),
		(3277, 'india/kattoor', 'Kattoor', 'India'),
		(3278, 'bosnia-herzegovina/mostar', 'Mostar', 'Bosnia and Herzegovina'),
		(3279, 'greece/santorini', 'Santorini', 'Greece'),
		(3280, 'india/maraimalai-nagar', 'Maraimalai-nagar', 'India'),
		(3281, 'italy/modena', 'Modena', 'Italy'),
		(3282, 'italy/trieste', 'Trieste', 'Italy'),
		(3283, 'india/nangal', 'Nangal', 'India'),
		(3284, 'india/karaikudi', 'Karaikudi', 'India'),
		(3285, 'usa/sidney', 'Sidney', 'United States'),
		(3286, 'pakistan/jhelum', 'Jhelum', 'Pakistan'),
		(3287, 'usa/ocala', 'Ocala', 'United States'),
		(3288, 'usa/inverness', 'Inverness', 'United States'),
		(3289, 'india/vasai-virar', 'Vasai-virar', 'India'),
		(3290, 'usa/atascadero', 'Atascadero', 'United States'),
		(3291, 'uk/market-harborough', 'Market-harborough', 'United Kingdom'),
		(3292, 'usa/avalon-santa-catalina-island', 'Avalon-santa-catalina-island', 'United States'),
		(3293, 'pakistan/hyderabad', 'Hyderabad', 'Pakistan'),
		(3294, 'indonesia/bekasi', 'Bekasi', 'Indonesia'),
		(3295, 'iran/bijar', 'Bijar', 'Iran'),
		(3296, 'turkey/samsun', 'Samsun', 'Turkey'),
		(3297, 'uk/brentwood', 'Brentwood', 'United Kingdom'),
		(3298, 'india/rajahmundry', 'Rajahmundry', 'India'),
		(3299, 'india/srisailam', 'Srisailam', 'India'),
		(3300, 'pakistan/khushab', 'Khushab', 'Pakistan'),
		(3301, 'usa/toccoa', 'Toccoa', 'United States'),
		(3302, 'canada/white-rock', 'White-rock', 'Canada'),
		(3303, 'mexico/tepic', 'Tepic', 'Mexico'),
		(3304, 'usa/concord-ca', 'Concord-ca', 'United States'),
		(3305, 'usa/antioch', 'Antioch', 'United States'),
		(3306, 'mexico/ixtlan-del-rio', 'Ixtlan-del-rio', 'Mexico'),
		(3307, 'south-africa/upington', 'Upington', 'South Africa'),
		(3308, 'south-africa/springbok', 'Springbok', 'South Africa'),
		(3309, 'croatia/osijek', 'Osijek', 'Croatia'),
		(3310, 'india/ahmednagar', 'Ahmednagar', 'India'),
		(3311, 'india/shirdi', 'Shirdi', 'India'),
		(3312, 'israel/eilat', 'Eilat', 'Israel'),
		(3313, 'hungary/debrecen', 'Debrecen', 'Hungary'),
		(3314, 'nigeria/uyo', 'Uyo', 'Nigeria'),
		(3315, 'hungary/szeged', 'Szeged', 'Hungary'),
		(3316, 'hungary/miskolc', 'Miskolc', 'Hungary'),
		(3317, 'philippines/tarlac', 'Tarlac', 'Philippines'),
		(3318, 'india/pathankot', 'Pathankot', 'India'),
		(3319, 'hungary/pecs', 'Pecs', 'Hungary'),
		(3320, 'hungary/gyor', 'Gyor', 'Hungary'),
		(3321, 'algeria/tamanrasset', 'Tamanrasset', 'Algeria'),
		(3322, 'italy/ancona', 'Ancona', 'Italy'),
		(3323, 'russia/naryan-mar', 'Naryan-mar', 'Russia'),
		(3324, 'russia/velsk', 'Velsk', 'Russia'),
		(3325, 'paraguay/ciudad-del-este', 'Ciudad-del-este', 'Paraguay'),
		(3326, 'paraguay/encarnacion', 'Encarnacion', 'Paraguay'),
		(3327, 'paraguay/pedro-juan-caballero', 'Pedro-juan-caballero', 'Paraguay'),
		(3328, 'russia/kovrov', 'Kovrov', 'Russia'),
		(3329, 'uk/durham', 'Durham', 'United Kingdom'),
		(3330, 'mexico/morelia', 'Morelia', 'Mexico'),
		(3331, 'canada/meadow-lake', 'Meadow-lake', 'Canada'),
		(3332, 'romania/timisoara', 'Timisoara', 'Romania'),
		(3333, 'usa/barrow', 'Barrow', 'United States'),
		(3334, 'spain/lugo', 'Lugo', 'Spain'),
		(3335, 'india/yercaud', 'Yercaud', 'India'),
		(3336, 'estonia/tartu', 'Tartu', 'Estonia'),
		(3337, 'poland/jelenia-gora', 'Jelenia-gora', 'Poland'),
		(3338, 'usa/leawood', 'Leawood', 'United States'),
		(3339, 'usa/redlands', 'Redlands', 'United States'),
		(3340, 'usa/leesburg', 'Leesburg', 'United States'),
		(3341, 'norway/bardufoss', 'Bardufoss', 'Norway'),
		(3342, 'turkey/kayseri', 'Kayseri', 'Turkey'),
		(3343, 'congo-demrep/bukavu', 'Bukavu', 'Congo Dem.Rep.'),
		(3344, 'turkey/bodrum', 'Bodrum', 'Turkey'),
		(3345, 'usa/lakewood-township', 'Lakewood-township', 'United States'),
		(3346, 'usa/san-luis-obispo', 'San-luis-obispo', 'United States'),
		(3347, 'philippines/silang', 'Silang', 'Philippines'),
		(3348, 'usa/eau-claire', 'Eau-claire', 'United States'),
		(3349, 'australia/katoomba', 'Katoomba', 'Australia'),
		(3350, 'portugal/beja', 'Beja', 'Portugal'),
		(3351, 'spain/cadiz', 'Cadiz', 'Spain'),
		(3352, 'moldova/cahul', 'Cahul', 'Moldova'),
		(3353, 'usa/coeur-d-alene', 'Coeur-d-alene', 'United States'),
		(3354, 'india/hubli', 'Hubli', 'India'),
		(3355, 'india/davangere', 'Davangere', 'India'),
		(3356, 'canada/quesnel', 'Quesnel', 'Canada'),
		(3357, 'philippines/mabalacat', 'Mabalacat', 'Philippines'),
		(3358, 'usa/missoula', 'Missoula', 'United States'),
		(3359, 'usa/tuba-city', 'Tuba-city', 'United States'),
		(3360, 'russia/belgorod', 'Belgorod', 'Russia'),
		(3361, 'usa/lexington', 'Lexington', 'United States'),
		(3362, 'india/rudrapur', 'Rudrapur', 'India'),
		(3363, 'saudi-arabia/haql', 'Haql', 'Saudi Arabia'),
		(3364, 'usa/vista', 'Vista', 'United States'),
		(3365, 'usa/brattleboro', 'Brattleboro', 'United States'),
		(3366, 'sri-lanka/kurunegala', 'Kurunegala', 'Sri Lanka'),
		(3367, 'turkey/erzurum', 'Erzurum', 'Turkey'),
		(3368, 'canada/alert', 'Alert', 'Canada'),
		(3369, 'norway/tau', 'Tau', 'Norway'),
		(3370, 'australia/newman', 'Newman', 'Australia'),
		(3371, 'saint-kitts-and-nevis/charlestown', 'Charlestown', 'Saint Kitts and Nevis'),
		(3372, 'usa/terre-haute', 'Terre-haute', 'United States'),
		(3373, 'russia/blagoveshchensk', 'Blagoveshchensk', 'Russia'),
		(3374, 'canada/hopedale', 'Hopedale', 'Canada'),
		(3375, 'india/kishtwar', 'Kishtwar', 'India'),
		(3376, 'thailand/udon-thani', 'Udon-thani', 'Thailand'),
		(3377, 'usa/shiprock', 'Shiprock', 'United States'),
		(3378, 'usa/sheboygan', 'Sheboygan', 'United States'),
		(3379, 'usa/sitka', 'Sitka', 'United States'),
		(3380, 'usa/metlakatla', 'Metlakatla', 'United States'),
		(3381, 'india/nellore', 'Nellore', 'India'),
		(3382, 'india/nainital', 'Nainital', 'India'),
		(3383, 'canada/ponoka', 'Ponoka', 'Canada'),
		(3384, 'usa/kalispell', 'Kalispell', 'United States'),
		(3385, 'croatia/rijeka', 'Rijeka', 'Croatia'),
		(3386, 'germany/melsungen', 'Melsungen', 'Germany'),
		(3387, 'india/barpeta', 'Barpeta', 'India'),
		(3388, 'usa/sioux-city', 'Sioux-city', 'United States'),
		(3389, 'thailand/hua-hin', 'Hua-hin', 'Thailand'),
		(3390, 'croatia/pula', 'Pula', 'Croatia'),
		(3391, 'usa/cumberland', 'Cumberland', 'United States'),
		(3392, 'usa/boca-raton', 'Boca-raton', 'United States'),
		(3393, 'usa/napili-honokowai', 'Napili-honokowai', 'United States'),
		(3394, 'serbia/nis', 'Nis', 'Serbia'),
		(3395, 'serbia/novi-sad', 'Novi-sad', 'Serbia'),
		(3396, 'belarus/gomel', 'Gomel', 'Belarus'),
		(3397, 'philippines/isabela-city', 'Isabela-city', 'Philippines'),
		(3398, 'latvia/madona', 'Madona', 'Latvia'),
		(3399, 'usa/baker-island', 'Baker-island', 'United States'),
		(3400, 'usa/howland-island', 'Howland-island', 'United States'),
		(3401, 'south-africa/marion-island-prince-edward-islands', 'Marion-island-prince-edward-islands', 'South Africa'),
		(3402, 'usa/woodstock', 'Woodstock', 'United States'),
		(3403, 'india/qadian', 'Qadian', 'India'),
		(3404, 'dominican-republic/punta-cana', 'Punta-cana', 'Dominican Republic'),
		(3405, 'india/katra', 'Katra', 'India'),
		(3406, 'usa/prudhoe-bay', 'Prudhoe-bay', 'United States'),
		(3407, 'estonia/narva', 'Narva', 'Estonia'),
		(3408, 'estonia/kohtla-jarve', 'Kohtla-jarve', 'Estonia'),
		(3409, 'estonia/parnu', 'Parnu', 'Estonia'),
		(3410, 'latvia/daugavpils', 'Daugavpils', 'Latvia'),
		(3411, 'latvia/liepaja', 'Liepaja', 'Latvia'),
		(3412, 'latvia/jelgava', 'Jelgava', 'Latvia'),
		(3413, 'portugal/viana-do-castelo', 'Viana-do-castelo', 'Portugal'),
		(3414, 'albania/durres', 'Durres', 'Albania'),
		(3415, 'albania/vlore', 'Vlore', 'Albania'),
		(3416, 'algeria/oran', 'Oran', 'Algeria'),
		(3417, 'algeria/constantine', 'Constantine', 'Algeria'),
		(3418, 'angola/cabinda', 'Cabinda', 'Angola'),
		(3419, 'angola/huambo', 'Huambo', 'Angola'),
		(3420, 'armenia/gyumri', 'Gyumri', 'Armenia'),
		(3421, 'armenia/vanadzor', 'Vanadzor', 'Armenia'),
		(3422, 'azerbaijan/ganja', 'Ganja', 'Azerbaijan'),
		(3423, 'azerbaijan/sumqayit', 'Sumqayit', 'Azerbaijan'),
		(3424, 'bahamas/freeport', 'Freeport', 'The Bahamas'),
		(3425, 'bahrain/riffa', 'Riffa', 'Bahrain'),
		(3426, 'bangladesh/rajshahi', 'Rajshahi', 'Bangladesh'),
		(3427, 'uk/salisbury', 'Salisbury', 'United Kingdom'),
		(3428, 'panama/david', 'David', 'Panama'),
		(3429, 'usa/lexington-nc', 'Lexington-nc', 'United States'),
		(3430, 'usa/fairfax', 'Fairfax', 'United States'),
		(3431, 'panama/boquete', 'Boquete', 'Panama'),
		(3432, 'belarus/barysaw', 'Barysaw', 'Belarus'),
		(3433, 'belarus/salihorsk', 'Salihorsk', 'Belarus'),
		(3434, 'belize/orange-walk-town', 'Orange-walk-town', 'Belize'),
		(3435, 'benin/parakou', 'Parakou', 'Benin'),
		(3436, 'bhutan/phuntsholing', 'Phuntsholing', 'Bhutan'),
		(3437, 'bhutan/samdrup-jongkhar', 'Samdrup-jongkhar', 'Bhutan'),
		(3438, 'bosnia-herzegovina/tuzla', 'Tuzla', 'Bosnia and Herzegovina'),
		(3439, 'botswana/francistown', 'Francistown', 'Botswana'),
		(3440, 'botswana/molepolole', 'Molepolole', 'Botswana'),
		(3441, 'brunei/kuala-belait', 'Kuala-belait', 'Brunei'),
		(3442, 'brunei/pekan-tutong', 'Pekan-tutong', 'Brunei'),
		(3443, 'bulgaria/plovdiv', 'Plovdiv', 'Bulgaria'),
		(3444, 'burkina-faso/bobo-dioulasso', 'Bobo-dioulasso', 'Burkina Faso'),
		(3445, 'burkina-faso/koudougou', 'Koudougou', 'Burkina Faso'),
		(3446, 'burundi/gitega', 'Gitega', 'Burundi'),
		(3447, 'burundi/muyinga', 'Muyinga', 'Burundi'),
		(3448, 'cambodia/battambang', 'Battambang', 'Cambodia'),
		(3449, 'cambodia/sihanoukville', 'Sihanoukville', 'Cambodia'),
		(3450, 'cameroon/bamenda', 'Bamenda', 'Cameroon'),
		(3451, 'cameroon/garoua', 'Garoua', 'Cameroon'),
		(3452, 'cape-verde/mindelo', 'Mindelo', 'Cape Verde'),
		(3453, 'cape-verde/santa-maria', 'Santa-maria', 'Cape Verde'),
		(3454, 'central-african-republic/bimbo', 'Bimbo', 'Central African Republic'),
		(3455, 'central-african-republic/berberati', 'Berberati', 'Central African Republic'),
		(3456, 'central-african-republic/bambari', 'Bambari', 'Central African Republic'),
		(3457, 'chad/moundou', 'Moundou', 'Chad'),
		(3458, 'chad/sarh', 'Sarh', 'Chad'),
		(3459, 'comoros/mutsamudu', 'Mutsamudu', 'Comoros'),
		(3460, 'congo/pointe-noire', 'Pointe-noire', 'Congo'),
		(3461, 'congo/dolisie', 'Dolisie', 'Congo'),
		(3462, 'congo/impfondo', 'Impfondo', 'Congo'),
		(3463, 'congo-demrep/mbuji-mayi', 'Mbuji-mayi', 'Congo Dem.Rep.'),
		(3464, 'congo-demrep/kisangani', 'Kisangani', 'Congo Dem.Rep.'),
		(3465, 'costa-rica/alajuela', 'Alajuela', 'Costa Rica'),
		(3466, 'cote-divoire/bouake', 'Bouake', 'Cote d''Ivoire'),
		(3467, 'usa/santa-cruz', 'Santa-cruz', 'United States'),
		(3468, 'uk/swanage', 'Swanage', 'United Kingdom'),
		(3469, 'israel/tiberias', 'Tiberias', 'Israel'),
		(3470, 'cuba/camaguey', 'Camaguey', 'Cuba'),
		(3471, 'djibouti/ali-sabieh', 'Ali-sabieh', 'Djibouti'),
		(3472, 'djibouti/tadjoura', 'Tadjoura', 'Djibouti'),
		(3473, 'dominican-republic/puerto-plata', 'Puerto-plata', 'Dominican Republic'),
		(3474, 'el-salvador/san-miguel', 'San-miguel', 'El Salvador'),
		(3475, 'equatorial-guinea/ebebiyin', 'Ebebiyin', 'Equatorial Guinea'),
		(3476, 'eritrea/keren', 'Keren', 'Eritrea'),
		(3477, 'eritrea/teseney', 'Teseney', 'Eritrea'),
		(3478, 'ethiopia/mek-ele', 'Mek-ele', 'Ethiopia'),
		(3479, 'ethiopia/adama', 'Adama', 'Ethiopia'),
		(3480, 'fiji/lautoka', 'Lautoka', 'Fiji'),
		(3481, 'french-guiana/saint-laurent-du-maroni', 'Saint-laurent-du-maroni', 'French Guiana'),
		(3482, 'gabon/port-gentil', 'Port-gentil', 'Gabon'),
		(3483, 'gabon/franceville', 'Franceville', 'Gabon'),
		(3484, 'usa/mcallen', 'Mcallen', 'United States'),
		(3485, 'gambia/serekunda', 'Serekunda', 'The Gambia'),
		(3486, 'gambia/farafenni', 'Farafenni', 'The Gambia'),
		(3487, 'gaza-strip/khan-yunis', 'Khan-yunis', 'Gaza Strip'),
		(3488, 'georgia/kutaisi', 'Kutaisi', 'Georgia'),
		(3489, 'georgia/batumi', 'Batumi', 'Georgia'),
		(3490, 'greenland/sisimiut', 'Sisimiut', 'Greenland'),
		(3491, 'guadeloupe/pointe-a-pitre', 'Pointe-a-pitre', 'Guadeloupe'),
		(3492, 'guatemala/escuintla', 'Escuintla', 'Guatemala'),
		(3493, 'ghana/kumasi', 'Kumasi', 'Ghana'),
		(3494, 'ghana/tamale', 'Tamale', 'Ghana'),
		(3495, 'guinea/nzerekore', 'Nzerekore', 'Guinea'),
		(3496, 'guinea/boke', 'Boke', 'Guinea'),
		(3497, 'guinea-bissau/bafata', 'Bafata', 'Guinea-Bissau'),
		(3498, 'guinea-bissau/gabu', 'Gabu', 'Guinea-Bissau'),
		(3499, 'india/madikeri', 'Madikeri', 'India'),
		(3500, 'ireland/letterkenny', 'Letterkenny', 'Ireland'),
		(3501, 'guyana/linden', 'Linden', 'Guyana'),
		(3502, 'guyana/new-amsterdam', 'New-amsterdam', 'Guyana'),
		(3503, 'haiti/gonaives', 'Gonaives', 'Haiti'),
		(3504, 'honduras/choloma', 'Choloma', 'Honduras'),
		(3505, 'iceland/keflavik', 'Keflavik', 'Iceland'),
		(3506, 'isle-of-man/ramsey', 'Ramsey', 'Isle of Man'),
		(3507, 'jamaica/montego-bay', 'Montego-bay', 'Jamaica'),
		(3508, 'jamaica/may-pen', 'May-pen', 'Jamaica'),
		(3509, 'jordan/zarqa', 'Zarqa', 'Jordan'),
		(3510, 'jordan/irbid', 'Irbid', 'Jordan'),
		(3511, 'kazakhstan/shymkent', 'Shymkent', 'Kazakhstan'),
		(3512, 'kenya/nakuru', 'Nakuru', 'Kenya'),
		(3513, 'philippines/cagayan-de-oro', 'Cagayan-de-oro', 'Philippines'),
		(3514, 'kosovo/prizren', 'Prizren', 'Kosovo'),
		(3515, 'kosovo/urosevac', 'Urosevac', 'Kosovo'),
		(3516, 'kyrgyzstan/osh', 'Osh', 'Kyrgyzstan'),
		(3517, 'kyrgyzstan/jalal-abad', 'Jalal-abad', 'Kyrgyzstan'),
		(3518, 'laos/pakse', 'Pakse', 'Laos'),
		(3519, 'laos/savannakhet', 'Savannakhet', 'Laos'),
		(3520, 'laos/luang-prabang', 'Luang-prabang', 'Laos'),
		(3521, 'lebanon/tripoli', 'Tripoli', 'Lebanon'),
		(3522, 'lebanon/sidon', 'Sidon', 'Lebanon'),
		(3523, 'lesotho/teyateyaneng', 'Teyateyaneng', 'Lesotho'),
		(3524, 'lesotho/mafeteng', 'Mafeteng', 'Lesotho'),
		(3525, 'liberia/gbarnga', 'Gbarnga', 'Liberia'),
		(3526, 'liberia/kakata', 'Kakata', 'Liberia'),
		(3527, 'lithuania/klaipeda', 'Klaipeda', 'Lithuania'),
		(3528, 'luxembourg/differdange', 'Differdange', 'Luxembourg'),
		(3529, 'republic-of-macedonia/bitola', 'Bitola', 'Macedonia'),
		(3530, 'republic-of-macedonia/kumanovo', 'Kumanovo', 'Macedonia'),
		(3531, 'madagascar/toamasina', 'Toamasina', 'Madagascar'),
		(3532, 'madagascar/antsirabe', 'Antsirabe', 'Madagascar'),
		(3533, 'malaysia/johor-bahru', 'Johor-bahru', 'Malaysia'),
		(3534, 'malaysia/ipoh', 'Ipoh', 'Malaysia'),
		(3535, 'usa/gloucester', 'Gloucester', 'United States'),
		(3536, 'namibia/rundu', 'Rundu', 'Namibia'),
		(3537, 'namibia/walvis-bay', 'Walvis-bay', 'Namibia'),
		(3538, 'india/lohaghat', 'Lohaghat', 'India'),
		(3539, 'india/nanpara', 'Nanpara', 'India'),
		(3540, 'namibia/swakopmund', 'Swakopmund', 'Namibia'),
		(3541, 'usa/palestine', 'Palestine', 'United States'),
		(3542, 'usa/kilgore', 'Kilgore', 'United States'),
		(3543, 'usa/victoria', 'Victoria', 'United States'),
		(3544, 'usa/cleveland-tn', 'Cleveland-tn', 'United States'),
		(3545, 'usa/pontiac', 'Pontiac', 'United States'),
		(3546, 'usa/sunrise', 'Sunrise', 'United States'),
		(3547, 'usa/manhattan', 'Manhattan', 'United States'),
		(3548, 'france/gustavia', 'Gustavia', 'France'),
		(3549, 'france/marigot', 'Marigot', 'France'),
		(3550, 'usa/sandpoint', 'Sandpoint', 'United States'),
		(3551, 'pakistan/gujranwala', 'Gujranwala', 'Pakistan'),
		(3552, 'pakistan/narowal', 'Narowal', 'Pakistan'),
		(3553, 'france/royan', 'Royan', 'France'),
		(3554, 'maldives/addu-city', 'Addu-city', 'Maldives'),
		(3555, 'maldives/kulhudhuffushi', 'Kulhudhuffushi', 'Maldives'),
		(3556, 'mali/sikasso', 'Sikasso', 'Mali'),
		(3557, 'mali/koutiala', 'Koutiala', 'Mali'),
		(3558, 'mauritania/nouadhibou', 'Nouadhibou', 'Mauritania'),
		(3559, 'mauritania/rosso', 'Rosso', 'Mauritania'),
		(3560, 'moldova/balti', 'Balti', 'Moldova'),
		(3561, 'mongolia/erdenet', 'Erdenet', 'Mongolia'),
		(3562, 'mongolia/darkhan', 'Darkhan', 'Mongolia'),
		(3563, 'montenegro/niksic', 'Niksic', 'Montenegro'),
		(3564, 'montenegro/pljevlja', 'Pljevlja', 'Montenegro'),
		(3565, 'mozambique/beira', 'Beira', 'Mozambique'),
		(3566, 'mozambique/nampula', 'Nampula', 'Mozambique'),
		(3567, 'nepal/biratnagar', 'Biratnagar', 'Nepal'),
		(3568, 'nicaragua/masaya', 'Masaya', 'Nicaragua'),
		(3569, 'niger/zinder', 'Zinder', 'Niger'),
		(3570, 'niger/maradi', 'Maradi', 'Niger'),
		(3571, 'niger/agadez', 'Agadez', 'Niger'),
		(3572, 'nigeria/ibadan', 'Ibadan', 'Nigeria'),
		(3573, 'north-korea/hamhung', 'Hamhung', 'North Korea'),
		(3574, 'north-korea/chongjin', 'Chongjin', 'North Korea'),
		(3575, 'oman/seeb', 'Seeb', 'Oman'),
		(3576, 'oman/salalah', 'Salalah', 'Oman'),
		(3577, 'papua-new-guinea/lae', 'Lae', 'Papua New Guinea'),
		(3578, 'papua-new-guinea/arawa', 'Arawa', 'Papua New Guinea'),
		(3579, 'puerto-rico/ponce', 'Ponce', 'Puerto Rico'),
		(3580, 'puerto-rico/caguas', 'Caguas', 'Puerto Rico'),
		(3581, 'uk/haywards-heath', 'Haywards-heath', 'United Kingdom'),
		(3582, 'usa/ontario-or', 'Ontario-or', 'United States'),
		(3583, 'netherlands/wageningen', 'Wageningen', 'Netherlands'),
		(3584, 'fiji/nadi', 'Nadi', 'Fiji'),
		(3585, 'qatar/al-khor', 'Al-khor', 'Qatar'),
		(3586, 'qatar/al-jamiliyah', 'Al-jamiliyah', 'Qatar'),
		(3587, 'reunion/saint-pierre', 'Saint-pierre', 'Reunion'),
		(3588, 'rwanda/butare', 'Butare', 'Rwanda'),
		(3589, 'rwanda/gitarama', 'Gitarama', 'Rwanda'),
		(3590, 'saint-lucia/vieux-fort', 'Vieux-fort', 'Saint Lucia'),
		(3591, 'south-africa/worcester', 'Worcester', 'South Africa'),
		(3592, 'uk/worcester', 'Worcester', 'United Kingdom'),
		(3593, 'senegal/touba', 'Touba', 'Senegal'),
		(3594, 'senegal/thies', 'Thies', 'Senegal'),
		(3595, 'sierra-leone/bo', 'Bo', 'Sierra Leone'),
		(3596, 'sierra-leone/kenema', 'Kenema', 'Sierra Leone'),
		(3597, 'slovakia/presov', 'Presov', 'Slovakia'),
		(3598, 'somalia/bosaso', 'Bosaso', 'Somalia'),
		(3599, 'spain/huesca', 'Huesca', 'Spain'),
		(3600, 'india/shupiyan', 'Shupiyan', 'India'),
		(3601, 'usa/charlottesville', 'Charlottesville', 'United States'),
		(3602, 'usa/wheaton', 'Wheaton', 'United States'),
		(3603, 'india/kakinada', 'Kakinada', 'India'),
		(3604, 'canada/brockville', 'Brockville', 'Canada'),
		(3605, 'colombia/san-andres', 'San-andres', 'Colombia'),
		(3606, 'south-sudan/malakal', 'Malakal', 'South Sudan'),
		(3607, 'south-sudan/wau', 'Wau', 'South Sudan'),
		(3608, 'sudan/port-sudan', 'Port-sudan', 'Sudan'),
		(3609, 'sudan/kassala', 'Kassala', 'Sudan'),
		(3610, 'suriname/nieuw-nickerie', 'Nieuw-nickerie', 'Suriname'),
		(3611, 'swaziland/manzini', 'Manzini', 'Swaziland'),
		(3612, 'swaziland/big-bend', 'Big-bend', 'Swaziland'),
		(3613, 'tajikistan/khujand', 'Khujand', 'Tajikistan'),
		(3614, 'tajikistan/kulob', 'Kulob', 'Tajikistan'),
		(3615, 'tanzania/mwanza', 'Mwanza', 'Tanzania'),
		(3616, 'thailand/hat-yai', 'Hat-yai', 'Thailand'),
		(3617, 'timor-leste/same', 'Same', 'East Timor'),
		(3618, 'timor-leste/suai', 'Suai', 'East Timor'),
		(3619, 'togo/sokode', 'Sokode', 'Togo'),
		(3620, 'togo/kara', 'Kara', 'Togo'),
		(3621, 'tonga/neiafu', 'Neiafu', 'Tonga'),
		(3622, 'tonga/pangai', 'Pangai', 'Tonga'),
		(3623, 'trinidad-and-tobago/chaguanas', 'Chaguanas', 'Trinidad and Tobago'),
		(3624, 'trinidad-and-tobago/san-fernando', 'San-fernando', 'Trinidad and Tobago'),
		(3625, 'trinidad-and-tobago/scarborough', 'Scarborough', 'Trinidad and Tobago'),
		(3626, 'tunisia/sfax', 'Sfax', 'Tunisia'),
		(3627, 'tunisia/kairouan', 'Kairouan', 'Tunisia'),
		(3628, 'turkmenistan/turkmenabat', 'Turkmenabat', 'Turkmenistan'),
		(3629, 'turkmenistan/dasoguz', 'Dasoguz', 'Turkmenistan'),
		(3630, 'uganda/gulu', 'Gulu', 'Uganda'),
		(3631, 'uganda/lira', 'Lira', 'Uganda'),
		(3632, 'uzbekistan/namangan', 'Namangan', 'Uzbekistan'),
		(3633, 'uzbekistan/andijan', 'Andijan', 'Uzbekistan'),
		(3634, 'india/tehri', 'Tehri', 'India'),
		(3635, 'usa/tyler', 'Tyler', 'United States'),
		(3636, 'canada/churchill', 'Churchill', 'Canada'),
		(3637, 'pakistan/sukkur', 'Sukkur', 'Pakistan'),
		(3638, 'iran/ahvaz', 'Ahvaz', 'Iran'),
		(3639, 'iran/kashan', 'Kashan', 'Iran'),
		(3640, 'iran/yazd', 'Yazd', 'Iran'),
		(3641, 'iran/gorgan', 'Gorgan', 'Iran'),
		(3642, 'vanuatu/luganville', 'Luganville', 'Vanuatu'),
		(3643, 'india/belgaum', 'Belgaum', 'India'),
		(3644, 'west-bank/tulkarm', 'Tulkarm', 'West Bank'),
		(3645, 'western-sahara/dakhla', 'Dakhla', 'Western Sahara'),
		(3646, 'western-sahara/smara', 'Smara', 'Western Sahara'),
		(3647, 'yemen/ta-izz', 'Ta-izz', 'Yemen'),
		(3648, 'yemen/al-hudaydah', 'Al-hudaydah', 'Yemen'),
		(3649, 'zambia/kitwe', 'Kitwe', 'Zambia'),
		(3650, 'zambia/ndola', 'Ndola', 'Zambia'),
		(3651, 'india/kodaikanal', 'Kodaikanal', 'India'),
		(3652, 'uk/perth', 'Perth', 'United Kingdom'),
		(3653, 'china/changde', 'Changde', 'China'),
		(3654, 'usa/lewiston', 'Lewiston', 'United States'),
		(3655, 'bosnia-herzegovina/capljina', 'Capljina', 'Bosnia and Herzegovina'),
		(3656, 'india/tenkasi', 'Tenkasi', 'India'),
		(3657, 'tanzania/bukoba', 'Bukoba', 'Tanzania'),
		(3658, 'france/martin-de-vivies-amsterdam-island', 'Martin-de-vivies-amsterdam-island', 'France'),
		(3659, 'usa/sevierville', 'Sevierville', 'United States'),
		(3660, 'bosnia-herzegovina/medjugorje', 'Medjugorje', 'Bosnia and Herzegovina'),
		(3661, 'india/courtallam', 'Courtallam', 'India'),
		(3662, 'usa/stroudsburg', 'Stroudsburg', 'United States'),
		(3663, 'china/langfang', 'Langfang', 'China'),
		(3664, 'portugal/leiria', 'Leiria', 'Portugal'),
		(3665, 'netherlands/leerdam', 'Leerdam', 'Netherlands'),
		(3666, 'usa/dickinson', 'Dickinson', 'United States'),
		(3667, 'spain/ibiza', 'Ibiza', 'Spain'),
		(3668, 'france/perigueux', 'Perigueux', 'France'),
		(3669, 'russia/novorossiysk', 'Novorossiysk', 'Russia'),
		(3670, 'israel/karmiel', 'Karmiel', 'Israel'),
		(3671, 'bolivia/tarija', 'Tarija', 'Bolivia'),
		(3672, 'cuba/santa-clara', 'Santa-clara', 'Cuba'),
		(3673, 'czech-republic/liberec', 'Liberec', 'Czech Republic'),
		(3674, 'ecuador/santo-domingo', 'Santo-domingo', 'Ecuador'),
		(3675, 'egypt/port-said', 'Port-said', 'Egypt'),
		(3676, 'egypt/suez', 'Suez', 'Egypt'),
		(3677, 'eritrea/assab', 'Assab', 'Eritrea'),
		(3678, 'philippines/surigao', 'Surigao', 'Philippines'),
		(3679, 'uk/guildford', 'Guildford', 'United Kingdom'),
		(3680, 'india/baramati', 'Baramati', 'India'),
		(3681, 'faroe/klaksvik', 'Klaksvik', 'Faroe Islands'),
		(3682, 'guinea/kindia', 'Kindia', 'Guinea'),
		(3683, 'india/thodupuzha', 'Thodupuzha', 'India'),
		(3684, 'india/ashta', 'Ashta', 'India')";

		require_once(ABSPATH.'wp-admin/includes/upgrade.php');		
		dbDelta($sql1);
		dbDelta($sql2);
		dbDelta($sql3);
		dbDelta($sql4);
		dbDelta($sql5);
	} 

}

// call google_hangout_create_location to check all db fields are exist or not
google_hangout_create_location();


/* function name: ghangout_themes_option_menu
   Description:  ghangout_themes_option_menu funciton is used to Create Admin menu for Runclick.
*/
function ghangout_themes_option_menu(){
	global $status;
	$payment_id			=	get_option('umo_hangout_payment_id');
	$activation_key		=	get_option('umo_hangout_activation_key');
	$requesturl			=	get_option('umo_hangout_licenceurl');
	$icon_url			=	plugin_dir_url(__FILE__)."images/google_hangout.png";
	add_menu_page('Run Click Webinar Plugin','G RunClick','administrator','google_hangout','wp_hangout_activation',$icon_url,8);
	
	add_submenu_page('google_hangout','Run Click Webinar Plugin','Activation','administrator','google_hangout','wp_hangout_activation');
	
	/* Checking Activation key */
	if( strtotime(get_option('hangout_check_license_date',true)) != strtotime(date('d-m-Y')))
	{
	
	if( preg_match('/^(http:\/\/|www.|https:\/\/)+[a-z0-9\-]/',$requesturl,$matches) )
		{		
			if($requesturl && $payment_id && $activation_key)
			{
				$datastring			=	"client_licence=$activation_key&client_url=".site_url()."&email=$payment_id";
				
				$requesturl			.=	'wp-content/plugins/ghangout_main/licenc_test.php';
				
				$result				=	umo_hangout_requestServer($requesturl,$datastring);
				
				$result['result'] = (array) $result['result'];
				$status['result'] = (array) $result['result'];
				
				if( $result['result']['error']==0 )
				
				{
					
					add_submenu_page('','G RunClick Export','G RunClick Export','administrator','google_hangout_export','wp_google_hangout_export');
					
					add_submenu_page('','G RunClick Export','G RunClick Export','administrator','google_hangout_broadcast','wp_google_hangout_broadcast');
					
					add_submenu_page('','Manage G RunClick','Manage G RunClick','administrator','manage_hangout','wp_manage_hangout');
	
					
					
					
					update_option('hangout_check_license_date',date('d-m-Y'));

				
				}
				else
				{
					add_action('admin_notices','umo_hangout_pleaseactivate');
				}
			}
			else
			{
					add_action('admin_notices','umo_hangout_pleaseactivate');
			}
		}
		else
		{
				add_action('admin_notices','umo_hangout_pleaseactivate');
		}
		
	} 
	else{		
		add_submenu_page('','G RunClick Export','G RunClick Export','administrator','google_hangout_export','wp_google_hangout_export');
		
		add_submenu_page('','G RunClick Export','G RunClick Export','administrator','google_hangout_broadcast','wp_google_hangout_broadcast');
	
		add_submenu_page('','Manage G RunClick','Manage G RunClick','administrator','manage_hangout','wp_manage_hangout');
		
		
		$status['result']['error']=0; 
	}
}
/* End of Adding Menu*/

/* function name:umo_hangout_pleaseactivate
   Description:  umo_hangout_pleaseactivate funciton is used to Show msg for Activate Plugin.
*/
function umo_hangout_pleaseactivate()
{
	echo '<div id="server-seo-perm-message" class="error" style=" height: 44px !important; padding-top: 5px !important;"><p><strong>Please activate </strong> Webinar plugin. </p></div>';

}
 
/* function name: wp_hangout_activation
   Description:  wp_hangout_activation funciton is to show screen of activation screen or main plugin screen depend on status.
*/
function wp_hangout_activation(){
	global $status;
	//check is plugin active or not
	if($status['result']['error'] == '0')
	{ 
		
 
		include('main_hangout.php') ;
	}
	else
	{
		include('activation.php') ;
	}
}	
/* End Activation Code here */


/* function name: umo_hangout_requestServer
   Description:  umo_hangout_requestServer funciton is used to handle all curl requests.
*/
function umo_hangout_requestServer($serverurl,$datastring)
{
	
	$ch		=	curl_init($serverurl);
	
	curl_setopt($ch,CURLOPT_POST,true);
	
	//curl_setopt($ch,CURLOPT_POSTFIELDS,'action=check&plugin_slug=seo_child&plugin_version=1.0.0');
	
	curl_setopt($ch,CURLOPT_POSTFIELDS,$datastring);
	
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	
	$output	=	curl_exec($ch);
	
	if($output === false)
	{
		curl_close($ch); 
		$response	=	"<response><update>0</update><version>0</version></response>";
		return $response;
	}
	else
	{
		curl_close($ch); //free system resources

		//$response	=	simplexml_load_string($output);
		
		$response	=	(array) $response;
		
		return $response;
	}

	
}

/* function name: ghangout_stylesheet_include
   Description:  ghangout_stylesheet_include funciton is used to include all stylesheet.
*/
function ghangout_stylesheet_include(){
	wp_register_style('jquery-core-ui-css', 'http://code.jquery.com/ui/1.7.3/themes/smoothness/jquery-ui.css');
	wp_enqueue_style('jquery-core-ui-css' );
	wp_register_style('jquery-google-font-css', 'http://fonts.googleapis.com/css?family=Kristi|Crafty+Girls|Yesteryear|Finger+Paint|Press+Start+2P|Spirax|Bonbon|Over+the+Rainbow');
	wp_enqueue_style('jquery-google-font-css');
	wp_register_style('prefix-style-timepicker-css', plugins_url('css/jquery-ui-timepicker-addon.css', __FILE__) );
	wp_enqueue_style('prefix-style-timepicker-css' );

	wp_register_style('prefix-style-source-css', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro');
	wp_enqueue_style('prefix-style-source-css' );

	wp_register_style('prefix-style-roboto-css', 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' );
	wp_enqueue_style('prefix-style-roboto-css' );
		wp_register_style('prefix-style-custom-css', plugins_url('custom-style.css', __FILE__) );
	wp_enqueue_style('prefix-style-custom-css' );

	wp_register_style('prefix-style-awesome-css', plugins_url('css/font-awesome.css', __FILE__) );
	wp_enqueue_style('prefix-style-awesome-css' );
}
/* End of including css files*/

/* function name: g_hangout_style_include
   Description:  g_hangout_style_include function is used to include stylesheet for timer.
*/
function g_hangout_style_include(){
		wp_register_style('prefix-style-countdown-css', plugins_url('css/countdown.css', __FILE__) );
		wp_enqueue_style('prefix-style-countdown-css' );
	
}
add_action( 'wp_enqueue_scripts', 'g_hangout_style_include');

/* function name: hangout_admin_scripts_method
   Description:  hangout_admin_scripts_method function is used to include JS for admin section.
*/
function hangout_admin_scripts_method() {
   
        wp_enqueue_script(
          'jquery-ui-timepicker-addon',
          plugin_dir_url( __FILE__ ).'js/jquery-ui-timepicker-addon.js',
          array('jquery-ui-core' ,'jquery-ui-datepicker', 'jquery-ui-slider')
      );

      wp_enqueue_script(
          'datepicker-slider',
          plugin_dir_url( __FILE__ ).'js/jquery-ui-sliderAccess.js',
          array('jquery', 'jquery-ui-timepicker-addon')
      );

	  wp_enqueue_script(
          'popup-window',
          plugin_dir_url( __FILE__ ).'js/jquery.popupWindow.js'
      );
	  wp_enqueue_script(
          'custom-js',
          plugin_dir_url( __FILE__ ).'js/custom-js.js'
      );
	   wp_enqueue_script(
          'searchabledropdown',
          plugin_dir_url( __FILE__ ).'js/jquery.searchabledropdown-1.0.8.min.js'
      );

	  
  }
add_action( 'admin_head', 'hangout_admin_scripts_method' );


/* function name: hangout_front_scripts_method
   Description:  hangout_front_scripts_method function is used to include JS for front section.
*/
function hangout_front_scripts_method(){

}
add_action( 'wp_head', 'hangout_admin_scripts_method' );
/* End of including JS files */




/* Class name: GoogleHangoutPlugin
   Description: GoogleHangoutPlugin class and included class is used to plugin i.
*/
if (!class_exists("GoogleHangoutPlugin")) :
			 
class GoogleHangoutPlugin 
 {
	
	/* function name: install
	   Description:  install function is used to install plugin in wordpress.
	*/
	 static function install()
	{	 
			global $wpdb;
			update_option('umo_hangout_version','4.0.3');
	
			update_option('umo_hangout_licenceurl','http://hangoutplugin.com/');
	
			update_option('umo_hangout_update_running',0);
	
			update_option('umo_hangout_update_files',0);
			$sql1 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."google_hangout_subscriber` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `g_event_id` int(11) NOT NULL,
					  `name` varchar(255) NOT NULL,
					  `email` varchar(255) NOT NULL,
					  `auto_reminder` tinyint(1) DEFAULT NULL,
					  `24_hour` tinyint(1) DEFAULT NULL,
					  `1_hour` tinyint(1) DEFAULT NULL,
					  `5_min` tinyint(1) DEFAULT NULL,
					  `add_email` varchar(255) DEFAULT NULL,
					  `joining_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
					  `organization` varchar(255) DEFAULT NULL,
					  `hangout_date` date,
					  `hangout_time` varchar(255),
					  `reminder_time`  varchar(255),
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";

					  
				$sql2 = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."reminder` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `subject` varchar(255) NOT NULL,
						  `body` text NOT NULL,
						  `reminder_time` varchar(255) NOT NULL,
						  `reminder_type` varchar(255) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
						
				$sql3	=	"CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."ghangout_stats` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `post_id` int(11) NOT NULL,
							  `IP` varchar(225) NOT NULL,
							  `event` int(11) NOT NULL,
							  `thankyou` int(11) NOT NULL,
							  `live` int(11) NOT NULL,
							  `replay` int(11) NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6" ;
				
				$sql4	=	"CREATE TABLE `testing_cron` (
							  `id` int(11) NOT NULL auto_increment,
							  `entry` varchar(225) NOT NULL,
							  PRIMARY KEY  (`id`)
							)";
				$sql5	=	"CREATE TABLE IF NOT EXISTS `hangout_vote` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `hangout_id` int(11) NOT NULL,
							  `answer` varchar(225) NOT NULL,
							  `ipaddress` varchar(225) NOT NULL,
							  `option_number` int(11),
							  `created_date` timestamp NOT NULL,
							  PRIMARY KEY (`id`)
							) " ;
							
				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
					dbDelta($sql1);
					
					dbDelta($sql2);

					dbDelta($sql3);
					
					dbDelta($sql4);
					dbDelta($sql5);
					
			update_option( 'hangout_youtube_user_id', '', '', 'yes' );  
			update_option( 'hangout_youtube_affiliate_link', '', '', 'yes' );  
			update_option('g_hangout_reminder_subject', 'Your Webinar Begins {date} {time}');
			update_option('g_hangout_reminder_msg', 'For: {name}, 

			Just a quick reminder - Your Webinar with us: {eventName}

			Will begin {time} hours from now
			Please come to this link at the time

			{eventlinkURL}

			See you Soon. ');

			update_option('g_hangout_subscriber_subject', ' Thanks For Registering. Your Webinar Details Included');
			update_option('g_hangout_subscriber_msg', 'For {name}, 

			Thanks for registering for our Webinar {eventName}

			You will be able to join the event at this link
			{eventlinkURL}

			At the following time: {date}  {time}

			please join us then. 

			See You Soon!');
			update_option('g_project_id', '', '', 'yes' );
			
			$reoccurence		=	'60perhour';
			$reminderoccurence	=	'12perhour';
			$followoccurence	=	'12perhour';
			
		
			//De-activate all cron schedule
				
			

			// Set cron for events*/
			wp_schedule_event( time(), $reoccurence, 'hangout_cron_event');
			wp_schedule_event( time(), $reminderoccurence, 'hangout_reminder_cron_event');
			wp_schedule_event( time(), $followoccurence, 'hangout_follow_cron_event');
			//flush_rewrite_rules(false);
		}
	
	/* function name: uninstall
	   Description:  install function is used to uninstall plugin in wordpress.
	*/
	static function uninstall()
	{	 
		  			global $wpdb;
					wp_clear_scheduled_hook('hangout_cron_event');	
					wp_clear_scheduled_hook('hangout_reminder_cron_event');			
					wp_clear_scheduled_hook('hangout_follow_cron_event');		
					$templateFile1 = 'single-ghangout.php';
					$templateFile2 = 'ghangout-style.php';
					$themeFolder = strstr(get_bloginfo('template_directory'),'wp-content/themes/');
					if(file_exists(ABSPATH.$themeFolder.'/'.$templateFile1)) unlink(ABSPATH.$themeFolder.'/'.$templateFile1);
					if(file_exists(ABSPATH.$themeFolder.'/'.$templateFile2))unlink(ABSPATH.$themeFolder.'/'.$templateFile2);
	  
			
	  }
 }
endif; 



/* function name: hangout_js_callbacks
   Description:  install hangout_js_callbacks is used to run custom javascript code.
*/
function hangout_js_callbacks()
	{
		?>	
	<script>
	jQuery(function($){
		$(document).ready(function(){
			

				$('input[name=hangout_right_timer]').click(function(){
						if($('input[name=hangout_right_timer]:checked', '#hangout_manage').val()=="0"){
							$('#hangout_day_light').show();
						} else {
							$('#hangout_day_light').hide();
						}
				});

				$('#ghangout_end_timezone').datetimepicker({
				timeFormat: 'hh:mm tt z'
				});
				$('#hangout_timezone_start_date').datetimepicker({
				timeFormat: 'hh:mm tt z'
				});

				$('.ghangout').popupWindow({ 
					height:600, 
					width:900, 
					top:30, 
					left:30 
				}); 


				$('input[name=hangout_registration]').click(function(){
						if($('input[name=hangout_registration]:checked', '#hangout_manage').val()=="1"){
							$('#hangout_registration_system').show();
							$('#send_notification').show();
							$('#reminder_status').show();
						} else {
							$('#hangout_registration_system').hide();
							$('#send_notification').hide();
							$('#reminder_status').hide();
							$('#aweber_html').hide();
							$('#getresponse_html').hide();
						}
			
				});
				
				
				
				$('input[name=hangout_registration_system]').click(function(){
					if($('input[name=hangout_registration_system]:checked', '#hangout_manage').val()=="2"){
							$('#aweber_html').show();
							$('#getresponse_html').hide();
							$('#send_notification').hide();
							$('#reminder_status').hide();
					}
					
					if($('input[name=hangout_registration_system]:checked', '#hangout_manage').val()=="3"){
							$('#aweber_html').hide();
							$('#getresponse_html').show();
							$('#send_notification').hide();
							$('#reminder_status').hide();
					}
					if($('input[name=hangout_registration_system]:checked', '#hangout_manage').val()=="1"){
							$('#aweber_html').hide();
							$('#getresponse_html').hide();
							$('#send_notification').show();
							$('#reminder_status').show();
							
					}
					

				});

				$('input[name=g_hangout_layout_type]').click(function(){
						if($('input[name=g_hangout_layout_type]:checked', '#hangout_manage').val()=="1"){
							$('#option2layout').hide();
							$('#option1layout').show();

						} else {
							$('#option1layout').show();
							$('#option2layout').show();
						}
			
				});
				$('input[name=hangout_send_notifications]').click(function(){
						if($('input[name=hangout_send_notifications]:checked', '#hangout_manage').val()=="1"){
							
							$('#reminder_status').show();
						} else {
							$('#reminder_status').hide();
						}
			
				});
				$('#add_additional_reminder').click(function(){
					var auto_resp_data = '<div class="row-fluid-outer"> <div class="row-fluid"><div class="span4">Name </div><div class="span8"><input type="text" name="auto_resp_name[]"></div><div class="span4"> Subject</div><div class="span8"><input type="text" name="auto_resp_subject[]"></div><div class="span4"> Body</div><div class="span8"><textarea  name="auto_resp_body[]" cols="80" rows="10"></textarea></div> <div class="span4">How long before</div><div class="span8">Days : <select name="auto_resp_days[]"><option value="30">30</option><option value="29">29</option><option value="28">28</option><option value="27">27</option><option value="26">26</option><option value="25">25</option><option value="24">24</option><option value="23">23</option><option value="22">22</option><option value="21">21</option><option value="20">20</option><option value="19">19</option><option value="18">18</option><option value="17">17</option><option value="16">16</option><option value="15">15</option><option value="14">14</option><option value="13">13</option><option value="12">12</option><option value="11">11</option><option value="10">10</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option><option value="0" selected>0</option></select> Hour  : <select name="auto_resp_hour[]"><option value="23">23</option><option value="22">22</option><option value="21">21</option><option value="20">20</option><option value="19">19</option><option value="18">18</option><option value="17">17</option><option value="16">16</option><option value="15">15</option><option value="14">14</option><option value="13">13</option><option value="12">12</option><option value="11">11</option><option value="10">10</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option><option value="0" selected>0</option></select> Minutes : <select name="auto_resp_minutes[]"><option value="55">55</option><option value="50">50</option><option value="45">45</option><option value="40">40</option><option value="35">35</option><option value="30">30</option><option value="25">25</option><option value="20">20</option><option value="15">15</option><option value="10">10</option><option value="5">5</option><option value="0">0</option></select></div><div class="gh_block_btn"><button type="submit" class="hangout_btn event_delete"><i class="icon-trash"></i> Delete</button></div></div></div>';
					$('#reminder_data').append(auto_resp_data);

				});

				$('#add_follow_up_reminder').click(function(){
					var auto_resp_data = '<div class="row-fluid-outer"> <div class="row-fluid"><div class="span4">Name </div><div class="span8"><input type="text" name="follow_auto_resp_name[]"></div><div class="span4">Subject</div><div class="span8"><input type="text" name="follow_auto_resp_subject[]"></div><div class="span4">Body</div><div class="span8"><textarea  name="follow_auto_resp_body[]" cols="80" rows="10"></textarea></div> <div class="span4">How long After</div><div class="span8">Days : <select name="follow_auto_resp_days[]"><option value="30">30</option><option value="29">29</option><option value="28">28</option><option value="27">27</option><option value="26">26</option><option value="25">25</option><option value="24">24</option><option value="23">23</option><option value="22">22</option><option value="21">21</option><option value="20">20</option><option value="19">19</option><option value="18">18</option><option value="17">17</option><option value="16">16</option><option value="15">15</option><option value="14">14</option><option value="13">13</option><option value="12">12</option><option value="11">11</option><option value="10">10</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option><option value="0" selected>0</option></select> Hour  : <select name="follow_auto_resp_hour[]"><option value="23">23</option><option value="22">22</option><option value="21">21</option><option value="20">20</option><option value="19">19</option><option value="18">18</option><option value="17">17</option><option value="16">16</option><option value="15">15</option><option value="14">14</option><option value="13">13</option><option value="12">12</option><option value="11">11</option><option value="10">10</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option><option value="0" selected>00</option></select> Minutes : <select name="follow_auto_resp_minutes[]"><option value="55">55</option><option value="50">50</option><option value="45">45</option><option value="40">40</option><option value="35">35</option><option value="30">30</option><option value="25">25</option><option value="20">20</option><option value="15">15</option><option value="10">10</option><option value="5">5</option><option value="0">0</option></select></div><div class="gh_block_btn"><button type="submit" class="hangout_btn event_delete"><i class="icon-trash"></i> Delete</button></div></div></div>';
					$('#follow_reminder_data').append(auto_resp_data);

				});
				$(document).on('click','.event_delete', function(){
					$(this).parent().parent().parent().remove();
				});

				// code for fatch you tube url
		$('#get_youtube_details').click(function(){
				
					$.ajax({
					  type: "POST",
					  url:'<?php echo plugin_dir_url(__FILE__);?>fetchyoutube.php',
					  data: { 'test':'dsdsfd'}
					}).done(function(data) {
						if(data=='error'){
							alert('Please start Google Webinar on Air');
						} else {
							youtubearr = data.split('|--||--');
							
						  youtubelink = 'http://youtu.be/'+youtubearr[0];
						  youtubeembcode = '<iframe width="420" height="315" src="http://www.youtube.com/embed/'+ youtubearr[0] +'?wmode=transparent" frameborder="" wmode="Opaque" allowfullscreen></iframe>';
						  g_hangout_title = youtubearr[1];
							$('#hangout_youtube_src').val(youtubearr[0]);
						  $('#hangout_youtube').val(youtubelink);
						  $('#hangout_emb_code').val(youtubeembcode);
						  $('#hangout_title').val(g_hangout_title);
						}
					});
					

					
					return false;
				});
			
		
				
				
				$('#start_ghangout').click(function(){
					$('#get_youtube_details_cointainer').show();
					$('#youtube_video_size_cont').show();
				});

				$('#youtube_video_size').change(function(){
						if($('#hangout_youtube_src').val()){
							data = $('#youtube_video_size').val().split(' x ');
							
							ysrc = $('#hangout_youtube_src').val();
							youtubeembcode = '<iframe width="'+ data[0]+'" height="'+ data[1]+'" src="http://www.youtube.com/embed/'+ ysrc +'?wmode=transparent" frameborder="" wmode="Opaque" allowfullscreen></iframe>';
							
							$('#hangout_emb_code').val(youtubeembcode);
						}
				});

				/* Replan page JS */
				$('input[name=hangout_lock_replay]').click(function(){
					if($('input[name=hangout_lock_replay]:checked').val()=="0"){
						$('#hangout_replay_autoresponder').hide();
						$('#hangout_replay_registration_system').hide();
					} else {
						$('#hangout_replay_registration_system').show();
						if($('#hangout_replan_registration_system').val()!="Default"){
							$('#hangout_replay_autoresponder').show();
						}
					}
				});
				// code for reg system edit by thath singh ////
				$('#hangout_registration_system_option').change(function(){
				//alert($('#hangout_registration_system_option').val());
					
					
					if($('#hangout_registration_system_option').val() == "Default")
				{
					$("#hangout_autoresponder").hide();
				}
				else if($('#hangout_registration_system_option').val() == "Mailchimp")
				{ 
					$("#hangout_autoresponder").show();
					$("#ImnicaMail").hide();
					$("#Mailchimp").show();
					$("#Icontact").hide();
					$("#Other").hide();
					$("#GetResponce").hide();
					$("#Sendreach").hide();
					$("#Aweber").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").hide();
				}
				else if($('#hangout_registration_system_option').val() == "ImnicaMail")
				{ 
					$("#hangout_autoresponder").show();
					$("#ImnicaMail").show();
					$("#Mailchimp").hide();
					$("#Icontact").hide();
					$("#Other").hide();
					$("#GetResponce").hide();
					$("#Sendreach").hide();
					$("#Aweber").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").hide();
				}
				else if($('#hangout_registration_system_option').val() == "Icontact")
				{ 
					$("#hangout_autoresponder").show();
					$("#ImnicaMail").hide();
					$("#Icontact").show();
					$("#Mailchimp").hide();
					$("#Other").hide();
					$("#GetResponce").hide();
					$("#Sendreach").hide();
					$("#Aweber").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").hide();
				}
				else if($('#hangout_registration_system_option').val() == "GetResponce")
				{ 
					$("#hangout_autoresponder").show();
					$("#ImnicaMail").hide();
					$("#GetResponce").show();
					$("#Mailchimp").hide();
					$("#Icontact").hide();
					$("#Other").hide();
					$("#Sendreach").hide();
					$("#Aweber").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").hide();
				}
				else if($('#hangout_registration_system_option').val() == "Aweber")
				{ 
					$("#hangout_autoresponder").show();
					$("#ImnicaMail").hide();
					$("#Aweber").show();
					$("#GetResponce").hide();
					$("#Mailchimp").hide();
					$("#Icontact").hide();
					$("#Sendreach").hide();
					$("#Other").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").hide();
				}
				else if($('#hangout_registration_system_option').val() == "Sendreach")
				{ 
					$("#hangout_autoresponder").show();
					$("#Sendreach").show();
					$("#ImnicaMail").hide();
					$("#Icontact").hide();
					$("#Other").hide();
					$("#Mailchimp").hide();
					$("#GetResponce").hide();
					$("#Aweber").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").hide();
				}	
				else if($('#hangout_registration_system_option').val() == "InfusionSoft")
				{ 
					$("#hangout_autoresponder").show();
					$("#InfusionSoft").show();
					$("#Sendreach").hide();
					$("#ImnicaMail").hide();
					$("#Icontact").hide();
					$("#Other").hide();
					$("#Mailchimp").hide();
					$("#GetResponce").hide();
					$("#Aweber").hide();
					$("#hangout_othersresponder").hide();
				}	
				else if($('#hangout_registration_system_option').val() == "Other")
				{ 
					$("#hangout_autoresponder").show();
					$("#ImnicaMail").hide();
					$("#Icontact").hide();
					$("#Other").show();
					$("#Mailchimp").hide();
					$("#GetResponce").hide();
					$("#Sendreach").hide();
					$("#Aweber").hide();
					$("#InfusionSoft").hide();
					$("#hangout_othersresponder").show();
				}
				
					
				});
				// code for aweber setting add by thath singh ////
					var g_hangout = {"ajaxurl": "<?php echo site_url(); ?>\/wp-admin\/admin-ajax.php","plugin_url":"<?php echo site_url(); ?>\/wp-content\/plugins\/RunClickPlugin","tr_no_one_online":"No one is online","tr_logout":"Logout","tr_sending":"Sending","tr_in_chat_header":"Now Chatting","tr_offline_header":"Contact us","use_css_anim":"1","delay":"2","is_admin":"","is_op":"1"};

					$('#set_connection').click(function(){
					var auth_code=$('#hangout_Aweber_auth_code').val();
					var data = {
					action: 'ghangout_aweber_set_up',
					auth_code : auth_code

					};
					$.post(g_hangout.ajaxurl, data, function(response) {

					$('#set_up_data').html(response);
					});


					});
			
				
				
				$('#hangout_replan_registration_system').change(function(){
					if($(this).val()=="Default"){
						$('#hangout_replay_autoresponder').hide();
					} else {
						$('#hangout_replay_autoresponder').show();
					}
				});
				

				$('input[name=g_hangout_make_live_layout_type]').click(function(){
						
						if($('input[name=g_hangout_make_live_layout_type]:checked').val()=="1"){
							$('#liveoption2layout').hide();
							$('#liveoption1layout').show();

						} else {
							
							$('#liveoption1layout').show();
							$('#liveoption2layout').show();
						}

				});

				$('input[name=g_hangout_replan_layout_type]').click(function(){
						
						if($('input[name=g_hangout_replan_layout_type]:checked').val()=="1"){
							$('#replayoption2layout').hide();
							$('#replayoption1layout').show();

						} else {
							
							$('#replayoption1layout').show();
							$('#replayoption2layout').show();
						}

				});
				
		});
	});
	jQuery(document).ready(function(){
        jQuery('.label_radio').click(function(){
            setupLabel();
        });
        
        setupLabel(); 
    });

	function setupLabel() {
		    if (jQuery('.label_radio input').length) {
		        jQuery('.label_radio').each(function(){ 
		            jQuery(this).removeClass('r_on');
		        });
		        jQuery('.label_radio input:checked').each(function(){ 
		            jQuery(this).parent('label').addClass('r_on');
		        });
		    }
		}
		
		jQuery(document).ready(function($){
	
	$("#thanks_gift_yes").click(function(){
	$("#gift_setting").show();
	
	});
	$("#thanks_gift_no").click(function(){
	$("#gift_setting").hide();
	
	});
	
	});
		
		
		
	</script>
	<?php } 
add_action( 'admin_head', 'hangout_js_callbacks');

function hangout_js_front_callbacks(){ ?>
<script>

</script>
<?php }
add_action('wp_head', 'hangout_js_front_callbacks');

/* function name: wp_google_hangout_make_it_live
   Description:  wp_google_hangout_make_it_live is used to show live page.
*/
function wp_google_hangout_make_it_live(){
	require_once('hangout_make_it_live.php');
}

/* function name: google_hangout, wp_ghangout_hangout
   Description:  google_hangout, wp_ghangout_hangout is used to show event listing page.
*/
function google_hangout(){
	require_once('hangout.php');
}
function wp_ghangout_hangout(){
		include('hangout.php');
}

/* function name: wp_google_hangout_subscriber
   Description:  wp_google_hangout_subscriber is used to show subscriber listing.
*/
function wp_google_hangout_subscriber(){
	require_once('hangout_subscriber.php');
}


/* function name: wp_add_g_hangout
   Description:  wp_add_g_hangout is used to add new .
*/
function wp_add_g_hangout(){
	require_once('add_hangout.php');
}

/* function name: wp_g_hangout_settings
   Description:  wp_g_hangout_settings is used to show settings .
*/
function wp_g_hangout_settings(){
	require_once('ghangout_setting.php');
}

/* function name: g_hangout_include
   Description:  g_hangout_include is used to include files .
*/
function g_hangout_include()
{
	require_once('paging.php');
}
add_action('init','g_hangout_include');

/* function name: event_registration
   Description:  event_registration is used to show event registration form in frontend.
*/
function event_registration(){
	global $post;

    
        require_once('event_reg.php');
		return $content1;
	
}
add_shortcode('ghangout_reg_form','event_registration');

function replay_event_registration(){
	global $post;

    
        require_once('replay_event_reg.php');
		return $content1;
	
}
add_shortcode('ghangout_replan_reg_form','replay_event_registration');

/* function name: hangout_event_timer
   Description:  hangout_event_timer is used to show event timer in frontend.
*/
function hangout_event_timer(){
	global $post;

    
        require_once('event_timer.php');
		return $content1;
	
}

add_shortcode('ghangout_timer','hangout_event_timer');
add_shortcode('live_hangout','hangout_event_timer');
function hangout_replay_event_timer(){
	global $post;

    
        require_once('replay_event_timer.php');
		return $content1;
	
}
add_shortcode('ghangout_replan_timer','hangout_replay_event_timer');


/* function name: wp_google_follow_cron
   Description:  wp_google_follow_cron is used to run follow cron on each event.
*/
function wp_google_follow_cron(){
	require('follow_cron.php');
}
/* function name: wp_g_email_hangout
   Description:  wp_g_email_hangout is used send event.
*/
function wp_g_email_hangout(){
	require('ghangout_event_template.php');
}
/* function name: wp_google_hangout_export
   Description:  wp_google_hangout_export is used export subscriber.
*/
function wp_google_hangout_export(){
	require('hangout_subscriber_export.php');
}
/* function name: set_html_content_type
   Description:  set_html_content_type is used to set content type at the time of sending email.
*/
if(!function_exists(set_html_content_type)){
	function set_html_content_type()
	{
		return 'text/html';
	}
}

/* function name: get_remaining_hours
   Description:  get_remaining_hours is used to get remaining hours of event. This function is used when sending email or cron or timer
*/

function get_remaining_hours($hanogut_timezone,$hangout_day_light=0){
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	//$ip_addr =   '122.176.115.21';
	$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_addr) );
	$lat = $geoplugin['geoplugin_latitude'];
	$long = $geoplugin['geoplugin_longitude'];
	$geozone =  file_get_contents('http://www.earthtools.org/timezone/'.$lat.'/'.$long) ;
	$xml = simplexml_load_string($geozone);


	$nowarr = explode(" ",$xml->utctime);
	$nowdate = explode("-",$nowarr[0]);
	$nowmin = explode(":",$nowarr[1]);

	$now =  mktime($nowmin[0], $nowmin[1], $nowmin[2], $nowdate[1], $nowdate[2], $nowdate[0]);


	$enddatearr = explode(" ",$hanogut_timezone);
	$endate = explode("/",$enddatearr[0]);
	$enmin = explode(":",$enddatearr[1]);
	if($enddatearr[2]=="am"){ 
		$hour = $enmin[0];
		$min = $enmin[1];
	} else { 
		$hour = $enmin[0]+12;
		$min = $enmin[1];
	}

	$symbolz =  substr($enddatearr[3],0,1);

	$hourz = substr($enddatearr[3],1,2);

	$timez = substr($enddatearr[3],4,5);
	//$hangout_day_light = 	get_post_meta($post->ID,'hangout_day_light',true);

	if($symbolz=='+'){
		if($enddatearr[3]=="+0000"){
			$end =  mktime($hour-$hourz, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
		} else {
			if($hangout_day_light=="+1"){
				$end =  mktime(($hour-$hourz)+1, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
			} elseif($hangout_day_light=="-1"){
				$end =  mktime(($hour-$hourz)-1, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
			} else{
				$end =  mktime(($hour-$hourz), $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
			}
		}	
	} else {
			if($hangout_day_light=="+1"){
				$end =  mktime($hour+$hourz+1, $min+$timez, 0, $endate[0], $endate[1], $endate[2]);
				//$end =  mktime(($hour-$hourz)+1, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
			} elseif($hangout_day_light=="-1"){
				$end =  mktime($hour+$hourz-1, $min+$timez, 0, $endate[0], $endate[1], $endate[2]);
				//$end =  mktime(($hour-$hourz)-1, $min-$timez, 0, $endate[0], $endate[1], $endate[2]);
			} else{
				$end =  mktime($hour+$hourz, $min+$timez, 0, $endate[0], $endate[1], $endate[2]);
			}
		 
	}


	//echo $now;
	$nowd = date('Y-m-d H:i:s',$now);

	$endd = date('Y-m-d H:i:s',$end);

	$diff = abs(strtotime($endd) - strtotime($nowd)); 

	$years   = floor($diff / (365*60*60*24)); 
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

	$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

	$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 



	$return_str ='';
	if($years>0)$return_str .= $years.' Year ';
	if($months>0)$return_str .= $months.' months ';
	if($days>0)$return_str .= $days.' days ';
	if($hours>0)$return_str .= $hours.' hours ';
	$return_str .= $minuts.' minutes ';
	return $return_str;
}




/* function name: wp_google_hangout_cron
   Description:  wp_google_hangout_cron is used run cron jobs for sending emails
*/
function wp_google_hangout_cron(){
	require('cron.php');
}

//code handle the corn actions
add_action('hangout_cron_event_reminder', 'google_hangout_cron_reminder_mail');

/* function name: google_hangout_cron_reminder_mail
   Description:  google_hangout_cron_reminder_mail is used run cron jobs for reminder emails
*/
function google_hangout_cron_reminder_mail(){
	require('cron_reminder.php');
}

/* function name: wp_google_hangout_reminder_cron
   Description:  wp_google_hangout_reminder_cron is used run cron jobs for reminder emails
*/
function wp_google_hangout_reminder_cron(){
	require('cron_reminder.php');
}
		

/* function name: umo_g_hangout_details
   Description:  umo_g_hangout_details is used show registration form
*/
function umo_g_hangout_details($args){
	global $content;
	extract( shortcode_atts( array(
		'id' => '0'
		), $args ) );
		
		require_once('event_registration_shortcode.php');
		return $content;
}
add_shortcode('umo_g_hangout', 'umo_g_hangout_details');


/* function name: wp_google_hangout_replay
   Description:  wp_google_hangout_replay is used show registration form
*/
function wp_google_hangout_replay(){
	require('hangout_replay.php');
}

/* function name: wp_google_hangout
   Description:  wp_google_hangout is used show event listing
*/
function wp_google_hangout(){
	do_action('wp_google_hangout');
}
/* function name: wp_google_hangout_broadcast
   Description:  wp_google_hangout_broadcast is used to broadcast event.
*/
function wp_google_hangout_broadcast(){
	include('broadcast.php');
}
/* function name: wp_manage_hangout
   Description:  wp_manage_hangout is used to manage event.
*/
function wp_manage_hangout(){
	include('manage_hangout.php');
}
/* function name: get_hangout_post_type_template
   Description:  get_hangout_post_type_template is show event in frontend.
*/
function get_hangout_post_type_template($single_template) {
     global $post;
     if ($post->post_type == 'ghangout') {
          $single_template = dirname( __FILE__ ) . '/single-ghangout.php';
     }
     return $single_template;
}

add_filter( "single_template", "get_hangout_post_type_template" ) ;

/* function name: timeapi_servicecall
   Description:  timeapi_servicecall is get current time of selected city.
*/
function timeapi_servicecall($service, $args) {
	$entrypoint = 'http://api.xmltime.com/';
	$accesskey = '51Np3k6ovQ';
	$secretkey = '310JQ5EU3Efc1EDRtKD8';

    $timestamp = gmdate('c');
    $message = "$accesskey$service$timestamp";
    $signature = base64_encode(hash_hmac('sha1', $message, $secretkey, true));

    $args['accesskey'] = $accesskey;
    $args['timestamp'] = $timestamp;
    $args['signature'] = $signature;

    $url = "$entrypoint/$service?" . http_build_query($args);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
	$data = json_decode($result);
	return $data->locations[0]->time;
}

/* function name: get_city_id
   Description:  get_city_id is get city id by cityname.
*/
function get_city_id($name){
	global $wpdb;

	$key = $wpdb->get_var('select id from '.$wpdb->prefix.'location where name="'.$name.'"');
	return $key;
}
/* function name: get_layout_list
   Description:  get_layout_list is get list of templated which is install on runclick.
*/
function get_layout_list(){
	$plugins_url = plugin_dir_url(__FILE__);
	//$xml=simplexml_load_file($plugins_url ."/layout.xml");
	
		$ch = curl_init();
		$timeout = 10;
		curl_setopt($ch,CURLOPT_URL,$plugins_url ."/layout.xml");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$d = curl_exec($ch);
		if(empty($d)){
			 if(ini_get('allow_url_fopen')){
				$d = file_get_contents($plugins_url ."/layout.xml");
				}else{
				$fopen_error_msg= "Please contact your web hoster and ask them to enable allow_url_fopen";
				if(isset($fopen_error_msg)){ ?>
					<div class="updated" style="min-height: 44px !important; padding-top: 5px !important;"><p><?php echo $fopen_error_msg;?></p></div>
					<?php 
					}
				die();
				}
		}
		curl_close($ch);
		$xml = new SimpleXMLElement($d);
		return $xml;

}

add_action( 'admin_footer', 'ghangout_ajax_javascript' );
function ghangout_ajax_javascript() {
?>
<script type="text/javascript" >
var thath_singh	=	'<?php echo $thath_singh; ?>';
jQuery(document).ready(function($) {
	$('.hangout_check_update').live('click',function(){	
		var data = {
			action: 'ghangout_check_update'
		};

		$.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
				$("#updatemsg").html(response);
		});
	});
	
	$('#seo-server-update-link').live('click',function(){
	
		var data = {
			action: 'ghangout_do_update',
			umo_hangout_update : 1
		};

		$.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
			window.location = '<?php echo admin_url();?>?page=google_hangout';
			$("#updatemsg").html(response);
				
			
		});
	});
	/* Edit for template update by thath singh 
		Date:27/08/2014
	*/
	$('.template_check_update').live('click',function(){	
		var data = {
			action: 'ghangout_template_check_update'
		};

		$.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
			$("#updatemsg").html(response);
		});
	});
	
	$('#seo-server-template-update-link').live('click',function(){
	
		var data = {
			action: 'ghangout_template_do_update',
			umo_hangout_template_update : 1
		};

		$.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
			//window.location = '<?php echo admin_url();?>?page=google_hangout';
			$("#updatemsg").html(response);
				
			
		});
	});
	
});
</script>
<?php
}

add_action( 'wp_ajax_ghangout_check_update', 'ghangout_ajax_callback' );
add_action( 'wp_ajax_ghangout_template_check_update', 'ghangout_template_ajax_callback' );

function ghangout_ajax_callback() {
    global $wpdb; /* this is how you get access to the database */
	$umohangoutupdater	=	new Umohangoutupdater;
	$updatedata	=	$umohangoutupdater->checkupdates();
	if($updatedata == "update")
	{
		echo $umohangoutupdater->showupdatemessage();
	}
	else
	{
		echo ghangoutuptodatemessage();
	}
    die(); // this is required to return a proper result
}
/*
function name : ghangout_template_ajax_callback
Use for check new update
Create 	: Thath singh
Date 	: 27/08/2014
*/
function ghangout_template_ajax_callback() {
    global $wpdb; /* this is how you get access to the database */
	$umohangoutupdater	=	new Umohangoutupdater;
	$updatedata	=	$umohangoutupdater->checkTemplateupdates();
	if($updatedata == "update")
	{
		echo $umohangoutupdater->showTemplateupdatemessage();
	}
	else
	{
		echo ghangoutTemplateuptodatemessage();
	}
    die(); // this is required to return a proper result
}

add_action( 'wp_ajax_ghangout_do_update', 'ghangout_do_update_callback' );
add_action( 'wp_ajax_ghangout_template_do_update', 'ghangout_template_do_update_callback' );

function ghangout_do_update_callback() {
    global $wpdb; /* this is how you get access to the database */
	$umohangoutupdater	=	new Umohangoutupdater;
	$umohangoutupdater->checkupdates();
	echo $umohangoutupdater->showupdatesuccessmessage();
	
	die(); // this is required to return a proper result
}
function ghangout_template_do_update_callback() {
    global $wpdb; /* this is how you get access to the database */
	$umohangoutupdater	=	new Umohangoutupdater;
	
	$umohangoutupdater->checkTemplateupdates();
	
	echo $umohangoutupdater->showTemplateupdatesuccessmessage();
	
	die(); // this is required to return a proper result
}

function ghangoutuptodatemessage()
{
	return '<div class="updated" style="min-height: 44px !important; padding-top: 5px !important;"><p>Your Plugin is UpToDate.</p></div>';
}
function ghangoutTemplateuptodatemessage()
{
	return '<div class="updated" style="min-height: 44px !important; padding-top: 5px !important;"><p>Your Template Pack is UpToDate.</p></div>';
}

  