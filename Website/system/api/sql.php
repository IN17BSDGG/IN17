
        <?php
		
		//echo $_POST["lkas"];
            try  
            {
				$lkas = explode(",", $_POST["lkas"]);
				
				$lkastring = "";
				
				foreach ($lkas as $lka) {
					
					$lkastring = $lkastring."'".$lka."',";
					
				}
				
				$lkastring = substr($lkastring, 0, -1);
				
                $connectionString="sqlsrv:Server=s-mssql2017,1433;Database=IN17;";
                //$db = new PDO($connectionString,"IN17W", "IN17WEB");
                $db = new PDO($connectionString,"IN17W", "IN17DB");
                $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                $sql = "";

                if(!empty($_POST["sdate"]) && !empty($_POST["edate"])) {
                    $startArray = explode("/", $_POST["sdate"]);
                    $endArray   = explode("/", $_POST["edate"]);



                    $jahre = "(";
                    for($i = $startArray[1]; $i <= $endArray[1]; $i++) {
                        $jahre = $jahre . $i .",";
                    }

                    $jahre = substr($jahre, 0, -1);

                    $jahre = $jahre.")";

                    $sql = "SELECT [jahr],[monat],[landkreis],[ankuenfte],[uebernachtungen],[jm],l.name FROM TOURISMUS t INNER JOIN LANDKREISE l on t.landkreis = l.rs WHERE l.name in (".$lkastring.") AND t.jahr in ".$jahre;
                } else {
                    //$sql = "SELECT [jahr],[monat],[landkreis],[ankuenfte],[uebernachtungen],[jm],l.name FROM TOURISMUS t INNER JOIN LANDKREISE l on t.landkreis = l.rs WHERE l.name in (".$lkastring.") AND t.jahr = 2012";
                }


                $sth = $db->prepare($sql);
                $sth ->execute();
                $array = $sth->fetchAll();

                //Bundesländer
                $bndArray = [];
                $array1 = [];
                if(!empty($_POST["bnds"])) {

                    $bndExplode = explode(",", $_POST["bnds"]);

                    $bndStringList = "";
                    for($i = 0; $i < count($bndExplode); $i++) {
                        $bndStringList = $bndStringList."'".$bndExplode[$i]."',";
                    }
                    $bndStringList = substr($bndStringList, 0, -1);

                    if (!empty($_POST["sdate"]) && !empty($_POST["edate"])) {
                        $startArray = explode("/", $_POST["sdate"]);
                        $endArray = explode("/", $_POST["edate"]);

                        $jahre = "(";
                        for ($i = $startArray[1]; $i <= $endArray[1]; $i++) {
                            $jahre = $jahre . $i . ",";
                        }

                        $jahre = substr($jahre, 0, -1);

                        $jahre = $jahre . ")";

                        $sql = "SELECT t.[id]
                                 ,t.[jahr] as jahr
                                 ,t.[monat] as monat
                                 ,t.[jm] as jm
                                 ,t.[ankuenfte] as ankuenfte
                                 ,t.[uebernachtungen] as uebernachtungen
                                 ,t.[landkreis] as landkreis
                                 ,kr.[name] as Kreis
                                 ,bl.[name] as name
                            FROM [IN17].[dbo].[TOURISMUS] t
                                     right outer join LANDKREISE kr on (t.landkreis=kr.rs)
                                     inner join BUNDESLAENDER bl on (kr.[rs_bundesland]=bl.rs)
                            Where bl.[name] in (".$bndStringList.") AND t.jahr in " . $jahre;
                    } else {
                        //$sql = "SELECT [jahr],[monat],[landkreis],[ankuenfte],[uebernachtungen],[jm],l.name FROM TOURISMUS t INNER JOIN LANDKREISE l on t.landkreis = l.rs WHERE l.name in (" . $lkastring . ") AND t.jahr = 2012";
                    }
                    $sth1 = $db->prepare($sql);
                    $sth1 ->execute();
                    $array1 = $sth1->fetchAll();
                }

                if(!empty($array1)) {
                    $array = array_merge($array, $array1);
                }



				print json_encode($array, JSON_PRETTY_PRINT);
            }  
            catch(Exception $e)  
            {   
                die( print_r( $e->getMessage() ) );   
            }  
        ?>
