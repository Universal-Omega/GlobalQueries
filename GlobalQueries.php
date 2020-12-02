<?php

use MediaWiki\MediaWikiServices;

class GlobalQueries {
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setFunctionHook( 'numberofusersinglobalgroup', [ __CLASS__, 'numberOfUsersInGlobalGroup' ], Parser::SFH_NO_HASH );
	}
	
	public static function numberOfUsersInGlobalGroup( Parser $parser, String $group = '' ) {
		$config = MediaWikiServices::getInstance()->getMainConfig();

		$dbw = wfGetDB( DB_MASTER, [], $config->get( 'CentralAuthDatabase' ) );
	
		return $dbw->selectRowCount( 'global_user_groups', '*', [ 'gug_group' => strtolower( $group ) ] );
	}
}
