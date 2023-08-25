<?php
/*
Plugin Name: Share Mastodon
Plugin URI: https://github.com/geniuslounge/yourls-masto-share
Description: Adds Mastodon to the Quick Share Box.
Version: 1.0.1
Author: Matt Troutman
Author URI: https://trtmn.com
*/


yourls_add_action( 'share_links', 'masto_share_url' );
function masto_share_url( $args ) {
    list( $longurl, $shorturl, $title, $text ) = $args;
    $shorturl = rawurlencode( $shorturl );
    $title = rawurlencode( htmlspecialchars_decode( $title ) );
    $toottext=$title.'%20'.$shorturl;

    // Plugin URL (no URL is hardcoded)
    $pluginurl = YOURLS_PLUGINURL . '/'.yourls_plugin_basename( dirname(__FILE__) );
    $icon = $pluginurl.'/mastodon.svg';
    echo <<<MASTO
    <style type="text/css">
    #share_linkedin{
        background: transparent url("$icon") left center no-repeat;
    }
    </style>
    <a id="share_linkedin"
        href="https://hachyderm.io/share?text=$toottext"
        title="Share on Masto"
        onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;">Mastodon
    </a>
    <script type="text/javascript">
    // Dynamically update Masto link
    // when user clicks on the "Share" Action icon, event $('#tweet_body').keypress() is fired, so we'll add to this
    $('#tweet_body').keypress(function(){
        var url = encodeURIComponent( $('#copylink').val() );
        var masto_body = $('#tweet_body').val();
        var masto = 'https://hachyderm.io/share?text='+masto_body;
        $('#share_linkedin').attr('href', masto);
    });
    </script>
MASTO;
}
