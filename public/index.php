<?php
/**
 * ReVa is the go-to project to manage your organization employee-vacation
 *
 * @version 1.0.0
 * @link https://github.com/spiroszermalias/reva
 * @package reva
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

 session_start();
 
 require_once '../init.php';
 
 new Controller\MainController;