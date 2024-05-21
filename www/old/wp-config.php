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
define('RELOCATE', true);

define('DB_NAME', 'elefante_bigblock');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'elefante_dev');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'ele890fante');

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
define('AUTH_KEY',         '+txez+ 5Z/}j0vW;Eq(Xv&^0>+A^5CXLlT)~YMIB5+-&b-zc E~t&h9#_jFQP0PM');
define('SECURE_AUTH_KEY',  'a2nvPMcnf}}5o^{NgM#*l%F^SiC)5tFD8&L1VTqY=fAx4xeNq~sk|yfTMN c)pFH');
define('LOGGED_IN_KEY',    'N,du+0J^W9sBRDW`S+EeCS3>m548d[z7J?7~<s}MdKW^99MXs$VB z{~*ro$1;$L');
define('NONCE_KEY',        'K1#~ouOlk@U>Yg@|3U}yST@)cUH=Fu;/$v9xW&v2Df1E7o*cXT(+Dp(b15qynmEk');
define('AUTH_SALT',        '<o`:7[7UDYak lWu8AMf+V3=Blv4-0^^PPGu|rJCt_FE!eZW#jB07^(HQk9V6uLK');
define('SECURE_AUTH_SALT', '~C9Npm?H /)|-DtVlTSR,R27Bd!-;?qYw~%5lSQ,`9{Pm5mp61APW$,G=;5,p^w=');
define('LOGGED_IN_SALT',   'lDl{*z!&/CgQP+}$k3U_X=Oo6l:!$JGT,3D`t<fUI@JjODBUK?V]fW)plgdu@k`(');
define('NONCE_SALT',       '&/`{=q0 #ccIh7v$-^=gcK3VAw|VjNwa5:VVv}U)?Ywe[fqv~[pj8lOk1EtrS_Vb');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

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
