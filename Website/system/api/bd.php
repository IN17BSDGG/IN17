
        <?php
		
		//echo $_POST["lkas"];
            try  
            {
				
                $connectionString="sqlsrv:Server=s-mssql2017,1433;Database=IN17;";
                //$db = new PDO($connectionString,"IN17W", "IN17WEB");
                $db = new PDO($connectionString,"IN17W", "IN17DB");
                $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                
                    //$sql = "select convert(varchar(max),shape) as Coordinates, rs, name from dbo.LANDKREISE" ;
                    $sql = "
					SELECT * , convert(varchar(max),shape) as Coordinates
FROM TOURISMUS t
INNER JOIN LANDKREISE l on t.landkreis = l.rs
WHERE t.jahr = '2012' AND t.monat = '2'
" ;
                


                $sth = $db->prepare($sql);
                $sth ->execute();
                $results = $sth->fetchAll();
				
				$newArr = [];
				
				foreach($results as $row) {
				   $Coordinates = $row['Coordinates'];
				   $name = $row['name'];
				   $rs = $row['rs'];
				   $uebernachtungen = $row['uebernachtungen'];
				   $ankuenfte = $row['ankuenfte'];
				   
				   
				   
				   $pos = strpos($Coordinates, "MULTIPOLYGON");

				   if($pos !== false) {
					   $Coordinates = str_replace("MULTIPOLYGON", "", $Coordinates);
					   $Coordinates = explode(")), ((", $Coordinates);
					   
					   
					   for($i = 0; $i < count($Coordinates); $i++) {
						   
						   $wtfarray = [];
						   
						   $Coordinates[$i] = str_replace("(", "", $Coordinates[$i]);
						   $Coordinates[$i] = str_replace(")", "", $Coordinates[$i]);
						   
						   $tempsArr = explode(",", $Coordinates[$i]);
						   $bbarray = [];
						   
						   for($ix = 0; $ix < count($tempsArr); $ix++) {
							   $bbarray = explode(" ", $tempsArr[$ix]);
							   $stempArr = [];
							   for($ixb = 0; $ixb < count($bbarray); $ixb++) {
								   if($bbarray[$ixb] != "") {
									   array_push($stempArr, $bbarray[$ixb]);
								   }
							   }
							   array_push($wtfarray, $stempArr);
						   }
						   
						   $Coordinates[$i] = $wtfarray;
					   }
				   } else {
				   
				   
					   $Coordinates = str_replace("POLYGON", "", $Coordinates);
					   $Coordinates = str_replace(", ", ",", $Coordinates);
					   
					   $Coordinates = str_replace("(", "", $Coordinates);
					   $Coordinates = str_replace(")", "", $Coordinates);
					   
					   $Coordinates = explode(",", $Coordinates);
					   
					   for($i = 0; $i < count($Coordinates); $i++) {
						   
						   $Coordinates[$i] = explode(" ", $Coordinates[$i]);
							
							$tempcord = [];
						   for($ix = 0; $ix < count($Coordinates[$i]); $ix++) {
							   if($Coordinates[$i][$ix] != "") {
								   array_push($tempcord, $Coordinates[$i][$ix]);
							   }
						   }
						   $Coordinates[$i] = $tempcord;
					   }
					   
					   //$Coordinates = null;
				   }
				   
				   
				   $tpArray = [];
				   $tpArray["Umriss"] = $Coordinates;
				   $tpArray["Landkreis"] = $name;
				   $tpArray["rs"] = $rs;
				   $tpArray["Übernachtungen"] = $uebernachtungen;
				   $tpArray["Ankünfte"] = $ankuenfte;

				   array_push($newArr,$tpArray);
				}

                



				print json_encode($newArr, JSON_PRETTY_PRINT);
            }  
            catch(Exception $e)  
            {   
                die( print_r( $e->getMessage() ) );   
            }  
        ?>
