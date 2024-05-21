<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'elefante_petbox');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'elefante_admin');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'pet2016box');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0FTl|F*%B4bo~u4w0}??nc>|7oNIdkH&$D#j5gHEVE[Pv+Kl]xB/nGY(7-5)*s<.');
define('SECURE_AUTH_KEY',  '7m-^8`$1+6o+=jE~M|:|KgFwCX%71FbAhb!}?l5*CMbifNcee[Q+%+-)@0~qrfpN');
define('LOGGED_IN_KEY',    '36`z8DHYh@Q?v#v`{!w#0>].o0ZxFrrW(J)mX7|)e%U0d|]f5@& -PSe-7~YxKwa');
define('NONCE_KEY',        '9m]7WV _9Z;64SS?}X?Kas~Fm6J%ghC|#:GaZVJ-/JNx;;:cA_>%0qTm$3c/%A(J');
define('AUTH_SALT',        'd1eY}} JQULc<`RhJrdsK2KU![D5Ut=q539urPtwh}FdH=0s:;:yULxeM}H<.`9h');
define('SECURE_AUTH_SALT', 'gaE.V|O13K,]-,!#kewdFv;eTB73&,vpW8$+z*@@gYPG+ShqUJzm1;Qwk iPq|)9');
define('LOGGED_IN_SALT',   ':%}`K>u+Ol(+]7]^j<$J9TQbT`1 KiAb`R|vvA&.s-Rrr8D6|^24|50n/<r]9g&K');
define('NONCE_SALT',       'fJAQ^e_P/hA>,zF%(I?&kT[,zK:T]7 A,/HD+5b3d{&E|p9S-c*`zaY>dFK-HB+<');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
