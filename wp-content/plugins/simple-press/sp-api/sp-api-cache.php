<?php
/*
Simple:Press
cache support
$LastChangedDate: 2014-02-10 02:49:37 -0800 (Mon, 10 Feb 2014) $
$Rev: 11060 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

# ==================================================================
#
# 	SITE: This file is loaded at SITE
#	SP Cache Handling Routines
#
# ==================================================================


# ------------------------------------------------------------------
# sp_set_cache_type()
#
# Version: 5.4.2
# Called by other cache functions to set up the data key, life and
# whether the cache type needs deleting when a new add is made
# NOTE: Add new cache types into the case statement as required
#	$type:		string cache type
#	----------	---------------------------------------------
#	search:		search results per user
#	url			holds url - usually for a return redirect
#	bookmark	currently just used for a topic page bookmark
#	group		group view forum query
#	post		post content on a validation/save failure
# ------------------------------------------------------------------
function sp_set_cache_type($type) {
	global $spThisUser;

	$t = array();

	switch($type) {
		case 'search':
		case 'url':
		case 'bookmark':
			$t['datakey'] = sp_get_ip();
			$t['lifespan'] = 3600;
			$t['deleteBefore'] = true;
			$t['deleteAfter'] = false;
			break;
		case 'group':
			$t['datakey'] = $spThisUser->ID;
			$t['lifespan'] = 3600;
			$t['deleteBefore'] = false;
			$t['deleteAfter'] = false;
			break;
		case 'post':
			$t['datakey'] = sp_get_ip();
			$t['lifespan'] = 120;
			$t['deleteBefore'] = true;
			$t['deleteAfter'] = true;
			break;
	}

	$t['datakey'].= '*' . $type;
	return $t;
}

# ------------------------------------------------------------------
# sp_add_cache()
#
# Version: 5.4.2
# Adds a new record to the sfcache table
#	$type:		cache type
#	$value:		Expected - array
# ------------------------------------------------------------------
function sp_add_cache($type, $value) {
	if (empty($type) || empty($value)) return false;

	$t = sp_set_cache_type($type);

	if($t['deleteBefore']) {
		$sql = "DELETE FROM ".SFCACHE.
			   " WHERE cache_id = '".$t['datakey']."'";
		spdb_query($sql);
	}

	$now = (time() + $t['lifespan']);

	$sql =  'INSERT INTO '.SFCACHE.
			"(cache_id, cache_out, cache)
			VALUES
			('".$t['datakey']."', $now, '".wp_slash(serialize($value))."')";
	spdb_query($sql);
}

# ------------------------------------------------------------------
# sp_get_cache()
#
# Version: 5.4.2
# Gets a record(s) from the sfcache table
#	$type:		The unique cache type name
# ------------------------------------------------------------------
function sp_get_cache($type) {
	$t = sp_set_cache_type($type);

	$sql =  'SELECT cache FROM '.SFCACHE." WHERE cache_id = '".$t['datakey']."'";
	$r = spdb_select('var', $sql);

	if($t['deleteAfter']) {
		$sql = "DELETE FROM ".SFCACHE.
			   " WHERE cache_id = '".$t['datakey']."'";
		spdb_query($sql);
	}

	return wp_unslash(unserialize($r));
}

# ------------------------------------------------------------------
# sp_delete_cache()
#
# Version: 5.4.2
# Deletes all cache records that have timed out
# ------------------------------------------------------------------
function sp_delete_cache() {
	$now = time();
	$sql = 'DELETE FROM '.SFCACHE." WHERE cache_out < $now";
	spdb_query($sql);
}

# ------------------------------------------------------------------
# sp_flush_cache()
#
# Version: 5.4.2
# Deletes all cache records dependent upon type
# ------------------------------------------------------------------
function sp_flush_cache($type = 'all') {
	if($type == 'all') {
		spdb_query('TRUNCATE '.SFCACHE);
	} else {
		spdb_query("DELETE FROM ".SFCACHE." WHERE cache_id LIKE '%*".$type."'");
	}
}

?>