<?


// this function will print the dictionary entry... a row in 3 columns .. flag is used to alternate the color of the rows
function print_entry($hw_iitk, $hw_uni, $hw_uni_full, $uw_head, $uw_restrict, $attributes, $lang_code, $freq, $priority, $gloss, $example, $index, $id, $flag )
{
	if ($flag == 0)
		{
			print "<tr bgcolor=#fff7ff>";
		}
		else
		{
			print "<tr bgcolor=#f7ffff>";
		}
		
		print "<td valign=top align=right>";
		print "<b>".$hw_uni_full ."</b><br />";
		print "<font size=-2 title='Hindi stem in unicode'>".$hw_uni."</font>";
		print "<br /><font size=-2 title='Hindi stem in iitk encoding'>".htmlentities($hw_iitk,ENT_QUOTES)."</font>";
		print "</td>";
		print "<td>";
		print "<font size=-2 title='unique id of this entry'><I>".$id."</I></font><br />";
		print "<font color=black size=-1 title='Result number'> [<b> ".$index."</b>]</font>";
		print "</td>";
		print "<td>";
		print "<font size=+1 title='English word corresponding to the Hindi word'>".htmlentities($uw_head,ENT_QUOTES)."</font>";
		print "    ";
                print "<font color=gray title='The discription that gives unique meaning to the english word'>[".htmlentities($uw_restrict,ENT_QUOTES)."]</font> <br/>";
                print "<font color=#ffa000 size=-2 title='List of attributes that describes the Hindi word'>".htmlentities($attributes,ENT_QUOTES)."</font> <br />";
                if ($gloss != "")
		{	
			print "<font color=blue title='meaning of the Hindi word'>  ".htmlentities($gloss,ENT_QUOTES)."</font><br>";
		}
		if ($example != "")
		{
                	print "<font color=green title='example sentence or fragment giving the appropriate usage of the word'><i>".htmlentities($example,ENT_QUOTES)."</i> </font><br>";
		}
                print "<font color=black size=-3>[";
                print " <font title='Language code(H for hindi)'>".$lang_code."</font>,";
                print " <font title='frequency of usage of the Hindi word'>".$freq."</font>,";
                print " <font title='Priority of the word'>".$priority."</font>]";
                print "</font>";

		print "</td></tr> \n";
		

}





// this function will replace the qualifier of restriction field in the UW of dictionary
function describe($restriction)
{
    if ($restriction != "")
	{	
    	    //arr = explode(restriction,'>');
	}
    else
	{
	   return ""; 
	}

}


?>
