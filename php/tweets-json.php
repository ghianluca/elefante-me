<?php
    // more info about script http://www.wpreads.com/2013/06/how-to-get-latest-tweets-with-twitter-api-1-1-in-wordpress.html

    header('Content-Type: application/json; charset=utf-8');

    require_once('tweets.php');


    // settings
    $settings = array(
        'username' => "google",
        'count' => "5",
        'oauth_access_token' =>          "1538392538-lvl1tlDZ18iM3sdFqESYBPTuEa973cEsDYvmH3N",
        'oauth_access_token_secret' =>    "95lLjHZK5cYIQ7YADpjlMIG8efQSfjXFVppNY4Kw",
        'consumer_key' =>                 "pguq8XaJQ6TP7DOwaUllJA",
        'consumer_secret' =>              "IYlGu5OpG9S20ZZglVLJGdG09alwCkF2dU0e1soI"
    );

    $getfield = sprintf('?screen_name=%1$s&count=%2$s', $settings['username'], $settings['count']);

    // We are using GET Method to Fetch the latest tweets.
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';


    // Making an object to access our library class
    $twitter = new TwitterAPIExchange($settings);

    $data = $twitter->setGetfield( $getfield )->buildOauth($url, 'GET')->performRequest();
    $json = [];


    if ($data) {
        
        $data = json_decode($data);
        $data = objectToArray($data);


        if (!isset($data["errors"])) {

            foreach ($data as $key => $value) {
                $json[$key]["date"] = date( 'Y-m-d H:i:s', strtotime($value["created_at"]) );
                $json[$key]["tweet"] = tweet_html_text($value);
            }

        }else{
            $json[0]["date"] = "";
            $json[0]["tweet"] = $data["errors"]["0"]["message"];
        }

    }else{
        $json[0]["date"] = "";
        $json[0]["tweet"] = "";
    }


    echo json_encode($json);




function tweet_html_text(array $tweet) {
    $text = $tweet['text'];

    // hastags
    $linkified = array();
    foreach ($tweet['entities']['hashtags'] as $hashtag) {
        $hash = $hashtag['text'];

        if (in_array($hash, $linkified)) {
            continue; // do not process same hash twice or more
        }
        $linkified[] = $hash;

        // replace single words only, so looking for #Google we wont linkify >#Google<Reader
        $text = preg_replace('/#\b' . $hash . '\b/', sprintf('<a href="https://twitter.com/search?q=%%23%2$s&src=hash" target="_blank">#%1$s</a>', $hash, urlencode($hash)), $text);
    }

    // user_mentions
    $linkified = array();
    foreach ($tweet['entities']['user_mentions'] as $userMention) {
        $name = $userMention['name'];
        $screenName = $userMention['screen_name'];

        if (in_array($screenName, $linkified)) {
            continue; // do not process same user mention twice or more
        }
        $linkified[] = $screenName;

        // replace single words only, so looking for @John we wont linkify >@John<Snow
        $text = preg_replace('/@\b' . $screenName . '\b/', sprintf('<a href="https://www.twitter.com/%1$s" title="%2$s" target="_blank">@%1$s</a>', $screenName, $name), $text);
    }

    // urls
    $linkified = array();
    foreach ($tweet['entities']['urls'] as $url) {
        $url = $url['url'];

        if (in_array($url, $linkified)) {
            continue; // do not process same url twice or more
        }
        $linkified[] = $url;

        $text = str_replace($url, sprintf('<a href="%1$s" target="_blank">%1$s</a>', $url), $text);
    }

    return $text;
}
