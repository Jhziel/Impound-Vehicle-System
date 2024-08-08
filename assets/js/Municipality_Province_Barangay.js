$(document).ready(function(){
    var municipalities = {
			'Abra': [
				'Bangued', 'Boliney', 'Bucay', 'Bucloc', 'Daguioman', 'Danglas',
				'Dolores', 'La Paz', 'Lacub', 'Lagangilang', 'Lagayan', 'Langiden',
				'Licuan-Baay', 'Luba', 'Malibcong', 'Manabo', 'Peñarrubia', 'Pidigan',
				'Pilar', 'Sallapadan', 'San Isidro', 'San Juan', 'San Quintin', 'Tayum',
				'Tineg', 'Tubo', 'Villaviciosa'
			],
			'Agusan del Norte': [
				'Buenavista', 'Butuan', 'Cabadbaran', 'Carmen', 'Jabonga', 'Kitcharao',
				'Las Nieves', 'Magallanes', 'Nasipit', 'Remedios T. Romualdez', 'Santiago',
				'Tubay'
			],
			'Agusan del Sur': [
				'Bayugan', 'Bunawan', 'Esperanza', 'La Paz', 'Loreto', 'Prosperidad',
				'Rosario', 'San Francisco', 'San Luis', 'Santa Josefa', 'Sibagat',
				'Talacogon', 'Trento', 'Veruela'
			],
			'Aklan': [
				'Altavas', 'Balete', 'Banga', 'Batan', 'Buruanga', 'Ibajay',
				'Kalibo', 'Lezo', 'Libacao', 'Madalag', 'Makato', 'Malay',
				'Malinao', 'Nabas', 'New Washington', 'Numancia', 'Tangalan'
			],
			'Albay': [
				'Bacacay', 'Camalig', 'Daraga', 'Guinobatan', 'Jovellar', 'Legazpi',
				'Libon', 'Ligao', 'Malilipot', 'Malinao', 'Manito', 'Oas',
				'Pio Duran', 'Polangui', 'Rapu-Rapu', 'Santo Domingo', 'Tabaco',
				'Tiwi'
			],
			'Antique': [
				'Anini-y', 'Barbaza', 'Belison', 'Bugasong', 'Caluya', 'Culasi',
				'Hamtic', 'Laua-an', 'Libertad', 'Pandan', 'Patnongon', 'San Jose de Buenavista',
				'San Remigio', 'Sebaste', 'Sibalom', 'Tibiao', 'Tobias Fornier', 'Valderrama'
			],
			'Apayao': [
				'Calanasan', 'Conner', 'Flora', 'Kabugao', 'Luna', 'Pudtol',
				'Santa Marcela'
			],
			'Aurora': [
				'Baler', 'Casiguran', 'Dilasag', 'Dinalungan', 'Dingalan', 'Dipaculao',
				'Maria Aurora', 'San Luis'
			],
			'Basilan': [
				'Akbar', 'Al-Barka', 'Hadji Mohammad Ajul', 'Hadji Muhtamad', 'Isabela City', 'Lamitan',
				'Lantawan', 'Maluso', 'Sumisip', 'Tabuan-Lasa', 'Tipo-Tipo', 'Tuburan',
				'Ungkaya Pukan'
			],
			'Bataan': [
				'Abucay', 'Bagac', 'Balanga', 'Dinalupihan', 'Hermosa', 'Limay',
				'Mariveles', 'Morong', 'Orani', 'Orion', 'Pilar', 'Samal',
			],
			'Batanes': [
				'Basco', 'Itbayat', 'Ivana', 'Mahatao', 'Sabtang', 'Uyugan'
			],
			'Batangas': [
				'Agoncillo', 'Alitagtag', 'Balayan', 'Balete', 'Batangas City', 'Bauan',
				'Calaca', 'Calatagan', 'Cuenca', 'Ibaan', 'Laurel', 'Lemery',
				'Lian', 'Lipa', 'Lobo', 'Mabini', 'Malvar', 'Mataas na kahoy',
				'Nasugbu', 'Padre Garcia', 'Rosario', 'San Jose', 'San Juan', 'San Luis',
				'San Nicolas', 'San Pascual', 'Santa Teresita', 'Santo Tomas', 'Taal',
				'Talisay', 'Tanauan', 'Taysan', 'Tingloy', 'Tuy'
			],
			'Benguet': [
				'Atok', 'Baguio', 'Bakun', 'Bokod', 'Buguias', 'Itogon',
				'Kabayan', 'Kapangan', 'Kibungan', 'La Trinidad', 'Mankayan', 'Sablan',
				'Tuba', 'Tublay'
			],
			'Biliran': [
				'Almeria', 'Biliran', 'Cabucgayan', 'Caibiran', 'Culaba', 'Kawayan',
				'Maripipi', 'Naval'
			],
			'Bohol': [
				'Alicia', 'Anda', 'Batuan', 'Bilar', 'Candijay', 'Carmen',
				'Dimiao', 'Duero', 'Garcia Hernandez', 'Guindulman', 'Jagna', 'Sevilla',
				'Lila', 'Loay', 'Loboc', 'Mabini', 'Pilar', 'Sierra Bullones',
				'Valencia'
			],
			'Bukidnon': [
				'Baungon', 'Cabanglasan', 'Damulog', 'Dangcagan', 'Don Carlos', 'Impasugong',
				'Kadingilan', 'Kalilangan', 'Kibawe', 'Kitaotao', 'Lantapan', 'Libona',
				'Malaybalay', 'Malitbog', 'Manolo Fortich', 'Maramag', 'Pangantucan', 'Quezon',
				'San Fernando', 'Sumilao', 'Talakag', 'Valencia'
			],
			'Bulacan': [
				'Angat', 'Balagtas', 'Baliuag', 'Bocaue', 'Bulakan', 'Bustos',
				'Calumpit', 'Doña Remedios Trinidad', 'Guiguinto', 'Hagonoy', 'Malolos', 'Marilao',
				'Meycauayan', 'Norzagaray', 'Obando', 'Pandi', 'Paombong', 'Plaridel',
				'Pulilan', 'San Ildefonso', 'San Jose del Monte', 'San Miguel', 'San Rafael', 'Santa Maria'
			],
			'Cagayan': [
				'Abulug', 'Alcala', 'Allacapan', 'Amulung', 'Aparri', 'Baggao',
				'Ballesteros', 'Buguey', 'Calayan', 'Camalaniugan', 'Claveria', 'Enrile',
				'Gattaran', 'Gonzaga', 'Iguig', 'Lal-lo', 'Lasam', 'Pamplona',
				'Peñablanca', 'Piat', 'Rizal', 'Sanchez-Mira', 'Santa Ana', 'Santa Praxedes',
				'Santa Teresita', 'Santo Niño', 'Solana', 'Tuao', 'Tuguegarao City'
			],
			'Camarines Norte': [
				'Basud', 'Capalonga', 'Daet', 'Jose Panganiban', 'Labo', 'Mercedes',
				'Paracale', 'San Lorenzo Ruiz', 'San Vicente', 'Santa Elena', 'Talisay', 'Vinzons',
			],
			'Camarines Sur': [
				'Baao', 'Balatan', 'Bato', 'Bombon', 'Buhi', 'Bula',
				'Cabusao', 'Calabanga', 'Camaligan', 'Canaman', 'Caramoan', 'Del Gallego',
				'Gainza', 'Garchitorena', 'Goa', 'Iriga', 'Lagonoy', 'Libmanan',
				'Lupi', 'Magarao', 'Milaor', 'Minalabac', 'Nabua', 'Naga',
				'Ocampo', 'Pamplona', 'Pasacao', 'Pili', 'Presentacion', 'Ragay',
				'Sagñay', 'San Fernando', 'San Jose', 'Sipocot', 'Siruma', 'Tigaon',
				'Tinambac'
			],
			'Camiguin': [
				'Catarman', 'Guinsiliban', 'Mahinog', 'Mambajao', 'Sagay'
			],
			'Capiz': [
				'Cuartero', 'Dao', 'Dumalag', 'Dumarao', 'Ivisan', 'Jamindan',
				'Maayon', 'Mambusao', 'Panay', 'Panitan', 'Pilar', 'Pontevedra',
				'President Roxas', 'Roxas City', 'Sapian', 'Sigma', 'Tapaz'
			],
			'Catanduanes': [
				'Bagamanoc', 'Baras', 'Bato', 'Caramoran', 'Gigmoto', 'Pandan',
				'Panganiban', 'San Andres', 'San Miguel', 'Viga', 'Virac'
			],
			'Cavite': [
				'Alfonso', 'Amadeo', 'Bacoor', 'Carmona', 'Cavite City', 'Dasmariñas',
				'General Emilio Aguinaldo', 'General Mariano Alvarez', 'General Trias', 'Imus', 'Indang', 'Kawit',
				'Magallanes', 'Maragondon', 'Mendez', 'Naic', 'Noveleta', 'Rosario',
				'Silang', 'Tagaytay', 'Tanza', 'Ternate', 'Trece Martires'
			],
			'Cebu': [
				'Alcantara', 'Alcoy', 'Alegria', 'Aloguinsan', 'Argao', 'Asturias',
				'Badian', 'Balamban', 'Bantayan', 'Barili', 'Bogo', 'Boljoon',
				'Borbon', 'Carcar', 'Carmen', 'Catmon', 'Cebu City', 'Compostela',
				'Consolacion', 'Cordova', 'Daanbantayan', 'Dalaguete', 'Danao', 'Dumanjug',
				'Ginatilan', 'Lapu-Lapu', 'Liloan', 'Madridejos', 'Malabuyoc', 'Mandaue',
				'Medellin', 'Minglanilla', 'Moalboal', 'Naga', 'Oslob', 'Pilar',
				'Pinamungajan', 'Poro', 'Ronda', 'Samboan', 'San Fernando', 'San Francisco',
				'San Remigio', 'Santa Fe', 'Santander', 'Sibonga', 'Sogod', 'Tabogon',
				'Tabuelan', 'Talisay', 'Toledo', 'Tuburan', 'Tudela'
			],
			'Compostela Valley': [
				'Compostela', 'Laak', 'Mabini', 'Maco', 'Maragusan', 'Mawab',
				'Monkayo', 'Montevista', 'Nabunturan', 'New Bataan', 'Pantukan'
			],
			'Cotabato': [
				'Alamada', 'Aleosan', 'Antipas', 'Arakan', 'Banisilan', 'Carmen',
				'Kabacan', 'Kidapawan', 'Libungan', 'M\'lang', 'Magpet', 'Makilala',
				'Matalam', 'Midsayap', 'Pigcawayan', 'Pikit', 'President Roxas', 'Tulunan'
			],
			'Davao del Norte': [
				'Asuncion', 'Braulio E. Dujali', 'Carmen', 'Kapalong', 'New Corella', 'Panabo',
				'Samal', 'San Isidro', 'Santo Tomas', 'Tagum', 'Talaingod'
			],
			'Davao del Sur': [
				'Bansalan', 'Davao City', 'Digos', 'Hagonoy', 'Kiblawan', 'Magsaysay',
				'Malalag', 'Matanao', 'Padada', 'Santa Cruz', 'Sulop'
			],
			'Davao Oriental': [
				'Baganga', 'Banaybanay', 'Boston', 'Caraga', 'Cateel', 'Governor Generoso',
				'Lupon', 'Manay', 'Mati', 'San Isidro', 'Tarragona'
			],
			'Dinagat Islands': [
				'Basilisa', 'Cagdianao', 'Dinagat', 'Libjo', 'Loreto', 'San Jose',
				'Tubajon'
			],
			'Eastern Samar': [
				'Arteche', 'Balangiga', 'Balangkayan', 'Borongan', 'Can-avid', 'Dolores',
				'General MacArthur', 'Giporlos', 'Guiuan', 'Hernani', 'Jipapad', 'Lawaan',
				'Llorente', 'Maslog', 'Maydolong', 'Mercedes', 'Oras', 'Quinapondan',
				'Salcedo', 'San Julian', 'San Policarpo', 'Sulat', 'Taft'
			],
			'Guimaras': [
				'Buenavista', 'Jordan', 'Nueva Valencia', 'San Lorenzo', 'Sibunag'
			],
			'Ifugao': [
				'Aguinaldo', 'Alfonso Lista', 'Asipulo', 'Banaue', 'Hingyon', 'Hungduan',
				'Kiangan', 'Lagawe', 'Lamut', 'Mayoyao', 'Tinoc'
			],
			'Ilocos Norte': [
				'Adams', 'Bacarra', 'Badoc', 'Bangui', 'Banna', 'Batac',
				'Burgos', 'Carasi', 'Currimao', 'Dingras', 'Dumalneg', 'Laoag',
				'Marcos', 'Nueva Era', 'Pagudpud', 'Paoay', 'Pasuquin', 'Piddig',
				'Pinili', 'San Nicolas', 'Sarrat', 'Solsona', 'Vintar'
			],
			'Ilocos Sur': [
				'Alilem', 'Banayoyo', 'Bantay', 'Burgos', 'Cabugao', 'Candon',
				'Caoayan', 'Cervantes', 'Galimuyod', 'Gregorio del Pilar', 'Lidlidda', 'Magsingal',
				'Nagbukel', 'Narvacan', 'Quirino', 'Salcedo', 'San Emilio', 'San Esteban',
				'San Ildefonso', 'San Juan', 'San Vicente', 'Santa', 'Santa Catalina', 'Santa Cruz',
				'Santa Lucia', 'Santa Maria', 'Santiago', 'Santo Domingo', 'Sigay', 'Sinait',
				'Sugpon', 'Suyo', 'Tagudin', 'Vigan'
			],
			'Iloilo': [
				'Ajuy', 'Alimodian', 'Anilao', 'Badiangan', 'Balasan', 'Banate',
				'Barotac Nuevo', 'Barotac Viejo', 'Batad', 'Bingawan', 'Cabatuan', 'Calinog',
				'Carles', 'Concepcion', 'Dingle', 'Dueñas', 'Dumangas', 'Estancia',
				'Guimbal', 'Igbaras', 'Iloilo City', 'Janiuay', 'Lambunao', 'Leganes',
				'Lemery', 'Leon', 'Maasin', 'Miagao', 'Mina', 'New Lucena',
				'Oton', 'Passi', 'Pavia', 'Pototan', 'San Dionisio', 'San Enrique',
				'San Joaquin', 'San Miguel', 'San Rafael', 'Santa Barbara', 'Sara', 'Tigbauan',
				'Tubungan', 'Zarraga'
			],
			'Isabela': [
				'Alicia', 'Angadanan', 'Aurora', 'Benito Soliven', 'Burgos', 'Cabagan',
				'Cabatuan', 'Cauayan', 'Cordon', 'Delfin Albano', 'Dinapigue', 'Divilacan',
				'Echague', 'Gamu', 'Ilagan', 'Jones', 'Luna', 'Maconacon',
				'Mallig', 'Naguilian', 'Palanan', 'Quezon', 'Quirino', 'Ramon',
				'Reina Mercedes', 'Roxas', 'San Agustin', 'San Guillermo', 'San Isidro', 'San Manuel',
				'San Mariano', 'San Mateo', 'San Pablo', 'Santa Maria', 'Santiago', 'Santo Tomas',
				'Tumauini'
			],
			'Kalinga': [
				'Balbalan', 'Lubuagan', 'Pasil', 'Pinukpuk', 'Rizal', 'Tabuk',
				'Tanudan', 'Tinglayan'
			],
			'La Union': [
				'Agoo', 'Aringay', 'Bacnotan', 'Bagulin', 'Balaoan', 'Bangar',
				'Bauang', 'Burgos', 'Caba', 'Luna', 'Naguilian', 'Pugo',
				'Rosario', 'San Fernando', 'San Gabriel', 'San Juan', 'Santo Tomas', 'Santol',
				'Sudipen', 'Tubao'
			],
			'Laguna': [
				'Alaminos', 'Bay', 'Biñan', 'Cabuyao', 'Calamba', 'Calauan',
				'Cavinti', 'Famy', 'Kalayaan', 'Liliw', 'Los Baños', 'Luisiana',
				'Lumban', 'Mabitac', 'Magdalena', 'Majayjay', 'Nagcarlan', 'Paete',
				'Pagsanjan', 'Pakil', 'Pangil', 'Pila', 'Rizal', 'San Pablo', 'San Pedro',
				'Santa Cruz', 'Santa Maria', 'Santa Rosa', 'Siniloan', 'Victoria'
			],
			'Lanao del Norte': [
				'Bacolod', 'Baloi', 'Baroy', 'Iligan', 'Kapatagan', 'Kauswagan',
				'Kolambugan', 'Lala', 'Linamon', 'Magsaysay', 'Maigo', 'Matungao',
				'Munai', 'Nunungan', 'Pantao Ragat', 'Pantar', 'Poona Piagapo', 'Salvador',
				'Sapad', 'Sultan Naga Dimaporo', 'Tagoloan', 'Tangcal', 'Tubod'
			],
			'Lanao del Sur': [
				'Amai Manabilang', 'Bacolod-Kalawi', 'Balabagan', 'Balindong', 'Bayang', 'Binidayan',
				'Buadiposo-Buntong', 'Bubong', 'Butig', 'Calanogas', 'Ditsaan-Ramain', 'Ganassi',
				'Kapai', 'Kapatagan', 'Lumba-Bayabao', 'Lumbaca-Unayan', 'Lumbatan', 'Lumbayanague',
				'Madalum', 'Madamba', 'Maguing', 'Malabang', 'Marantao', 'Marawi',
				'Marogong', 'Masiu', 'Mulondo', 'Pagayawan', 'Piagapo', 'Picong',
				'Poona Bayabao', 'Pualas', 'Saguiaran', 'Sultan Dumalondong', 'Tagoloan II', 'Tamparan',
				'Taraka', 'Tubaran', 'Tugaya', 'Wao'
			],
			'Leyte': [
				'Abuyog', 'Alangalang', 'Albuera', 'Babatngon', 'Barugo', 'Bato',
				'Baybay', 'Burauen', 'Calubian', 'Capoocan', 'Carigara', 'Dagami',
				'Dulag', 'Hilongos', 'Hindang', 'Inopacan', 'Isabel', 'Jaro',
				'Javier', 'Julita', 'Kananga', 'La Paz', 'Leyte', 'MacArthur',
				'Mahaplag', 'Matag-ob', 'Matalom', 'Mayorga', 'Merida', 'Ormoc',
				'Palo', 'Palompon', 'Pastrana', 'San Isidro', 'San Miguel', 'Santa Fe',
				'Tabango', 'Tabontabon', 'Tacloban', 'Tanauan', 'Tolosa', 'Tunga',
				'Villaba'
			],
			'Maguindanao': [
				'Barira', 'Buldon', 'Datu Anggal Midtimbang', 'Datu Blah T. Sinsuat', 'Datu Odin Sinsuat', 'Kabuntalan',
				'Matanog', 'Northern Kabuntalan', 'Parang', 'Sultan Kudarat', 'Sultan Mastura', 'Sultan Sumagka',
				'Upi'
			],
			'Marinduque': [
				'Boac', 'Buenavista', 'Gasan', 'Mogpog', 'Santa Cruz', 'Torrijos'
			],
			'Masbate': [
				'Aroroy', 'Baleno', 'Balud', 'Batuan', 'Cataingan', 'Cawayan',
				'Claveria', 'Dimasalang', 'Esperanza', 'Mandaon', 'Masbate City', 'Milagros',
				'Mobo', 'Monreal', 'Palanas', 'Pio V. Corpuz', 'Placer', 'San Fernando',
				'San Jacinto', 'San Pascual', 'Uson'
			],
			'Metro Manila': [
				'Caloocan', 'Las Piñas', 'Makati', 'Malabon', 'Mandaluyong', 'Manila',
				'Marikina', 'Muntinlupa', 'Navotas', 'Parañaque', 'Pasay', 'Pasig',
				'Pateros', 'Quezon City', 'San Juan', 'Taguig', 'Valenzuela'
			],
			'Misamis Occidental': [
				'Aloran', 'Baliangao', 'Bonifacio', 'Calamba', 'Clarin', 'Concepcion',
				'Don Victoriano Chiongbian', 'Jimenez', 'Lopez Jaena', 'Oroquieta', 'Ozamiz', 'Panaon',
				'Plaridel', 'Sapang Dalaga', 'Sinacaban', 'Tangub', 'Tudela'
			],
			'Misamis Oriental': [
				'Alubijid', 'Balingasag', 'Balingoan', 'Binuangan', 'Cagayan de Oro', 'Claveria',
				'El Salvador', 'Gingoog', 'Gitagum', 'Initao', 'Jasaan', 'Kinoguitan',
				'Lagonglong', 'Laguindingan', 'Libertad', 'Lugait', 'Magsaysay', 'Manticao',
				'Medina', 'Naawan', 'Opol', 'Salay', 'Sugbongcogon', 'Tagoloan',
				'Talisayan', 'Villanueva'
			],
			'Mountain Province': [
				'Barlig', 'Bauko', 'Besao', 'Bontoc', 'Natonin', 'Paracelis',
				'Sabangan', 'Sadanga', 'Sagada', 'Tadian'
			],
			'Negros Occidental': [
				'Bacolod', 'Bago', 'Binalbagan', 'Cadiz', 'Calatrava', 'Candoni',
				'Cauayan', 'Enrique B. Magalona', 'Escalante', 'Himamaylan', 'Hinigaran', 'Hinoba-an',
				'Ilog', 'Isabela', 'Kabankalan', 'La Carlota', 'La Castellana', 'Manapla',
				'Moises Padilla', 'Murcia', 'Pontevedra', 'Pulupandan', 'Sagay', 'Salvador Benedicto',
				'San Carlos', 'San Enrique', 'Silay', 'Sipalay', 'Talisay', 'Toboso',
				'Valladolid', 'Victorias'
			],
			'Negros Oriental': [
				'Amlan', 'Ayungon', 'Bacong', 'Bais', 'Basay', 'Bayawan',
				'Bindoy', 'Canlaon', 'Dauin', 'Dumaguete', 'Guihulngan', 'Jimalalud',
				'La Libertad', 'Mabinay', 'Manjuyod', 'Pamplona', 'San Jose', 'Santa Catalina',
				'Siaton', 'Sibulan', 'Tanjay', 'Tayasan', 'Valencia', 'Vallehermoso',
				'Zamboanguita'
			],
			'Northern Samar': [
				'Allen', 'Biri', 'Bobon', 'Capul', 'Catarman', 'Catubig',
				'Gamay', 'Laoang', 'Lapinig', 'Las Navas', 'Lavezares', 'Lope de Vega',
				'Mapanas', 'Mondragon', 'Palapag', 'Pambujan', 'Rosario', 'San Antonio',
				'San Isidro', 'San Jose', 'San Roque', 'San Vicente', 'Silvino Lobos', 'Victoria'
			],
			'Nueva Ecija': [
				'Aliaga', 'Bongabon', 'Cabanatuan', 'Cabiao', 'Carranglan', 'Cuyapo',
				'Gabaldon', 'Gapan', 'General Mamerto Natividad', 'General Tinio', 'Guimba', 'Jaen',
				'Laur', 'Licab', 'Llanera', 'Lupao', 'Muñoz', 'Nampicuan',
				'Palayan', 'Pantabangan', 'Peñaranda', 'Quezon', 'Rizal', 'San Antonio',
				'San Isidro', 'Cabaritan', 'San Leonardo', 'Santa Rosa', 'Santo Domingo', 'Talavera',
				'Talugtug', 'Zaragoza'
			],
			'Nueva Vizcaya': [
				'Alfonso Castañeda', 'Ambaguio', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong',
				'Diadi', 'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon',
				'Santa Fe', 'Solano', 'Villaverde'
			],
			'Occidental Mindoro': [
				'Abra de Ilog', 'Calintaan', 'Looc', 'Lubang', 'Magsaysay', 'Mamburao',
				'Paluan', 'Rizal', 'Sablayan', 'San Jose', 'Santa Cruz'
			],
			'Oriental Mindoro': [
				'Baco', 'Bansud', 'Bongabong', 'Bulalacao', 'Calapan', 'Gloria',
				'Mansalay', 'Naujan', 'Pinamalayan', 'Pola', 'Puerto Galera', 'Roxas',
				'San Teodoro', 'Socorro', 'Victoria'
			],
			'Palawan': [
				'Aborlan', 'Agutaya', 'Araceli', 'Balabac', 'Bataraza', 'Brooke\'s Point',
				'Busuanga', 'Cagayancillo', 'Coron', 'Culion', 'Cuyo', 'Dumaran',
				'El Nido', 'Kalayaan', 'Linapacan', 'Magsaysay', 'Narra', 'Puerto Princesa',
				'Quezon', 'Rizal', 'Roxas', 'San Vicente', 'Sofronio Española', 'Taytay'
			],
			'Pampanga': [
				'Angeles', 'Apalit', 'Arayat', 'Bacolor', 'Candaba', 'Floridablanca',
				'Guagua', 'Lubao', 'Mabalacat', 'Macabebe', 'Magalang', 'Masantol',
				'Mexico', 'Minalin', 'Porac', 'San Fernando', 'San Luis', 'San Simon',
				'Santa Ana', 'Santa Rita', 'Santo Tomas', 'Sasmuan'
			],
			'Pangasinan': [
				'Agno', 'Aguilar', 'Alaminos', 'Alcala', 'Anda', 'Asingan',
				'Balungao', 'Bani', 'Basista', 'Bautista', 'Bayambang', 'Binalonan',
				'Binmaley', 'Bolinao', 'Bugallon', 'Burgos', 'Calasiao', 'Dasol',
				'Dagupan', 'Dasol', 'Infanta', 'Labrador', 'Laoac', 'Lingayen',
				'Mabini', 'Malasiqui', 'Manaoag', 'Mangaldan', 'Mangatarem', 'Mapandan',
				'Natividad', 'Pozorrubio', 'Rosales', 'San Carlos', 'San Fabian', 'San Jacinto',
				'San Manuel', 'San Nicolas', 'San Quintin', 'Santa Barbara', 'Santa Maria', 'Santo Tomas',
				'Sison', 'Sual', 'Tayug', 'Umingan', 'Urbiztondo', 'Urdaneta',
				'Villasis'
			],
			'Quezon': [
				'Agdangan', 'Alabat', 'Atimonan', 'Buenavista', 'Burdeos', 'Calauag',
				'Candelaria', 'Catanauan', 'Dolores', 'General Luna', 'General Nakar', 'Guinayangan',
				'Gumaca', 'Infanta', 'Jomalig', 'Lopez', 'Lucban', 'Lucena',
				'Macalelon', 'Mauban', 'Mulanay', 'Padre Burgos', 'Pagbilao', 'Panukulan',
				'Patnanungan', 'Perez', 'Pitogo', 'Plaridel', 'Polillo', 'Quezon',
				'Real', 'Sampaloc', 'San Andres', 'San Antonio', 'San Francisco', 'San Narciso',
				'Sariaya', 'Tagkawayan', 'Tayabas', 'Tiaong', 'Unisan'
			],
			'Quirino': [
				'Aglipay', 'Cabarroguis', 'Diffun', 'Maddela', 'Nagtipunan', 'Saguday'
			],
			'Rizal': [
				'Angono', 'Antipolo', 'Baras', 'Binangonan', 'Cainta', 'Cardona',
				'Jalajala', 'Morong', 'Pililla', 'Rodriguez', 'San Mateo', 'Tanay',
				'Taytay', 'Teresa'
			],
			'Romblon': [
				'Alcantara', 'Banton', 'Cajidiocan', 'Calatrava', 'Concepcion', 'Corcuera',
				'Ferrol', 'Looc', 'Magdiwang', 'Odiongan', 'Romblon', 'San Agustin',
				'San Andres', 'San Fernando', 'San Jose', 'Santa Fe', 'Santa Maria'
			],
			'Samar': [
				'Almagro', 'Basey', 'Calbayog', 'Calbiga', 'Catbalogan', 'Daram',
				'Gandara', 'Hinabangan', 'Jiabong', 'Marabut', 'Matuguinao', 'Motiong',
				'Pagsanghan', 'Paranas', 'Pinabacdao', 'San Jorge', 'San Jose de Buan', 'San Sebastian',
				'Santa Margarita', 'Santa Rita', 'Santo Niño', 'Tagapul-an', 'Talalora', 'Tarangnan',
				'Villareal', 'Zumarraga'
			],
			'Sarangani': [
				'Alabel', 'Glan', 'Kiamba', 'Maasim', 'Maitum', 'Malapatan',
				'Malungon'
			],
			'Shariff Kabunsuan': [
				'Barira', 'Buldon', 'Datu Blah T. Sinsuat', 'Datu Odin Sinsuat', 'Kabuntalan', 'Matanog',
				'Northern Kabuntalan', 'Parang', 'Sultan Kudarat', 'Sultan Mastura', 'Upi'
			],
			'Siquijor': [
				'Enrique Villanueva', 'Larena', 'Lazi', 'Maria', 'San Juan', 'Siquijor'
			],
			'Sorsogon': [
				'Barcelona', 'Bulan', 'Bulusan', 'Casiguran', 'Castilla', 'Donsol',
				'Gubat', 'Irosin', 'Juban', 'Magallanes', 'Matnog', 'Pilar',
				'Prieto Diaz', 'Santa Magdalena', 'Sorsogon City'
			],
			'South Cotabato': [
				'Banga', 'General Santos', 'Koronadal', 'Lake Sebu', 'Norala', 'Polomolok',
				'Santo Niño', 'Surallah', 'T\'Boli', 'Tampakan', 'Tantangan', 'Tupi'
			],
			'Southern Leyte': [
				'Anahawan', 'Bontoc', 'Hinunangan', 'Hinundayan', 'Libagon', 'Liloan',
				'Limasawa', 'Maasin', 'Macrohon', 'Malitbog', 'Padre Burgos', 'Pintuyan',
				'Saint Bernard', 'San Francisco', 'San Juan', 'San Ricardo', 'Silago', 'Sogod',
				'Tomas Oppus'
			],
			'Sultan Kudarat': [
				'Bagumbayan', 'Columbio', 'Esperanza', 'Isulan', 'Kalamansig', 'Lambayong',
				'Lebak', 'Lutayan', 'Palimbang', 'President Quirino', 'Senator Ninoy Aquino', 'Tacurong'
			],
			'Sulu': [
				'Banguingui', 'Hadji Panglima Tahil', 'Indanan', 'Jolo', 'Kalingalan Caluang', 'Lugus',
				'Luuk', 'Maimbung', 'Old Panamao', 'Omar', 'Pandami', 'Panglima Estino',
				'Pangutaran', 'Parang', 'Pata', 'Patikul', 'Siasi', 'Talipao',
				'Tapul'
			],
			'Surigao del Norte': [
				'Alegria', 'Bacuag', 'Burgos', 'Claver', 'Dapa', 'Del Carmen',
				'General Luna', 'Gigaquit', 'Mainit', 'Malimono', 'Pilar', 'Placer',
				'San Benito', 'San Francisco', 'San Isidro', 'Santa Monica', 'Sison', 'Socorro',
				'Surigao City', 'Tagana-an', 'Tubod'
			],
			'Surigao del Sur': [
				'Barobo', 'Bayabas', 'Bislig', 'Cagwait', 'Cantilan', 'Carmen',
				'Carrascal', 'Cortes', 'Hinatuan', 'Lanuza', 'Lianga', 'Lingig',
				'Madrid', 'Marihatag', 'San Agustin', 'San Miguel', 'Tagbina', 'Tago',
				'Tandag'
			],
			'Tarlac': [
				'Anao', 'Bamban', 'Camiling', 'Capas', 'Concepcion', 'Gerona',
				'La Paz', 'Mayantoc', 'Moncada', 'Paniqui', 'Pura', 'Ramos',
				'San Clemente', 'San Jose', 'San Manuel', 'Santa Ignacia', 'Tarlac City', 'Victoria'
			],
			'Tawi-Tawi': [
				'Bongao', 'Languyan', 'Mapun', 'Panglima Sugala', 'Sapa-Sapa', 'Sibutu',
				'Simunul', 'Sitangkai', 'South Ubian', 'Tandubas', 'Turtle Islands'
			],
			'Zambales': [
				'Botolan', 'Cabangan', 'Candelaria', 'Iba', 'Masinloc', 'Olongapo',
				'Palauig', 'San Antonio', 'San Felipe', 'San Marcelino', 'San Narciso',
				'Santa Cruz', 'Subic'
			],
			'Zamboanga del Norte': [
				'Baliguian', 'Dapitan', 'Dipolog', 'Godod', 'Gutalac', 'Jose Dalman',
				'Kalawit', 'Katipunan', 'La Libertad', 'Labason', 'Leon B. Postigo', 'Liloy',
				'Manukan', 'Mutia', 'Piñan', 'Polanco', 'President Manuel A. Roxas', 'Rizal',
				'Salug', 'Sergio Osmeña Sr.', 'Siayan', 'Sibuco', 'Sibutad', 'Sindangan',
				'Siocon', 'Sirawai', 'Tampilisan'
			],
			'Zamboanga del Sur': [
				'Aurora', 'Bayog', 'Dimataling', 'Dinas', 'Dumalinao', 'Dumingag',
				'Guipos', 'Josefina', 'Kumalarang', 'Labangan', 'Lakewood', 'Lapuyan',
				'Mahayag', 'Margosatubig', 'Midsalip', 'Molave', 'Pagadian', 'Pitogo',
				'Ramon Magsaysay', 'San Miguel', 'San Pablo', 'Sominot', 'Tabina', 'Tambulig',
				'Tigbao', 'Tukuran', 'Vincenzo A. Sagun', 'Zamboanga City'
			],
			'Zamboanga Sibugay': [
				'Alicia', 'Buug', 'Diplahan', 'Imelda', 'Ipil', 'Kabasalan',
				'Mabuhay', 'Malangas', 'Naga', 'Olutanga', 'Payao', 'Roseller Lim',
				'Siay', 'Talusan', 'Titay', 'Tungawan'
			],
		}
		var barangays = {
			'Bangued': [
				'Agtangao', 'Angad', 'Badas', 'Bangbangcag', 'Banglolao', 'Bao-yan',
				'Barikir', 'Bayabas', 'Cabuloan', 'Calaba', 'Calot', 'Cosili East',
				'Cosili West', 'Dangdangla', 'Labaan', 'Lingtan', 'Lipcan', 'Lub-lubba',
				'Macarcarmay', 'Macray', 'Macutay', 'Manabo', 'Pagarbar', 'Patucannay',
				'Poblacion East', 'Poblacion West', 'Sagap', 'Saguibin', 'San Antonio',
				'Santa Rosa', 'Sao-atan', 'Tablac', 'Tala-atang', 'Tangadan', 'Zone 1',
				'Zone 2', 'Zone 3', 'Zone 4'
			],
			"Boliney": [
				"Kilong-Olao", "Lingay", "Lublubba", "Lubong", "Pacoc", "Pikek",
				"Poblacion", "Subagan", "Tubtuba"
			],
			"Bucay": [
				"Bani", "Bao-yan", "Bazar", "Cabaroan", "Cabugao", "Calao",
				"Dangdangla", "Dugong", "Gaddani", "Laguiben", "Lap-lapog",
				"Liguis", "Lingtan", "Mabileg", "Mudiit", "Pacac", "Pantoc",
				"Patad", "Poblacion", "Sacaang", "Sacpil", "Sao-atan",
				"Taping", "Tubo-tubo"
			],
			"Bucloc": [
				"Abualan", "Ableg", "Bayaan", "Cabaruan", "Caduldulan",
				"Capannikian", "Lan-ag", "Pacoc", "Poblacion", "San Isidro",
				"San Juan", "San Ramon", "Santa Filomena", "Tabinac"
			],
			"Daguioman": [
				"Bacooc", "Cabanaan", "Cayapa", "Kinalabasa", "Malupeng",
				"Poblacion", "Salnec", "Siblong", "Tubongan"
			],
			"Danglas": [
				"Amado", "Balawag", "Buanao", "Cabaruyan", "Cabulalaan",
				"Calabigan", "Dalaguisen", "Duldulao", "Liguis", "Lub-lubba",
				"Luba", "Malabbaga", "Maoay", "Nagaparan", "Poblacion",
				"San Juan", "Sinapangan", "Sipa"
			],
			"Dolores": [
				"Barikir", "Bol-lilising", "Cabcaborao", "Caritas", "Dagocdoc",
				"Lacub", "Laguiben", "Lan-ag", "Manacota", "Naguilisin",
				"Poblacion", "Pong-ol", "Siblong", "Tui"
			],
			"La Paz": [
				"Bangbangar", "Cabusligan", "Cabcaborao", "Cal-litang",
				"Casilagan", "Cupis", "Langbaban", "Malabbaga",
				"Pacgued", "Poblacion", "Tumalip", "Valbuena"
			],
			"Lacub": [
				"Barocboc", "Dagupan", "Dumagas", "Poblacion",
				"San Antonio", "San Isidro", "Santana", "Tui",
				"Tumalip"
			],
			"Lagangilang": [
				"Bacooc", "Bacooc East", "Buli", "Caba", "Cabcaborao",
				"Cabusligan", "Cabutotan", "Caliplang", "Casamata",
				"Dagupan", "Lap-lapog", "Lingtan", "Malabbaga",
				"Maliplipit", "Manacota", "Nagaparan", "Namit-ingan",
				"Narnara", "Natoninong", "Pang-ot", "Patiao",
				"Poblacion", "Taping", "Tuquipa"
			],
			"Lagayan": [
				"Balicuatro", "Banaoang", "Banay", "Bayabas", "Bulbulala",
				"Caliplang", "Cubcub", "Gacab", "Lingtan", "Manacota",
				"Naguilian", "Nalbuan", "Palang", "Poblacion",
				"Sallapadan", "San Gregorio", "Taping", "Tuquipa"
			],
			"Langiden": [
				"Caliplang", "Dalit", "Mudiit", "Namit-ingan", "Poblacion",
				"Sadsadan", "Salucag", "Taping"
			],
			"Licuan-Baay": [
				"Binablayan", "Caganayan", "Cal-litang", "Duldulao",
				"Lublubba", "Nagaparan", "Nagtipulan", "Poblacion",
				"Sagap", "Sallapadan", "San Juan", "Santo Tomas"
			],
			"Luba": [
				"Abualan", "Bol-lilising", "Capannikian", "Cayapa",
				"Lap-lapog", "Nagaparan", "Poblacion", "San Antonio",
				"San Isidro", "San Ramon", "Santa Filomena",
				"Santana", "Sao-atan", "Sapi-sapi", "Tubongan"
			],
			"Malibcong": [
				"Bayaan", "Cal-litang", "Duldulao", "Liguis",
				"Lingtan", "Madeladeng", "Malibcong East",
				"Malibcong West", "Nalbuan", "Poblacion",
				"San Juan", "Santo Tomas", "Siberong",
				"Tumalip"
			],
			"Manabo": [
				"Bani", "Cabaruan", "Cal-litang", "Lingtan", "Mudiit",
				"Pantoc", "Poblacion", "San Gregorio", "San Jose",
				"Sao-atan", "Tagodtod", "Tangadan", "Tubo-lubo"
			],
			"Peñarrubia": [
				"Agtangao", "Bangbangar", "Cabuloan", "Cabusligan",
				"Cal-litang", "Calot", "Casamata", "Dagupan",
				"Langbaban", "Poblacion", "San Isidro", "Tumalip"
			],
			"Pidigan": [
				"Aguet", "Bacooc", "Barocboc", "Binasaran", "Cabaruan",
				"Caliplang", "Dalit", "Lingtan", "Nagaparan", "Naguilian",
				"Poblacion", "San Juan", "Sao-atan", "Taping", "Tumalip"
			],
			"Pilar": [
				"Anayan", "Bacooc", "Bao-yan", "Barocboc", "Bayabas",
				"Bungro", "Dinikin", "Duldulao", "Lacub", "Lingtan",
				"Malabbaga", "Manacota", "Nagaparan", "Naguilian",
				"Poblacion", "San Gregorio", "San Juan", "Sao-atan",
				"Taping", "Tumalip"
			],
			"Sallapadan": [
				"Bol-lilising", "Bulbulala", "Cabuluan", "Calacala",
				"Duldulao", "Lingtan", "Lublubba", "Nagtipulan",
				"Naguilisin", "Poblacion", "San Juan", "Sao-atan",
				"Sao-atan", "Sao-atan", "Sao-atan", "Taping", "Tumalip"
			],
			"San Isidro": [
				"Aguet", "Angad", "Bagalay", "Cabayugan", "Cal-litang",
				"Duldulao", "Labon", "Langbaban", "Mudiit", "Poblacion",
				"Sao-atan", "Taping", "Tumalip"
			],
			"San Juan": [
				"Alaoa", "Banglolao", "Bao-yan", "Buneg", "Busiing Sur", "Busiing Norte",
				"Cadacad", "Dangdangla", "Liguis", "Lubong", "Nagaparan", "Pacoc",
				"Pantoc", "Poblacion", "San Antonio", "San Isidro", "San Jose",
				"San Juan", "Santa Rosa", "Tagadan", "Tangadan Proper", "Tangadan West",
				"Tangadan East", "Zone I Pob. (Elizondo)", "Zone II Pob. (San Jose)",
				"Zone III Pob. (Victory)", "Zone IV Pob. (Rizal)", "Zone V Pob. (Nalbuan)"
			],
			"San Quintin": [
				"Abualan", "Bacooc", "Balluyan", "Bol-lilising", "Busel-busel",
				"Caba", "Cabaruyan", "Cabulalaan", "Cal-lao", "Caliplig", "Cubcuberto",
				"Dagocdoc", "Dumagas", "Guimba", "Lacub", "Lan-ag", "Lucban",
				"Lumbaan (Poblacion)", "Luttuacan", "Nagcanasan", "Nagpanaoan",
				"Namit-ingan", "Paco", "Paco (Poblacion)", "Pacoc", "Pacoc (Poblacion)",
				"Patiao", "San Jose", "San Juan", "San Luis", "San Pedro", "San Ramon",
				"Sapdaan", "Sili", "Subagan", "Tagodtod", "Villavieja", "Zone I (Poblacion)",
				"Zone II (Poblacion)", "Zone III (Poblacion)", "Zone IV (Poblacion)"
			],
			"Tayum": [
				"Ayapa", "Bangbangar", "Bantay", "Bongan", "Buli", "Cabaroan",
				"Cabulalaan", "Canan", "Consiliman", "Dugong", "Luba", "Nagbettedan",
				"Poblacion", "Salucag", "San Gregorio", "Siblong", "Taping",
				"Tres Reyes", "Villavieja"
			],
			"Tineg": [
				"Abang", "Adugao", "Allig", "Apao", "Bacag", "Balluyan", "Bulbulala",
				"Caganayan", "Cal-lao", "Calot", "Capacuan", "Duldulao", "Linglingay",
				"Lizang", "Lublubba", "Naglibacan", "Nagtipulan", "Namit-ingan",
				"Poblacion", "San Isidro", "Santa Maria", "Talampac", "Talinao",
				"Tal-lingey", "Ubbog"
			],
			"Tubo": [
				"Aguet", "Ba-ug", "Bagalay", "Balais", "Bangad", "Cabayugan", "Caliptay",
				"Dalimag", "Gacab", "Guesang", "Guinacas", "Lan-ag", "Naguilian",
				"Namit-ingan", "Namulditan", "Pacoc", "Poblacion", "Salucag", "Tala",
				"Talong", "Taping", "Tubtuba"
			],
			"Villaviciosa": [
				"Ayyeng", "Baliwanan", "Cabaroan", "Cabcaboraoan", "Cabulalaan",
				"Camanggaan", "Carcarabasa", "Casibong", "Daddaay", "Duldulao",
				"Guimba", "Lublubba", "Namit-ingan", "Napo", "Nunglo", "Poblacion",
				"Sagap", "Tangbao", "Tungngod"
			],
			"Buenavista": [
				"Balubohan", "Buhangin", "Cabayawa", "Kitcharao", "Kolambugan",
				"Kongkongon", "Kubo", "Mabini", "Magaud", "Mahaba", "Magsaysay",
				"Montivesta", "Poblacion", "Pong-oy", "San Isidro", "Santo Niño",
				"Tagbongabong", "Tagbuyawan", "Tagpangahoy", "Tipolo", "Washington"
			],
			"Butuan": [
				"Agao Poblacion", "Ambago", "Anticala", "Ampayon", "Baan KM. 3",
				"Baan Riverside", "Bading", "Bancasi", "Bansa", "Basag", "Bayanihan",
				"Bayugan", "Bilay", "Bislig", "Bit-os", "Bitan-agan", "Bonbon",
				"Buhangin", "Buhisan", "Bunawan", "Cabcabon", "Carmen", "Dagohoy",
				"Dahican", "Danao", "Diego Silang", "Doongan", "Dumalagan",
				"Filipinas", "Golden Ribbon", "Holy Redeemer", "Humabon", "Imadejas",
				"Jose Rizal", "Kinamlutan", "Kinamlutan (Pob.)", "Lapu-lapu", "Lemon",
				"Libertad", "Limaha", "Los Angeles", "Lumbocan", "Mahogany",
				"Mahogany (Pob.)", "Maibu", "Mahayahay", "Manila de Bugabus",
				"Manolo Fortich", "Masao", "Maon", "Matabao", "Mayagay", "Naboc",
				"New Society Village", "Nong-nong", "Obrero", "Ong Yiu", "Orok",
				"Pangabugan", "Pianing", "Pianing (Pob.)", "Pingkian", "Pinamanculan",
				"Port Poyohon", "Port Poyohon (Pob.)", "Quezon", "Rebenta", "Riverside",
				"Rosario", "Rosario Heights", "Sampaguita", "San Ignacio", "San Mateo",
				"San Vicente", "Sikatuna", "Sumilihon", "Sumilihon (Pob.)",
				"Sumilihon Balite", "Sumilihon Tilapayong", "Sumilihon Vamenta",
				"Tagabaca", "Taguibo", "Talisay", "Tinucoran", "Tungao", "Urban",
				"Villa Kananga", "Villa Kananga (Pob.)"
			],
			"Cabadbaran": [
				"Poblacion 2", "Poblacion 3", "Poblacion 4", "Poblacion 5",
				"Poblacion 6", "Poblacion 7", "Punta", "Sanghan", "Tagpako",
				"Vinapor"
			],
			"Carmen": [
				"Cahayagan", "Gosoon", "Manoligao", "Poblacion (Carmen)",
				"Rojales", "San Agustin", "Tagcatong", "Vinapor", "Tagpako",
				"Vinapor"
			],
			"Jabonga": [
				"Aguinaldo", "Buenasuerte", "Casiklan", "Hilapnitan", "Matabao",
				"Poblacion", "Rizal", "San Antonio", "San Isidro", "Santo Niño",
				"Tagabaca", "Tagan-ayan"
			],
			"Kitcharao": [
				"Aclan", "Anibongan", "Bangayan", "Bunga", "Camagong", "Catabunan",
				"Gadgaran", "Hermojica", "Kauswagan", "Lahi", "Lapinigan",
				"Luz Village", "Mabini", "Magsaysay", "Mahayag", "Marbon", "Nueva Era",
				"Poblacion", "Rizal", "Santo Niño", "Tagmamarkay", "Valentina"
			],
			"Las Nieves": [
				"Bangonay", "Bayabas", "Cabawan", "Concepcion", "Crossing Luna",
				"Del Pilar", "Freedom", "Happy Valley", "Libertad", "Magsaysay",
				"Mahayahay", "Mapaga", "Novele", "Poblacion", "Pongkay", "Rizal",
				"San Isidro", "Santa Ana", "Santo Niño", "Tagbuyawan", "Taglatawan"
			],
			"Magallanes": [
				"Aurora", "Baylo", "Benowangan", "Del Monte", "Hinimbangan",
				"Kasiklan", "Kauswagan", "La Purisima", "Magsaysay", "Mandihi",
				"New Rizal", "Poblacion", "San Isidro", "San Roque", "Santo Niño",
				"Sukailang", "Taglatawan", "Talisay", "Timamana"
			],
			"Nasipit": [
				"Ata-atahon", "Bangonay", "Cabobo", "Calamba", "Comagascas",
				"Cubilan", "Gomez", "Imadejas", "Kabayawa", "Kasiklan",
				"Katipunan", "Kinabjangan", "Lapinig", "Lim-ao", "Magsaysay",
				"Mahayahay", "Maimbung", "Maningalao", "Nasipit", "New Rizal",
				"Poblacion", "Sangay", "Tagbuyawan", "Villa Kananga"
			],
			"Remedios T. Romualdez": [
				"Bonifacio", "Buenos Aires", "Cabanbanan", "Cagbaoto",
				"Cagbayog", "Cagdine", "Calibunan", "Comagascas", "Dela Paz",
				"Esperanza", "Happy Valley", "Kiwalo", "La Union", "Magaud",
				"Magsaysay", "Maribucao", "Mauswagon", "Poblacion", "Rizal",
				"San Isidro", "Santo Niño", "Tagbongabong", "Taglatawan", "Villa Paz"
			],
			"Santiago": [
				"Alegria", "Amontay", "Babay", "Bangayan", "Cabantao",
				"Cabantuhan", "Cagbay", "Cayetano", "Consuelo", "Dagohoy",
				"Dagohoy East", "Dipatlong", "Dona Telesfora", "Gibong",
				"Jagupit", "Mahayahay", "New Rizal", "Poblacion", "San Antonio",
				"San Isidro", "San Vicente", "Santa Ana", "Tinucoran", "Villangit"
			],
			"Tubay": [
				"Anahaw", "Ata-atahon", "Aurora", "Bagakay", "Bangayan",
				"Bangayan Proper", "Bantal", "Buenasuerte", "Cabcabon",
				"Cagdine", "Cahayagan", "Calibunan", "Caliw-an", "Comagascas",
				"Daanglungsod", "Del Carmen", "Dela Paz", "Esperanza", "Hilukay",
				"Imadejas", "Kinabjangan", "Kisante", "Libertad", "Mabini",
				"Magsaysay", "Magsaysay Proper", "Mahayahay", "Malicato Norte",
				"Malicato Sur", "New Rizal", "Poblacion", "Rizal", "San Isidro",
				"San Roque", "San Vicente", "Santa Ana", "Tagbuyawan", "Taglatawan",
				"Villa Kananga"
			],
			"Bayugan": [
				"Alegria", "Ampayon", "Baikingon", "Bangayan", "Batinguel",
				"Bitan-agan", "Cabantao", "Cagbas", "Calaitan", "Calamba",
				"Canayugan", "Claro Cortez", "Consuelo", "Doña Flavia",
				"Emilia", "Hilawan", "Karaus", "Katipunan", "Kiara",
				"Libertad", "Mahayag", "Montivesta", "Mt. Ararat", "New Salem",
				"Noli", "Pamaypayan", "Poblacion", "Rizal", "Rosario",
				"Salvacion", "San Isidro", "San Vicente", "Santa Irene", "Taglatawan",
				"Taglibas", "Villa Undayon", "Wasi-an"
			],
			"Bunawan": [
				"Ampayon", "Anislagan", "Bacolod", "Bacolod Proper", "Bacolod Nuevo",
				"Bayugan 3", "Cacao", "Caimpugan", "Canayugan", "Cinco",
				"Colorado", "Ebro", "Hermosillo", "Hinimbangan", "Katipunan",
				"Katipunan Proper", "Libertad", "Little Baguio", "Mahayag",
				"Maligaya", "Mamalayan", "Manat", "Marfil", "Montivesta",
				"Noli", "Oro", "Poblacion", "Rizal", "Rosario",
				"Salvacion", "San Agustin", "San Antonio", "San Isidro", "San Vicente",
				"Santa Irene", "Santa Teresa", "Taglatawan", "Taglibas", "Tinucoran",
				"Tinucoran Proper", "Villa Undayon", "Villangit", "Wasi-an"
			],
			"Esperanza": [
				"Aclan", "Anoling", "Bagakay", "Baylo", "Bitoon",
				"Bobonao", "Buenasuerte", "Bugas", "Cahayagan", "Caimpugan",
				"Canayugan", "Concord", "Dulian", "Haliogan", "Hinimbangan",
				"Kalabuan", "Karaus", "La Flora", "Lapinigan", "Lupig",
				"Mabuhay", "Magkiangkang", "Mahayag", "Maligaya", "Maliwanag",
				"Manat", "Manticao", "Miaray", "New Visayas", "Novele",
				"Osmeña", "Panagangan", "Poblacion", "Rajah Cabungso-an", "Rizal",
				"Sagunto", "San Isidro", "San Roque", "San Vicente", "Santa Cruz",
				"Taglatawan", "Tinucoran", "Tinucoran Proper", "Villa Pereda", "Villa Undayon"
			],
			"La Paz": [
				"Aclan", "Anoling", "Bagakay", "Baylo", "Bitoon",
				"Bobonao", "Buenasuerte", "Bugas", "Cahayagan", "Caimpugan",
				"Canayugan", "Concord", "Dulian", "Haliogan", "Hinimbangan",
				"Kalabuan", "Karaus", "La Flora", "Lapinigan", "Lupig",
				"Mabuhay", "Magkiangkang", "Mahayag", "Maligaya", "Maliwanag",
				"Manat", "Manticao", "Miaray", "New Visayas", "Novele",
				"Osmeña", "Panagangan", "Poblacion", "Rajah Cabungso-an", "Rizal",
				"Sagunto", "San Isidro", "San Roque", "San Vicente", "Santa Cruz",
				"Taglatawan", "Tinucoran", "Tinucoran Proper", "Villa Pereda", "Villa Undayon"
			],
			"Loreto": [
				"Alvarado", "Aurora", "Bagakay", "Bongbongon", "Buenavista",
				"Caloc-an", "Cinco", "Comota", "Concord", "Dagohoy",
				"Del Monte", "Ditucalan", "Dumagoc", "Ebro", "Esperanza",
				"Florida", "Geguintalaan", "Gigacot", "Happy Valley", "Kamagong",
				"Karaus", "Katipunan", "Kiwalo", "La Paz", "Labon",
				"Lapinigan", "Libertad", "Lupig", "Mabuhay", "Mahayahay",
				"Mahayhay", "Malibago", "Maliwanag", "Manat", "Napnapan",
				"New Tubigon", "New Visayas", "Panagangan", "Poblacion", "Rajah Cabungso-an",
				"Rizal", "San Isidro", "San Jose", "San Lorenzo", "San Vicente",
				"Santa Maria", "Santo Niño", "Sugbay", "Tagapua", "Tagubaybay",
				"Tagunan", "Tinucoran", "Tinucoran Proper", "Uba", "Villa Pereda",
				"Villa Undayon"
			],
			"Prosperidad": [
				"Ampayon", "Ampayon", "Bao", "Bayugan", "Cabantao",
				"Cabcabon", "Cabantian", "Calaitan", "Calamba", "Canayugan",
				"Cinco", "Cubay", "Cubay-Estrella", "Cubay-Obao", "Hilwan",
				"Katipunan", "Kiara", "Lunao", "Magkiangkang", "Magkidong",
				"Magsaysay", "Maliwanag", "Mambalili", "Marfil", "Montivesta",
				"Noli", "Pamaypayan", "Pisaan", "Poblacion", "Rizal",
				"Rosario", "Salvacion", "San Isidro", "San Pedro", "San Vicente",
				"Santa Irene", "Santo Niño", "Sugpatan", "Taglatawan", "Taglibas",
				"Tagmamarkay", "Villa Undayon", "Wasi-an"
			],
			"Rosario": [
				"Bayugan 2", "Bongbongon", "Cabantao", "Calaitan", "Calamba",
				"Canayugan", "Concord", "Haliogan", "Hilawan", "Katipunan",
				"Kiara", "Lapinigan", "Libertad", "Mahayag", "Mahogany",
				"Mahayahay", "Mahayhay", "Maliwanag", "Manat", "Matabao",
				"Montivesta", "New Tubigon", "New Visayas", "Poblacion", "Rizal",
				"Rosario", "Salvacion", "San Isidro", "San Pedro", "San Vicente",
				"Santa Irene", "Santo Niño", "Sugpatan", "Taglatawan", "Taglibas",
				"Villa Undayon", "Wasi-an"
			],
			"San Francisco": [
				"Ampayon", "Buenasuerte", "Buhisan", "Caba", "Calaitan",
				"Calamba", "Calibunan", "Canayugan", "Cinco", "Consuelo",
				"Doña Flavia", "Hilwan", "Katipunan", "Kiara", "Lapinig",
				"Libertad", "Mahayag", "Mamacao", "Mamalayan", "Manat",
				"Marfil", "Montivesta", "Noli", "Pamaypayan", "Pisa-an",
				"Poblacion", "Rizal", "Rosario", "Salvacion", "San Isidro",
				"San Jose", "San Vicente", "Santa Irene", "Santo Niño", "Sugpatan",
				"Taglatawan", "Taglibas", "Villa Undayon", "Wasi-an"
			]

		}

		$('#province').change(function() {
			var selectedProvince = $(this).val();
			var municipalityOptions = $('#municipality');

			municipalityOptions.empty(); // Clear previous options
			municipalityOptions.append('<option value="">--Select a Municipality--</option>');

			// Fetch municipalities based on the selected province
			var selectedMunicipalities = municipalities[selectedProvince];
			if (selectedMunicipalities) {
				$.each(selectedMunicipalities, function(index, value) {
					municipalityOptions.append('<option>' + value + '</option>');
				});
			}
		});
		$('#municipality').change(function() {
			var selectedMunicipality = $(this).val();
			var barangayOptions = $('#barangay');

			barangayOptions.empty(); // Clear previous options
			barangayOptions.append('<option value="">--Select a barangay--</option>');

			// Fetch municipalities based on the selected province
			var selectedBarangays = barangays[selectedMunicipality];
			if (selectedBarangays) {
				$.each(selectedBarangays, function(index, value) {
					barangayOptions.append('<option>' + value + '</option>');
				});
			}
		});

		var selectedProvince = "<?php echo isset($province) ? $province : ''; ?>";
		$('#province').val(selectedProvince).change();
		var municipalityValue = "<?php echo isset($municipality) ? $municipality : ''; ?>";
		$('#municipality').val(municipalityValue).change(); // Set the value directly from the database
		var barangayValue = "<?php echo isset($barangay) ? $barangay : ''; ?>";
		$('#barangay').val(barangayValue).change(); // Set the value directly from the database
})