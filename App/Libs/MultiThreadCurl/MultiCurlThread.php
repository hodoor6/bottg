<?php

function multi_thread_curl($urlArray, $optionArray, $nThreads) {

    //Group your urls into groups/threads.
    $curlArray = array_chunk($urlArray, $nThreads, $preserve_keys = true);

    //Iterate through each batch of urls.
    $ch = 'ch_';
    foreach($curlArray as $threads) {

        //Create your cURL resources.
        foreach($threads as $thread=>$value) {

            ${$ch . $thread} = curl_init();

            curl_setopt_array(${$ch . $thread}, $optionArray); //Set your main curl options.
            curl_setopt(${$ch . $thread}, CURLOPT_URL, $value); //Set url.

        }

        //Create the multiple cURL handler.
        $mh = curl_multi_init();

        //Add the handles.
        foreach($threads as $thread=>$value) {

            curl_multi_add_handle($mh, ${$ch . $thread});

        }

        $active = null;

        //execute the handles.
        do {

            $mrc = curl_multi_exec($mh, $active);

        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {

            if (curl_multi_select($mh) != -1) {
                do {

                    $mrc = curl_multi_exec($mh, $active);

                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }

        }

        //Get your data and close the handles.
        foreach($threads as $thread=>$value) {

            $results[$thread] = curl_multi_getcontent(${$ch . $thread});

            curl_multi_remove_handle($mh, ${$ch . $thread});

        }

        //Close the multi handle exec.
        curl_multi_close($mh);

    }


    return $results;

}