<?php
require 'simplehtmldom_1_9_1/simple_html_dom.php';


$youtubers = array(
    ['name' => 'KRYSA XXPOSED', 'username' => 'UCweOPLKfk1RSo8eVk7TNFJw', 'PRO' => 'https://yt3.ggpht.com/a/AATXAJx84awuAi_J9nxWBmiSXxn21Ki0ndU9HPHYwE5Dsg=s100-c-k-c0xffffffff-no-rj-mo'],
    ['name' => 'RIOTCOKE', 'username' => 'UCb7UtqKUvEM_pmncmfrwVbQ', 'PRO' => 'https://yt3.ggpht.com/a-/AOh14GiypKL4O1IICc8Qo01xzGAVcvFS05jqi_thjlRgTw=s100-c-k-c0xffffffff-no-rj-mo'],
    ['name' => 'TLap', 'username' => 'UCh7xZGfIEO4cpiwGnH74HUw', 'PRO' => 'https://yt3.ggpht.com/a/AATXAJx4logYv1weE5mpNrqoQR5py8QtALSkRFjxe_HIBQ=s100-c-k-c0xffffffff-no-rj-mo'],
    ['name' => 'Skimask Andy', 'username' => 'UCZCcRs_5asbA1h2Lby1_Kqg', 'PRO' => 'https://yt3.ggpht.com/a/AATXAJyNGpK79OrzDJFHurmEIJCM-Xfu15iK6DIZ6vwWVA=s100-c-k-c0xffffffff-no-rj-mo'],
    ['name' => 'Archiliesx', 'username' => 'UC1mUzZ31N9hFeugMVQwHh9w', 'PRO' => 'https://yt3.ggpht.com/a/AATXAJw7EBnS0o5AFCnhKUH28CJQ0kghW01eRQlklXgLrQ=s100-c-k-c0xffffffff-no-rj-mo'],

);

$streamerData = mixData($youtubers);

echo json_encode($streamerData);

function mixData($youtubers)
{
    $youtubers = youtube($youtubers);

    $marge = array_merge($youtubers);

    usort($marge, function ($item1, $item2) {
        return $item1['status'] < $item2['status'];
    });
    return $marge;
}


function youtube($youtubers)
{
    $youtubersOutput = [];
// grab data youtubers
    foreach ($youtubers as $youtuber) {
        $API_KEY = 'AIzaSyBYEm9dMtMdoHasotGMk22ITtHY1Xy06eM';
        $ChannelID = $youtuber['username'];

        $channelInfo = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' . $ChannelID . '&type=video&eventType=live&key=' . $API_KEY;

        $extractInfo = file_get_contents($channelInfo);
        $extractInfo = str_replace('},]', "}]", $extractInfo);
        $showInfo = json_decode($extractInfo, true);


        if ($showInfo['pageInfo']['totalResults'] === 0) {

            // not live
            $youtubersOutput[] = [
                "avatar" => $youtuber['PRO'],
                "title" => "",
                "description" => "",
                "channelId" => $youtuber['username'],
                "channelTitle" => $youtuber['name'],
                "app" => "youtube",
                "status" => "off"
            ];

        } else {

            $youtubersOutput[] = [
                "avatar" => $youtuber['PRO'],
                "title" => $showInfo['items'][0]['snippet']['title'],
                "description" => $showInfo['items'][0]['snippet']['description'],
                "channelId" => $showInfo['items'][0]['snippet']['channelId'],
                "channelTitle" => $showInfo['items'][0]['snippet']['channelTitle'],
                "app" => "youtube",
                "status" => "on"
            ];

        }


    }

    return $youtubersOutput;

}

?>

