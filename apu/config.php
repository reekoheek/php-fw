<?php
/**
 * You can update to configure Apu Framework
 * NS	: Namespace for Apu Framework
 */
global $CFG_APU;
$CFG_APU = new stdClass();
$CFG_APU->APP_NAME = "";
$CFG_APU->BASEDIR = "";
$CFG_APU->THEME = "apu";
$CFG_APU->NS[] = "/apu";
$CFG_APU->NS[] = "/modules";
$CFG_APU->DEBUG = "/apu";

global $CFG_ACTION;
$CFG_ACTION = new stdClass();
$CFG_ACTION->DEFAULT = "login";
$CFG_ACTION->SCOPE = "_REQUEST";
$CFG_ACTION->NS[] = "/todo/action";

global $CFG_MSG;
$CFG_MSG = new stdClass();
$CFG_MSG->NS[] = "/message/message";
$CFG_MSG->NS[] = "/todo/message/message";

global $CFG_VALIDATION;
$CFG_VALIDATION = new stdClass();
$CFG_VALIDATION->MSG["!isEmpty"] = "error.fieldEmpty";
$CFG_VALIDATION->MSG["isNumeric"] = "error.mustNumeric";

global $CFG_DB;
$CFG_DB = new stdClass();
$CFG_DB->ID = "__ID__";
// TODO unimplemented version yet
$CFG_DB->VERSION = "__VERSION__";

// connection default
$CFG_DB->CON["DEFAULT"] = new stdClass();
$CFG_DB->CON["DEFAULT"]->DRIVER = "mysql";
$CFG_DB->CON["DEFAULT"]->HOST = "localhost";
$CFG_DB->CON["DEFAULT"]->USER = "root";
$CFG_DB->CON["DEFAULT"]->PWD = "123456";
$CFG_DB->CON["DEFAULT"]->DB = "todo";

global $CFG_LOG;
$CFG_LOG = new stdClass();
$CFG_LOG->PRIORITY = "DEBUG";

global $CFG_RPC;
$CFG_RPC->MODULES[0]->NAME = "Test";
$CFG_RPC->MODULES[0]->METHODS = array( "hello" );
?>