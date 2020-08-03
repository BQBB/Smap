<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Smap</title>
    
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="js/snap.js"></script>
    <link rel="stylesheet" href="css/snap.css" >
</head>
<body>











   <?php

if($_SERVER['REQUEST_METHOD']=='GET'){
   echo ' <div class="Myform " > 
                <div class="container">
                     <form class="form rad text-center" method="post">
                        <img src="img/snap.jpg" alt="Snapchat" class="img-fluid">
                        <p>Smap</p>
                        <input type="text" class="form-control rad text-center" placeholder="Longitude" name="lon">
                        <input type="text" class="form-control rad text-center" placeholder="Latitude" name="lat">
                        <input type="text" class="form-control rad text-center" placeholder="Radius(meters)" name="rad">
                        <button class="btn btn-primary btn-block rad" >Fetch</button>
                     </form>
                </div>
            </div>';

}
else{


echo Fetch($_POST['lat'],$_POST['lon'],$_POST['rad']);
echo '<div  > 
            <div class="container">
                <div class="show rad">
                 <center>
                     <img     hidden/>
                     <br>
                     <video  controls hidden></video>
                     <br>
                     <button class="btn btn-success btn-block rad"  style="width: 286px;" onclick="check(uls[counter],uls.length)">Start</button>
                 </center>
                </div>
            </div>
        </div>';

}

Function Fetch($lat,$lon,$rad){
    $snaps="<script> var uls=[";
    $request=curl_init();
    curl_setopt($request,CURLOPT_URL,'https://ms.sc-jpl.com/web/getPlaylist');
    curl_setopt($request,CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($request,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($request,CURLOPT_HEADER,0);
    curl_setopt($request,CURLOPT_HTTPHEADER,array('Content-Type:application/json','Accept: application/json'));
    curl_setopt($request,CURLOPT_POST,1);
    curl_setopt($request,CURLOPT_POSTFIELDS,'{"requestGeoPoint":{"lat":'.$lat.',"lon":'.$lon.'},"tileSetId":{"flavor":"default","epoch":'.Epoch().',"type":1},"radiusMeters":'.$rad.'}');
    curl_setopt($request,CURLOPT_RETURNTRANSFER,1);
    $response=curl_exec($request);
    
    $response=json_decode($response,1);
    $total=sizeof($response['manifest']['elements']);
    for($i=0;$i<$total;$i++)
    {// Start Loop
        if(sizeof($response['manifest']['elements'][$i]['snapInfo']['streamingThumbnailInfo']['infos'])>1)
        {//IF
            
            $snaps.='"'.str_replace('/thumb/thumb.mp4','/media.mp4',$response['manifest']['elements'][$i]['snapInfo']['streamingThumbnailInfo']['infos'][1]['thumbnailUrl']).'",';
            

        }//End IF
        else
        {//else
            $snaps.='"'.$response['manifest']['elements'][$i]['snapInfo']['streamingThumbnailInfo']['infos'][0]['thumbnailUrl'].'",';

        }//End 
    }// End Loop
    $snaps[-1]=']';
    $snaps_time[-1]=']';
    $snaps.='</script>';
    return $snaps;

}
function Epoch(){
    $request=curl_init();
    curl_setopt($request,CURLOPT_URL,'https://ms.sc-jpl.com/web/getLatestTileSet');
    curl_setopt($request,CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($request,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($request,CURLOPT_HEADER,0);
    curl_setopt($request,CURLOPT_HTTPHEADER,array('Content-Type:application/json','Accept: application/json'));
    curl_setopt($request,CURLOPT_POST,1);
    curl_setopt($request,CURLOPT_POSTFIELDS,'{}');
    curl_setopt($request,CURLOPT_RETURNTRANSFER,1);
    $response=curl_exec($request);
    $response=json_decode($response,1);
    curl_close($request);
    return $response['tileSetInfos'][1]['id']['epoch'];
}
?>
 

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"  integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>