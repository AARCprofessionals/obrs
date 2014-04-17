<?php
/*
    Plugin Name: getImage
    Description: Pega a última imagem filha de um post. Para usar este plugin basta você inserir um dos seguintes comandos no seu template: <strong>gi_fullsize(); gi_medium(); gi_thumbnail();</strong> Adicionando um parâmetro, ele vai parar dentro da tag de imagem gerada. Por padrão, o plugin retornará uma string contendo a tag da imagem gerada, mas você pode passar o segundo parametro como true para pedir que ele faça a impressão desta string."
    Version: 1.0
    Author: DGmike
    Author URI: http://dgmike.com.br
 */

/**
 * Pega o primeiro arquivo que foi feito o upload filho (relacionado) deste post
 *
 * @param object $post Post global gerado pelo the_post()
 * @return object Primeiro anexo (imagem) do post
 */
function gi_file ($all = false){
  global $post;
  $images = array ();

  if ($itens = get_posts(array('post_type' => 'attachment', 'post_parent' => $post->ID, 'orderby' => 'menu_order')) ) {
    foreach ($itens as $item) {
      apply_filters('the_title', $attachment->post_title);
      $images[] = $item;
    }
    $images = array_reverse($images);
  }
  return $all ? $images : reset($images);
}

/**
 * Pega as urls geradas de uma imagem
 *
 * @param object $image Imagem gerada pelo gi_file()
 * @param string $size  Tamanho de output que você desejaria receber. Os tamanhos disponivéis são: full, medium, thumbnail e all para receber os três tamanhos em um array
 * @param bool $full Retornar todas as informações? Se true, retornará um array com url, largura e altura
 * @return array|string
 */
function gi_url($image, $size, $full = false) {
  $sizes = array ('all', 'fullsize', 'medium', 'thumbnail');
  if (!$image) $image = gi_file();
  if (!$image || array_key_exists($size, $sizes) ) return;
  $sizes = array ('fullsize', 'medium', 'thumbnail');
  $urls = array ();
  foreach ($sizes as $s) {
    if ($full) {
      $urls[$s] = wp_get_attachment_image_src($image->ID, $s);
    } else {
      list ($url, $width, $height) = wp_get_attachment_image_src($image->ID, $s);
      $urls[$s] = $url;
    }
	$urls[$s]['data'] = (object) array(
		'post_ID' => $image->ID,
		'title' => $image->post_title,
		'caption' => $image->post_excerpt,
		'content' => $image->post_content,
	);
  }
  if ($size == 'all') return $urls;
  return $urls[$size];
}

/**
 * GImage retorna a tag da imagem no tamanho desejado
 *
 * @param string $size Tamhno que você deseja retornar
 * @return string
 */
function gImage ($size) {
  $image = gi_file ();
  return wp_get_attachment_image($image->ID, $size);
}
/**
 * Retorna a imagem em Fullsize
 *
 * @param bool $print Gostaria de imprimir a tag img?
 */
function gi_fullsize($print = false, $n=1) {
  $images = gi_library('fullsize', '', false, 'array');
  $return = isset($images[$n-1]) ? $images[$n-1] : '';
  if ($print) print $return;
  else return $return;
}
/**
 * Atalho para fullsize
 *
 * @param bool $print Gostaria de imprimir a tag img?
 */
function gi_full ($print = false, $n=1) {
  return gi_fullsize($print, $n);
}
/**
 * Retorna a imagem em tamanho Medium
 *
 * @param bool $print Gostaria de imprimir a tag img?
 */
function gi_medium($print = false, $n=1) {
  $images = gi_library('madium', '', false, 'array');
  $return = isset($images[$n-1]) ? $images[$n-1] : '';
  if ($print) print $return;
  else return $return;
}
/**
 * Retorna a imagem em Thumbnail
 *
 * @param bool $print Gostaria de imprimir a tag img?
 */
function gi_thumbnail($print = false, $n=1) {
  $images = gi_library('thumbnail', '', false, 'array');
  $return = isset($images[$n-1]) ? $images[$n-1] : '';
  if ($print) print $return;
  else return $return;
}
/**
 * Atalho para thumbnail
 *
 * @param bool $print Gostaria de imprimir a tag img?
 */
function gi_thumb ($print = false, $n=1) {
  return gi_thumbnail($print, $n);
}

/**
 * Get a library of images from a post
 *
 * @param string $size Escolha um tamanho que voce gostaria que retornasse: all, fullsize, medium, thumbnail
 * @param bool $print Você gostaria de imprimir o resultado? (somente valido se o $return_as for 'string')
 * @param string $return_as Escolha: array, brute_array, string
 * @return string|array
 */

function gi_library ($size = 'thumbnail', $extra = '', $print = false, $return_as = 'string') {
  if ($size == 'full') $size = 'fullsize';
  if ($size == 'thumb') $size = 'thumbnail';
  $images = gi_file(true);
  $imgs = array();
  foreach ($images as $image)
  	$imgs[] = gi_url($image, 'all', true);
  $images = array();
  foreach ($imgs as $img) {
    if ($size == 'all') $images[] = $img;
  	else $images[] = array ('title' => $img['title'], $size => $img[$size]);
  }
  if ($return_as == 'brute_array') return $images;
  $imgs = array();
  foreach ($images as $image) {
  	if (in_array($size, array('fullsize', 'medium', 'thumbnail')))
      $imgs[] = sprintf('<img src="%s" width="%s" height="%s" title="%s" %s  />', $image[$size][0], $image[$size][1], $image[$size][2], $image['title'], $extra);
  	if ($size == 'all') {
      $imgs[] = sprintf('<img src="%s" width="%s" height="%s" title="%s" %s  />', $image['fullsize'][0], $image['fullsize'][1], $image['fullsize'][2], $image['title'], $extra);
      $imgs[] = sprintf('<img src="%s" width="%s" height="%s" title="%s" %s  />', $image['medium'][0], $image['medium'][1], $image['medium'][2], $image['title'], $extra);
      $imgs[] = sprintf('<img src="%s" width="%s" height="%s" title="%s" %s  />', $image['thumbnail'][0], $image['thumbnail'][1], $image['thumbnail'][2], $image['title'], $extra);
  	}
  }
  if ($return_as == 'array') return $imgs;
  $imgs = implode("\n", $imgs);
  if ($return_as == 'string') {
    if ($print) print $imgs;
    return $imgs;
  }
}