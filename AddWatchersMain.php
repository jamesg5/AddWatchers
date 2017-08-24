<?php
class AddWatchers {
   // Register any render callbacks with the parser
   public static function onParserSetup( &$parser ) {

      // Create a function hook associating the "addwatchers" magic word with render()
      $parser->setFunctionHook( 'addwatchers', 'AddWatchers::render' );
   }

// Render the output of {{#addwatchers:}}.
   public static function render( $parser, $usernames = '', $rmvUsr = '') {
	global $wgAddWatchersShowOutput;
   	//strings
   	$msg = '';
   	$userNames = '';
   	//create array of user names
   	$userNamesArry = explode(',', $usernames);
   	//add each name to the userNames string in "", to be passed into sql statement
   	foreach ($userNamesArry as $userInArry) {
   		$userTrim = trim($userInArry);
   		//capitalize first letter of user name
   		$fL = strtoupper($userTrim[0]);
		$rL = substr($userTrim, 1);
		$userTrimProper = $fL.$rL;
		//add to userNames string
   		$userNames .= "'$userTrimProper',";
   	}
   	//trim the extra , the foreach put in at the end
   	$userNames = rtrim($userNames,",");
   	//sql, gets all user_real_names that matches with the user names passed into the {{#addwachers:name,name2,name3}}
   	$dbr = wfGetDB( DB_REPLICA );
	$res = $dbr->select(
		'user',
		array( 'user_name', 'user_real_name' ),
		"user_name IN ($userNames)",
		__METHOD__,
		array()
	);
	//iterate through the rows that were selected and add/remove them as watchers
	foreach ($res->result as $row) {
		$u = User::newFromName($row[user_name]); 
		if($rmvUsr=='REMOVE'){
			$u->removeWatch($parser->getTitle());
			$msg .= "$row[user_real_name] removed as watcher from this page.<br />";
		}else{
			$u->addWatch($parser->getTitle());
			$msg .= "$row[user_real_name] added as watcher to this page.<br />";
		}
	}
	//outputs the users that were successfully added or removed as watchers
	if ($wgAddWatchersShowOutput){
		return $msg;
	}
   }
}

