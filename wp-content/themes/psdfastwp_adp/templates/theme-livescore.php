<?php
/* Template Name: Template - Livescore */
get_header(); ?>

<section class="components">
	<div class="wrapper clearfix">
		<div class="adp_content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>
			<?php endwhile; else: ?>
	            <p><?php __('Sorry, no posts matched your criteria.', 'misresultados_pe');?></p>
			<?php endif; ?>
			<style>
				#fstpl .ifmenu li.ifmenu-odds{
					display: none!important;
				}
			</style>
		<?php if(strpos($con = ini_get("disable_functions"), "fsockopen") === false) {if(is_resource($fs = fsockopen("www.livescore.in", 80, $errno, $errstr, 3)) && !($stop = $write = !fwrite($fs, "GET /es/free/lsapi HTTP/1.1\r\nHost: www.livescore.in\r\nConnection: Close\r\nlsfid: 448626\r\n\r\n"))) {$content = "";while (!$stop && !feof($fs)) {$line = fgets($fs, 128);($write || $write = $line == "\r\n") && ($content .= $line);}fclose($fs);$c = explode("\n", $content);foreach($c as &$r) {$r = preg_replace("/^[0-9A-Fa-f]+\r/", "", $r);}$content = implode("", $c);} else $content .= $errstr."(".$errno.")<br />\n";} elseif(strpos($con, "file_get_contents") === false && ini_get("allow_url_fopen")) {$content = file_get_contents("https://www.livescore.in/es/free/lsapi", false, stream_context_create(array("http" => array("timeout" => 3, "header" => "lsfid: 448626 "))));} elseif(extension_loaded("curl") && strpos($con, "curl_") === false) {curl_setopt_array($curl = curl_init("https://www.livescore.in/es/free/lsapi"), array(CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => array("lsfid: 448626 ")));$content = curl_exec($curl);curl_close($curl);} else {$content = "La versión PHP del inScore no puede cargarse. Solicite a su proveedor de alojamiento web que habilite la función `file_get_contents`  junto  con la directiva `allow_url_fopen` o la función `fsockopen`.";}echo $content; ?>

		</div>
		<div class="adp_sidebar">
			<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
                <div class="clearfix">
                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                </div>
            <?php endif; ?>
		</div>

	</div>
</section>

<?php get_footer(); ?>
