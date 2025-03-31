<?php
	function getNiveauUserPost($nbPost){
		if($nbPost < 10){
			return 0;
		}else{
			if($nbPost >= 10 AND $nbPost < 50){
				return 1;
			}else{
				if($nbPost >= 50 AND $nbPost < 250){
					return 2;
				}else{
					if($nbPost >= 250 AND $nbPost < 1250){
						return 3;
					}else{
						if($nbPost >= 1250 AND $nbPost < 6250){
							return 4;
						}else{
							return 5;
						}
					}
				}
			}
		}
	}
	
	function getNiveauPostName($niveau){
		$name = array("Mangeur de Hot Dog","Mangeur de Tomate/Salade/Jambon","Mangeur de Salade (Saladier)","Mangeur de Brie/Beurre","Mangeur de Thon-Mayo occasionnel","Mangeur de Thon-Mayo récidiviste","Mangeur de Thon/Mayo Quotidien");
		return $name[$niveau];
	}
?>
