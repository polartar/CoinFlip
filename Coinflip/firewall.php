<?php
/************************************************************************/
/* PHP Firewall: Universal Firewall for WebSite                         */
/* ============================================                         */
/* Write by Cyril Levert                                                */
/* Copyright (c) 2009-2010                                              */
/* http://www.php-firewall.info                                         */
/* dev@php-maximus.org                                                  */
/* Others projects:                                                     */
/* CMS PHP Maximus ( with mysql database ) www.php-maximus.org          */
/* Blog PHP Minimus ( with mysqli database ) www.php-minimus.org        */
/* Mini CMS PHP Nanomus ( without database ) www.php-nanomus.org        */
/* Stop Spam Referer ( without database ) www.stop-spam-referer.info    */
/* Twitter clone ( PHP Kweeker CMS ) www.twitter.php-minimus.org        */
/* PHP Firewall ( without database ) www.php-firewall.info              */
/* Personnal blog www.cyril-levert.info                                 */
/* Release version 1.0.3                                                */
/* Release date : 12-04-2010                                            */
/*                                                                      */
/* This program is free software.                                       */
/************************************************************************/

/** IP Protected */
$IP_ALLOW = array();

/** configuration define */
define('PHP_FIREWALL_LANGUAGE', 'english' );
define('PHP_FIREWALL_ADMIN_MAIL', '' );
define('PHP_FIREWALL_PUSH_MAIL', false );
define('PHP_FIREWALL_LOG_FILE', 'logs' );
define('PHP_FIREWALL_PROTECTION_UNSET_GLOBALS', true );
define('PHP_FIREWALL_PROTECTION_RANGE_IP_DENY', false );
define('PHP_FIREWALL_PROTECTION_RANGE_IP_SPAM', false );
define('PHP_FIREWALL_PROTECTION_URL', true );
define('PHP_FIREWALL_PROTECTION_REQUEST_SERVER', true );
define('PHP_FIREWALL_PROTECTION_SANTY', true );
define('PHP_FIREWALL_PROTECTION_BOTS', true );
define('PHP_FIREWALL_PROTECTION_REQUEST_METHOD', true );
define('PHP_FIREWALL_PROTECTION_DOS', true );
define('PHP_FIREWALL_PROTECTION_UNION_SQL', true );
define('PHP_FIREWALL_PROTECTION_CLICK_ATTACK', true );
define('PHP_FIREWALL_PROTECTION_XSS_ATTACK', true );
define('PHP_FIREWALL_PROTECTION_COOKIES', true );
define('PHP_FIREWALL_PROTECTION_POST', false );
define('PHP_FIREWALL_PROTECTION_GET', false );
define('PHP_FIREWALL_PROTECTION_SERVER_OVH', true );
define('PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI', true );
define('PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX', true );
define('PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE', true );
define('PHP_FIREWALL_PROTECTION_SERVER_OVH_BY_IP', true );
define('PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI_BY_IP', true );
define('PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX_BY_IP', true );
define('PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE_BY_IP', true );
/** end configuration */

/** IPS PROTECTED */
if ( count( $IP_ALLOW ) > 0 ) {
	if ( in_array( $_SERVER['REMOTE_ADDR'], $IP_ALLOW ) ) return;
}
/** END IPS PROTECTED */


/** LANGUAGE */
if ( PHP_FIREWALL_LANGUAGE === 'french' ) {
	define('_PHPF_PROTECTION_DEDIBOX', 'Protection contre les serveurs DEDIBOX active, cette IP range n\'est pas autoris�e !');
	define('_PHPF_PROTECTION_DEDIBOX_IP', 'Protection contre les serveurs DEDIBOX active, cette IP range n\'est pas autoris�e !');

	define('_PHPF_PROTECTION_DIGICUBE', 'Protection contre les serveurs DIGICUBE active, this IP range is not allowed !');
	define('_PHPF_PROTECTION_DIGICUBE_IP', 'Protection contre les serveurs DIGICUBE active, cette IP n\'est pas autoris�e !');

	define('_PHPF_PROTECTION_KIMSUFI', 'Protection contre les serveurs KIMSUFI active, cette IP range n\'est pas autoris�e !');
	define('_PHPF_PROTECTION_OVH', 'Protection contre les serveurs OVH active, cette IP range n\'est pas autoris�e !');

	define('_PHPF_PROTECTION_BOTS', 'Attaque Bot d�tect�e ! stop it ...');
	define('_PHPF_PROTECTION_CLICK', 'Click attaque d�tect�e ! stop it .....');
	define('_PHPF_PROTECTION_DOS', 'Invalide user agent ! Stop it ...');
	define('_PHPF_PROTECTION_OTHER_SERVER', 'Poster depuis un autre serveur est interdit !');
	define('_PHPF_PROTECTION_REQUEST', 'M�thode de requ�te interdite ! Stop it ...');
	define('_PHPF_PROTECTION_SANTY', 'Attaque Santy detect�e ! Stop it ...');
	define('_PHPF_PROTECTION_SPAM', 'Protection SPAM IPs active, cette IP range n\'est pas autoris�e !');
	define('_PHPF_PROTECTION_SPAM_IP', 'Protection SPAM IPs active, cette IP range n\'est pas autoris�e !');
	define('_PHPF_PROTECTION_UNION', 'Attaque Union d�tect�e ! stop it ......');
	define('_PHPF_PROTECTION_URL', 'Protection url active, string non autoris�e !');
	define('_PHPF_PROTECTION_XSS', 'Attaque XSS d�tect�e ! stop it ...');
} else {
	define('_PHPF_PROTECTION_DEDIBOX', 'Protection DEDIBOX Server active, this IP range is not allowed !');
	define('_PHPF_PROTECTION_DEDIBOX_IP', 'Protection DEDIBOX Server active, this IP is not allowed !');

	define('_PHPF_PROTECTION_DIGICUBE', 'Protection DIGICUBE Server active, this IP range is not allowed !');
	define('_PHPF_PROTECTION_DIGICUBE_IP', 'Protection DIGICUBE Server active, this IP is not allowed !');

	define('_PHPF_PROTECTION_KIMSUFI', 'Protection KIMSUFI Server active, this IP range is not allowed !');
	define('_PHPF_PROTECTION_OVH', 'Protection OVH Server active, this IP range is not allowed !');

	define('_PHPF_PROTECTION_BOTS', 'Bot attack detected ! stop it ...');
	define('_PHPF_PROTECTION_CLICK', 'Click attack detected ! stop it .....');
	define('_PHPF_PROTECTION_DOS', 'Invalid user agent ! Stop it ...');
	define('_PHPF_PROTECTION_OTHER_SERVER', 'Posting from another server not allowed !');
	define('_PHPF_PROTECTION_REQUEST', 'Invalid request method check ! Stop it ...');
	define('_PHPF_PROTECTION_SANTY', 'Attack Santy detected ! Stop it ...');
	define('_PHPF_PROTECTION_SPAM', 'Protection SPAM IPs active, this IP range is not allowed !');
	define('_PHPF_PROTECTION_SPAM_IP', 'Protection died IPs active, this IP range is not allowed !');
	define('_PHPF_PROTECTION_UNION', 'Union attack detected ! stop it ......');
	define('_PHPF_PROTECTION_URL', 'Protection url active, string not allowed !');
	define('_PHPF_PROTECTION_XSS', 'XSS attack detected ! stop it ...');
}
/** END LANGUAGE*/


if ( PHP_FIREWALL_ACTIVATION === true ) {

	FUNCTION PHP_FIREWALL_unset_globals() {
		if ( ini_get('register_globals') ) {
			$allow = array('_ENV' => 1, '_GET' => 1, '_POST' => 1, '_COOKIE' => 1, '_FILES' => 1, '_SERVER' => 1, '_REQUEST' => 1, 'GLOBALS' => 1);
			foreach ($GLOBALS as $key => $value) {
				if ( ! isset( $allow[$key] ) ) unset( $GLOBALS[$key] );
			}
		}
	}

	if ( PHP_FIREWALL_PROTECTION_UNSET_GLOBALS === true ) PHP_FIREWALL_unset_globals();

	/** fonctions de base */
	FUNCTION PHP_FIREWALL_get_env($st_var) {
		global $HTTP_SERVER_VARS;
		if(isset($_SERVER[$st_var])) {
			return strip_tags( $_SERVER[$st_var] );
		} elseif(isset($_ENV[$st_var])) {
			return strip_tags( $_ENV[$st_var] );
		} elseif(isset($HTTP_SERVER_VARS[$st_var])) {
			return strip_tags( $HTTP_SERVER_VARS[$st_var] );
		} elseif(getenv($st_var)) {
			return strip_tags( getenv($st_var) );
		} elseif(function_exists('apache_getenv') && apache_getenv($st_var, true)) {
			return strip_tags( apache_getenv($st_var, true) );
		}
		return '';
	}

	FUNCTION PHP_FIREWALL_get_referer() {
		if( PHP_FIREWALL_get_env('HTTP_REFERER') )
			return PHP_FIREWALL_get_env('HTTP_REFERER');
		return 'no referer';
	}

	FUNCTION PHP_FIREWALL_get_ip() {
		if ( PHP_FIREWALL_get_env('HTTP_X_FORWARDED_FOR') ) {
			return PHP_FIREWALL_get_env('HTTP_X_FORWARDED_FOR');
		} elseif ( PHP_FIREWALL_get_env('HTTP_CLIENT_IP') ) {
			return PHP_FIREWALL_get_env('HTTP_CLIENT_IP');
		} else {
			return PHP_FIREWALL_get_env('REMOTE_ADDR');
		}
	}
	FUNCTION PHP_FIREWALL_get_user_agent() {
		if(PHP_FIREWALL_get_env('HTTP_USER_AGENT'))
			return PHP_FIREWALL_get_env('HTTP_USER_AGENT');
		return 'none';
	}

	FUNCTION PHP_FIREWALL_get_query_string() {
		if( PHP_FIREWALL_get_env('QUERY_STRING') )
			return str_replace('%09', '%20', PHP_FIREWALL_get_env('QUERY_STRING'));
		return '';
	}
	FUNCTION PHP_FIREWALL_get_request_method() {
		if(PHP_FIREWALL_get_env('REQUEST_METHOD'))
			return PHP_FIREWALL_get_env('REQUEST_METHOD');
		return 'none';
	}
	FUNCTION PHP_FIREWALL_gethostbyaddr() {
		if ( PHP_FIREWALL_PROTECTION_SERVER_OVH === true OR PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI === true OR PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX === true OR PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE === true ) {
			if ( @ empty( $_SESSION['PHP_FIREWALL_gethostbyaddr'] ) ) {
				return $_SESSION['PHP_FIREWALL_gethostbyaddr'] = @gethostbyaddr( PHP_FIREWALL_get_ip() );
			} else {
				return strip_tags( $_SESSION['PHP_FIREWALL_gethostbyaddr'] );
			}
		}
	}

	/** bases define */
	define('PHP_FIREWALL_GET_QUERY_STRING', strtolower( PHP_FIREWALL_get_query_string() ) );
	define('PHP_FIREWALL_USER_AGENT', PHP_FIREWALL_get_user_agent() );
	define('PHP_FIREWALL_GET_IP', PHP_FIREWALL_get_ip() );
	define('PHP_FIREWALL_GET_HOST', PHP_FIREWALL_gethostbyaddr() );
	define('PHP_FIREWALL_GET_REFERER', PHP_FIREWALL_get_referer() );
	define('PHP_FIREWALL_GET_REQUEST_METHOD', PHP_FIREWALL_get_request_method() );
	define('PHP_FIREWALL_REGEX_UNION','#\w?\s?union\s\w*?\s?(select|all|distinct|insert|update|drop|delete)#is');
	FUNCTION PHP_FIREWALL_push_email( $subject, $msg ) {
		$headers = "From: PHP Firewall: ".PHP_FIREWALL_ADMIN_MAIL." <".PHP_FIREWALL_ADMIN_MAIL.">\r\n"
			."Reply-To: ".PHP_FIREWALL_ADMIN_MAIL."\r\n"
			."Priority: urgent\r\n"
			."Importance: High\r\n"
			."Precedence: special-delivery\r\n"
			."Organization: PHP Firewall\r\n"
			."MIME-Version: 1.0\r\n"
			."Content-Type: text/plain\r\n"
			."Content-Transfer-Encoding: 8bit\r\n"
			."X-Priority: 1\r\n"
			."X-MSMail-Priority: High\r\n"
			."X-Mailer: PHP/" . phpversion() ."\r\n"
			."X-PHPFirewall: 1.0 by PHPFirewall\r\n"
			."Date:" . date("D, d M Y H:s:i") . " +0100\n";
		if ( PHP_FIREWALL_ADMIN_MAIL != '' )
			@mail( PHP_FIREWALL_ADMIN_MAIL, $subject, $msg, $headers );
	}

	FUNCTION PHP_FIREWALL_LOGS( $type ) {
		$f = fopen( dirname(__FILE__).'/'.PHP_FIREWALL_LOG_FILE.'.txt', 'a');
		$msg = date('j-m-Y H:i:s')." | $type | IP: ".PHP_FIREWALL_GET_IP." ] | DNS: ".gethostbyaddr(PHP_FIREWALL_GET_IP)." | Agent: ".PHP_FIREWALL_USER_AGENT." | URL: ".PHP_FIREWALL_REQUEST_URI." | Referer: ".PHP_FIREWALL_GET_REFERER."\n\n";
		fputs($f, $msg);
		fclose($f);
		if ( PHP_FIREWALL_PUSH_MAIL === true ) {
			PHP_FIREWALL_push_email( 'Alert PHP Firewall '.strip_tags( $_SERVER['SERVER_NAME'] ) , "PHP Firewall logs of ".strip_tags( $_SERVER['SERVER_NAME'] )."\n".str_replace('|', "\n", $msg ) );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_OVH === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'ovh') ) {
			PHP_FIREWALL_LOGS( 'OVH Server list' );
			die( _PHPF_PROTECTION_OVH );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_OVH_BY_IP === true ) {
		$ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( $ip[0].'.'.$ip[1] == '87.98' or  $ip[0].'.'.$ip[1] == '91.121' or  $ip[0].'.'.$ip[1] == '94.23' or $ip[0].'.'.$ip[1] == '213.186' or  $ip[0].'.'.$ip[1] == '213.251' ) {
			PHP_FIREWALL_LOGS( 'OVH Server IP' );
			die( _PHPF_PROTECTION_OVH );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'kimsufi') ) {
			PHP_FIREWALL_LOGS( 'KIMSUFI Server list' );
			die( _PHPF_PROTECTION_KIMSUFI );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'dedibox') ) {
			PHP_FIREWALL_LOGS( 'DEDIBOX Server list' );
			die( _PHPF_PROTECTION_DEDIBOX );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX_BY_IP === true ) {
		$ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( $ip[0].'.'.$ip[1] == '88.191' ) {
			PHP_FIREWALL_LOGS( 'DEDIBOX Server IP' );
			die( _PHPF_PROTECTION_DEDIBOX_IP );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'digicube') ) {
			PHP_FIREWALL_LOGS( 'DIGICUBE Server list' );
			die( _PHPF_PROTECTION_DIGICUBE );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE_BY_IP === true ) {
		$ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( $ip[0].'.'.$ip[1] == '95.130' ) {
			PHP_FIREWALL_LOGS( 'DIGICUBE Server IP' );
			die( _PHPF_PROTECTION_DIGICUBE_IP );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_COOKIES === true ) {
		$ct_rules = Array('applet', 'base', 'bgsound', 'blink', 'embed', 'expression', 'frame', 'javascript', 'layer', 'link', 'meta', 'object', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload', 'script', 'style', 'title', 'vbscript', 'xml');
		if ( PHP_FIREWALL_PROTECTION_COOKIES === true ) {
			foreach($_COOKIE as $value) {
				$check = str_replace($ct_rules, '*', $value);
				if( $value != $check ) {
					PHP_FIREWALL_LOGS( 'Cookie protect' );
					unset( $value );
				}
			}
		}
		if ( PHP_FIREWALL_PROTECTION_POST === true ) {
			foreach( $_POST as $value ) {
				$check = str_replace($ct_rules, '*', $value);
				if( $value != $check ) {
					PHP_FIREWALL_LOGS( 'POST protect' );
					unset( $value );
				}
			}
		}
		if ( PHP_FIREWALL_PROTECTION_GET === true ) {
			foreach( $_GET as $value ) {
				$check = str_replace($ct_rules, '*', $value);
				if( $value != $check ) {
					PHP_FIREWALL_LOGS( 'GET protect' );
					unset( $value );
				}
			}
		}
	}

	/** Posting from other servers in not allowed */
	if ( PHP_FIREWALL_PROTECTION_REQUEST_SERVER === true ) {
		if ( PHP_FIREWALL_GET_REQUEST_METHOD == 'POST' ) {
			if (isset($_SERVER['HTTP_REFERER'])) {
				if ( ! stripos( $_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'], 0 ) ) {
					PHP_FIREWALL_LOGS( 'Posting another server' );
					die( _PHPF_PROTECTION_OTHER_SERVER );
				}
			}
		}
	}

	/** protection contre le vers santy */
	if ( PHP_FIREWALL_PROTECTION_SANTY === true ) {
		$ct_rules = array('rush','highlight=%','perl','chr(','pillar','visualcoder','sess_');
		$check = str_replace($ct_rules, '*', strtolower(PHP_FIREWALL_REQUEST_URI) );
		if( strtolower(PHP_FIREWALL_REQUEST_URI) != $check ) {
			PHP_FIREWALL_LOGS( 'Santy' );
			die( _PHPF_PROTECTION_SANTY );
		}
	}

	/** protection bots */
	if ( PHP_FIREWALL_PROTECTION_BOTS === true ) {
		$ct_rules = array( '@nonymouse', 'addresses.com', 'ideography.co.uk', 'adsarobot', 'ah-ha', 'aktuelles', 'alexibot', 'almaden', 'amzn_assoc', 'anarchie', 'art-online', 'aspseek', 'assort', 'asterias', 'attach', 'atomz', 'atspider', 'autoemailspider', 'backweb', 'backdoorbot', 'bandit', 'batchftp', 'bdfetch', 'big.brother', 'black.hole', 'blackwidow', 'blowfish', 'bmclient', 'boston project', 'botalot', 'bravobrian', 'buddy', 'bullseye', 'bumblebee ', 'builtbottough', 'bunnyslippers', 'capture', 'cegbfeieh', 'cherrypicker', 'cheesebot', 'chinaclaw', 'cicc', 'civa', 'clipping', 'collage', 'collector', 'copyrightcheck', 'cosmos', 'crescent', 'custo', 'cyberalert', 'deweb', 'diagem', 'digger', 'digimarc', 'diibot', 'directupdate', 'disco', 'dittospyder', 'download accelerator', 'download demon', 'download wonder', 'downloader', 'drip', 'dsurf', 'dts agent', 'dts.agent', 'easydl', 'ecatch', 'echo extense', 'efp@gmx.net', 'eirgrabber', 'elitesys', 'emailsiphon', 'emailwolf', 'envidiosos', 'erocrawler', 'esirover', 'express webpictures', 'extrac', 'eyenetie', 'fastlwspider', 'favorg', 'favorites sweeper', 'fezhead', 'filehound', 'filepack.superbr.org', 'flashget', 'flickbot', 'fluffy', 'frontpage', 'foobot', 'galaxyBot', 'generic', 'getbot ', 'getleft', 'getright', 'getsmart', 'geturl', 'getweb', 'gigabaz', 'girafabot', 'go-ahead-got-it', 'go!zilla', 'gornker', 'grabber', 'grabnet', 'grafula', 'green research', 'harvest', 'havindex', 'hhjhj@yahoo', 'hloader', 'hmview', 'homepagesearch', 'htmlparser', 'hulud', 'http agent', 'httpconnect', 'httpdown', 'http generic', 'httplib', 'httrack', 'humanlinks', 'ia_archiver', 'iaea', 'ibm_planetwide', 'image stripper', 'image sucker', 'imagefetch', 'incywincy', 'indy', 'infonavirobot', 'informant', 'interget', 'internet explore', 'infospiders',  'internet ninja', 'internetlinkagent', 'interneteseer.com', 'ipiumbot', 'iria', 'irvine', 'jbh', 'jeeves', 'jennybot', 'jetcar', 'joc web spider', 'jpeg hunt', 'justview', 'kapere', 'kdd explorer', 'kenjin.spider', 'keyword.density', 'kwebget', 'lachesis', 'larbin',  'laurion(dot)com', 'leechftp', 'lexibot', 'lftp', 'libweb', 'links aromatized', 'linkscan', 'link*sleuth', 'linkwalker', 'libwww', 'lightningdownload', 'likse', 'lwp','mac finder', 'mag-net', 'magnet', 'marcopolo', 'mass', 'mata.hari', 'mcspider', 'memoweb', 'microsoft url control', 'microsoft.url', 'midown', 'miixpc', 'minibot', 'mirror', 'missigua', 'mister.pix', 'mmmtocrawl', 'moget', 'mozilla/2', 'mozilla/3.mozilla/2.01', 'mozilla.*newt', 'multithreaddb', 'munky', 'msproxy', 'nationaldirectory', 'naverrobot', 'navroad', 'nearsite', 'netants', 'netcarta', 'netcraft', 'netfactual', 'netmechanic', 'netprospector', 'netresearchserver', 'netspider', 'net vampire', 'newt', 'netzip', 'nicerspro', 'npbot', 'octopus', 'offline.explorer', 'offline explorer', 'offline navigator', 'opaL', 'openfind', 'opentextsitecrawler', 'orangebot', 'packrat', 'papa foto', 'pagegrabber', 'pavuk', 'pbwf', 'pcbrowser', 'personapilot', 'pingalink', 'pockey', 'program shareware', 'propowerbot/2.14', 'prowebwalker', 'proxy', 'psbot', 'psurf', 'puf', 'pushsite', 'pump', 'qrva', 'quepasacreep', 'queryn.metasearch', 'realdownload', 'reaper', 'recorder', 'reget', 'replacer', 'repomonkey', 'rma', 'robozilla', 'rover', 'rpt-httpclient', 'rsync', 'rush=', 'searchexpress', 'searchhippo', 'searchterms.it', 'second street research', 'seeker', 'shai', 'sitecheck', 'sitemapper', 'sitesnagger', 'slysearch', 'smartdownload', 'snagger', 'spacebison', 'spankbot', 'spanner', 'spegla', 'spiderbot', 'spiderengine', 'sqworm', 'ssearcher100', 'star downloader', 'stripper', 'sucker', 'superbot', 'surfwalker', 'superhttp', 'surfbot', 'surveybot', 'suzuran', 'sweeper', 'szukacz/1.4', 'tarspider', 'takeout', 'teleport', 'telesoft', 'templeton', 'the.intraformant', 'thenomad', 'tighttwatbot', 'titan', 'tocrawl/urldispatcher','toolpak', 'traffixer', 'true_robot', 'turingos', 'turnitinbot', 'tv33_mercator', 'uiowacrawler', 'urldispatcherlll', 'url_spider_pro', 'urly.warning ', 'utilmind', 'vacuum', 'vagabondo', 'vayala', 'vci', 'visualcoders', 'visibilitygap', 'vobsub', 'voideye', 'vspider', 'w3mir', 'webauto', 'webbandit', 'web.by.mail', 'webcapture', 'webcatcher', 'webclipping', 'webcollage', 'webcopier', 'webcopy', 'webcraft@bea', 'web data extractor', 'webdav', 'webdevil', 'webdownloader', 'webdup', 'webenhancer', 'webfetch', 'webgo', 'webhook', 'web.image.collector', 'web image collector', 'webinator', 'webleacher', 'webmasters', 'webmasterworldforumbot', 'webminer', 'webmirror', 'webmole', 'webreaper', 'websauger', 'websaver', 'website.quester', 'website quester', 'websnake', 'websucker', 'web sucker', 'webster', 'webreaper', 'webstripper', 'webvac', 'webwalk', 'webweasel', 'webzip', 'wget', 'widow', 'wisebot', 'whizbang', 'whostalking', 'wonder', 'wumpus', 'wweb', 'www-collector-e', 'wwwoffle', 'wysigot', 'xaldon', 'xenu', 'xget', 'x-tractor', 'zeus' );
		$check = str_replace($ct_rules, '*', strtolower(PHP_FIREWALL_USER_AGENT) );
		if( strtolower(PHP_FIREWALL_USER_AGENT) != $check ) {
			PHP_FIREWALL_LOGS( 'Bots attack' );
			die( _PHPF_PROTECTION_BOTS );
		}
	}

	/** Invalid request method check */
	if ( PHP_FIREWALL_PROTECTION_REQUEST_METHOD === true ) {
		if(strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='get' AND strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='head' AND strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='post' AND strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='put') {
			PHP_FIREWALL_LOGS( 'Invalid request' );
			die( _PHPF_PROTECTION_REQUEST );
		}
	}

	/** protection dos attaque */
	if ( PHP_FIREWALL_PROTECTION_DOS === true ) {
		if ( !defined('PHP_FIREWALL_USER_AGENT')  || PHP_FIREWALL_USER_AGENT == '-' ) {
			PHP_FIREWALL_LOGS( 'Dos attack' );
			die( _PHPF_PROTECTION_DOS );
		}
	}

	/** protection union sql attaque */
	if ( PHP_FIREWALL_PROTECTION_UNION_SQL === true ) {
		$stop = 0;
		$ct_rules = array( '*/from/*', '*/insert/*', '+into+', '%20into%20', '*/into/*', ' into ', 'into', '*/limit/*', 'not123exists*', '*/radminsuper/*', '*/select/*', '+select+', '%20select%20', ' select ',  '+union+', '%20union%20', '*/union/*', ' union ', '*/update/*', '*/where/*' );
		$check    = str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING );
		if( PHP_FIREWALL_GET_QUERY_STRING != $check ) $stop++;
		if (preg_match(PHP_FIREWALL_REGEX_UNION, PHP_FIREWALL_GET_QUERY_STRING)) $stop++;
		if (preg_match('/([OdWo5NIbpuU4V2iJT0n]{5}) /', rawurldecode( PHP_FIREWALL_GET_QUERY_STRING ))) $stop++;
		if (strstr(rawurldecode( PHP_FIREWALL_GET_QUERY_STRING ) ,'*')) $stop++;
		if ( !empty( $stop ) ) {
			PHP_FIREWALL_LOGS( 'Union attack' );
			die( _PHPF_PROTECTION_UNION );
		}
	}

	/** protection click attack */
	if ( PHP_FIREWALL_PROTECTION_CLICK_ATTACK === true ) {
		$ct_rules = array( '/*', 'c2nyaxb0', '/*' );
		if( PHP_FIREWALL_GET_QUERY_STRING != str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING ) ) {
			PHP_FIREWALL_LOGS( 'Click attack' );
			die( _PHPF_PROTECTION_CLICK );
		}
	}

	/** protection XSS attack */
	/*if (( PHP_FIREWALL_PROTECTION_XSS_ATTACK === true ) && ( true )) {
		$ct_rules = array( 'http\:\/\/', 'https\:\/\/', 'cmd=', '&cmd', 'exec', 'concat', './', '../',  'http:', 'h%20ttp:', 'ht%20tp:', 'htt%20p:', 'http%20:', 'https:', 'h%20ttps:', 'ht%20tps:', 'htt%20ps:', 'http%20s:', 'https%20:', 'ftp:', 'f%20tp:', 'ft%20p:', 'ftp%20:', 'ftps:', 'f%20tps:', 'ft%20ps:', 'ftp%20s:', 'ftps%20:', '.php?url=' );
		$check    = str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING );
		if( PHP_FIREWALL_GET_QUERY_STRING != $check ) {
			PHP_FIREWALL_LOGS( 'XSS attack' );
			die( _PHPF_PROTECTION_XSS );
		}
	}*/

}
