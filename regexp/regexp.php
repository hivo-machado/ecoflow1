<?php

	//echo validaEmail("ea.a@email.ao");
	//echo validaLogin("12345678901234567890");
	//echo validaSenha("");

//validar e-mails
function validaEmail($email) {

	$pattern = "/^[^!@#$%¨&*()0-9][a-zA-Z0-9_.]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/";

	return preg_match($pattern, $email);
}

//validar login
function validaLogin($login) {

	$pattern = "/^[A-Za-z0-9_]{1,20}$/";

	return preg_match($pattern, $login);
}

//validar senha
function validaSenha($senha) {

	$pattern = "/^[\S]{6,20}$/";

	return preg_match($pattern, $senha);
}

?>