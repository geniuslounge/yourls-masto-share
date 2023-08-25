<?php
/*
Plugin Name: Share Mastodon
Plugin URI: https://github.com/geniuslounge/yourls-masto-share
Forked From: https://github.com/popnt/yourls-linkedin-share
Description: Adds Mastodon to the Quick Share Box. 
Version: 1.0
Author: Matt Troutman
Author URI: https://trtmn.com
*/


yourls_add_action( 'share_links', 'mastodon_share_url' );
function mastodon_share_url( $args ) {
    list( $longurl, $shorturl, $title, $text ) = $args;
    $shorturl = rawurlencode( $shorturl );
    $title = rawurlencode( htmlspecialchars_decode( $title ) );
    $toot_text = $title . ' ' . $shorturl ;
    
    // Plugin URL (no URL is hardcoded)
    $pluginurl = YOURLS_PLUGINURL . '/'.yourls_plugin_basename( dirname(__FILE__) );
    $icon = $pluginurl.'/mastodon.png';
    echo <<<Mastodon
    <style type="text/css">
    #share_mastodon{
        background: transparent url("$icon") left center no-repeat;
    }
    </style>
    <a id="share_mastodon"
        href="https://hachyderm.io/share?text=$toot_text"
        title="Share on Mastodon"
        onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;">Mastodon
    </a>
    <script type="text/javascript">
    // Dynamically update Masto link
    // when user clicks on the "Share" Action icon, event $('#tweet_body').keypress() is fired, so we'll add to this
    $('#tweet_body').keypress(function(){
        var url = encodeURIComponent( $('#copylink').val() );
        var mastodon = 'https://hachyderm.io/share?text='+url;
        $('#share_mastodon').attr('href', mastodon);        
    });
    </script>
MASTODON;
}
