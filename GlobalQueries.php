<?php

use MediaWiki\MediaWikiServices;

class GlobalQueries {
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setFunctionHook( 'numberofusersinglobalgroup', [ __CLASS__, 'numberOfUsersInGlobalGroup' ], Parser::SFH_NO_HASH );
	}
	
	public static function numberOfUsersInGlobalGroup( Parser $parser, String $group = '' ) {
		$config = MediaWikiServices::getInstance()->getMainConfig();

		$dbr = wfGetDB( DB_REPLICA, [], $config->get( 'CentralAuthDatabase' ) );
	
		return $dbr->selectRowCount( 'global_user_groups', '*', [ 'gug_group' => strtolower( $group ) ] );
	}
}
