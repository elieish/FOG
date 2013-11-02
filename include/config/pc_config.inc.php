<?php
/*
 * Project
 * @author elie <elieish@gmail.com>
 * @version 1.0
 * @package Project 
 */
 # ==========================================================================
 # CONFIGURATION
 # ===========================================================================
 # System Settings
$_GLOBALS['site_name']													= "Website";
$_GLOBALS['title']														= "Foundation of Grace";#"Gina World";
$_GLOBALS['max_results']												= 20;
$_GLOBALS['log_file']													= "/var/log/gina_world/" . date("Ymd") . ".log";
$_GLOBALS['base_dir']													= dirname(dirname(dirname(__FILE__))) . "/";
$_GLOBALS['base_url']													= $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . "/../../";
$_GLOBALS['default_page']												= "home.html";
$_GLOBALS['default_action']												= "display";
$_GLOBALS['version']													= "0.1";
 # Database Connectivity
$_GLOBALS['mysql_host']													= "localhost";
$_GLOBALS['mysql_user']													= "gina_world";
$_GLOBALS['mysql_pass']													= "Gina_w0rdld";
$_GLOBALS['mysql_db']													= "gina_world";
$_GLOBALS['mysql_debug']												= true;
# Modules
$_GLOBALS['catalogue_enabled']											= true;
$_GLOBALS['catalogue_menu_label']										= "Catalogue";