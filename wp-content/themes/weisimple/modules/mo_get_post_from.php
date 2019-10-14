<?php
/**
 * [mo_get_post_from description]
 * @param  string $pid      [description]
 * @param  string $prevtext [description]
 * @return [type]           [description]
 */
function mo_get_post_from($pid='', $prevtext='来源：'){
    if( !_hui('post_from_s') ){
        return;
    }

    if( !$pid ){
        $pid = get_the_ID();
    }

    $fromname1 = trim(get_post_meta($pid, "tgwz", true));
        $fromname2 = trim(get_post_meta($pid, "zzwz", true));
        $fromname = ($fromname1) || ($fromname2);
    $fromurl = trim(get_post_meta($pid, "wzurl", true));
    $from = '';
    
    if( $fromname2 ){
        if( $fromurl && _hui('post_from_link_s') ){
            $from = '<a href="'.$fromurl.'" target="_blank" rel="external nofollow">'.$fromname2.'</a>';
        }else{
            $from = $fromname;
        }
        $from = (_hui('post_from_h1')?_hui('post_from_h1'):$prevtext).$from;
    }

    return $from; 
}