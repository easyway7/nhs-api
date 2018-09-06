<?php
/*
Template Name: NHS HOME 1
*/
 
include 'constant.php';

get_header();
$sidebar='';
if(isset($_GET['category'])){
   $category = $_GET["category"];
  echo'<style> #' .$category . ' li { background-color:#39005E;color:#FFF }</style>';
    // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
  require_once 'HTTP/Request2.php';

    $request = new Http_Request2('https://api.nhs.uk/conditions/');
      $request->setConfig(array(
    'ssl_verify_peer'        => FALSE,
    'ssl_verify_host'        => FALSE,
   
));
    $url = $request->getUrl();

    $headers = array(
        // Request headers
        'subscription-key' => 'f7f5e8b0bac147f99d159aeb44c66436',
    );

    $request->setHeader($headers);

    $parameters = array(
        // Request parameters
         'category' => $category,
    );

    $url->setQueryVariables($parameters);

    $request->setMethod(HTTP_Request2::METHOD_GET);

    // Request body
    $request->setBody("body");

    try
    {
         $response = $request->send();
         $result = $response->getBody();
         $data = json_decode($result);
         $sidebar = '';
         $final =array();
         for($x =$category.'A'; $x < $category.'Z'; $x++){
            $key =  strtolower($x) ;
            $d1  =  start($data->significantLink,$key); 
            $includeKey = array();
         
            if(isset($d1)) {
             foreach($d1['data'] as $k => $v){
                 if(!in_array($d1['key'][0],$includeKey)){
                     $sidebar .= '</ul></div><div class="index-section clear"><h1 class="title">'.$d1['key'][0] .'</h1><ul>';
                     array_push($includeKey,$d1['key'][0]);
                 }
                   $sidebar .= $v; 
            }
         }
         
        }
      $sidebar .= '</ul>';
    }
    catch (HttpException $ex)
    {
        echo json_encode($ex);
    }
}
?>
<style>
ul li {list-style: none outside none;}
/*.char ul li{list-style: none outside none;float: left;padding: 10px;font-size: 23px;}*/
.char ul li{list-style: none outside none;float: left; padding:0px; font-size: 24px; font-weight:bold; margin-right:10px; border:1px solid #000000; min-width:50px; text-align:center; min-height:50px;line-height:50px;
margin-top:13px;}
#result{ clear: both;}
.health-heading{margin-top:30px;}
.char{margin-bottom: 50px;}
.static_area{padding-bottom:40px;}
   .index-section {
    border-bottom: 1px solid #e2e2e2;
    padding-bottom: 1em;
     padding-top: 1em;
}
.title{
        text-transform: capitalize;

}
.heading-section{
    margin-top:15px;
}
 <?php
 
 ?>
</style>
  <!--================Static Area =================-->
    
        <section class="static_area">
            <div class="container">
                <div class="static_inner">
                    <h1 class="health-heading"> Health A-Z - Conditions and treatments</h1>
                    <p>Use our website to find up-to-date, quality information on more than 800 conditions and treatments.</p>
                    <p> To find information about a condition or treatment, browse by selecting an index below. </p>
                 <!--   <div class="row">-->
                        <div class="col-lg-12 char">
													<ul>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=A" class="data"  id="A"> <li> A </li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=B" class="data"  id="B"> <li>B</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=C" class="data"  id="C"> <li>C</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=D" class="data"  id="D"> <li>D</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=E" class="data"  id="E"> <li>E</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=F" class="data"  id="F"> <li>F</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=G" class="data"  id="G"> <li>G</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=H" class="data"  id="H"> <li>H</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=I" class="data"  id="I"> <li>I</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=J" class="data"  id="J"> <li>J</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=K" class="data"  id="K"> <li>K</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=L" class="data"  id="L"> <li>L</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=M" class="data"  id="M"> <li>M</li> </a>
 							 			        <a href="<?php echo get_site_url();?>/health-atoz?category=N" class="data"  id="N"> <li>N</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=O" class="data"  id="O"> <li>O</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=P" class="data"  id="P"> <li> P </li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=Q" class="data"  id="Q"> <li>Q</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=R" class="data"  id="R"> <li>R</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=S" class="data"  id="S"> <li>S</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=T" class="data"  id="T"> <li>T</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=U" class="data"  id="U"> <li>U</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/atoz?category=V" class="data"  id="V"> <li>V</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=Y" class="data"  id="W"> <li>W</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=X" class="data"  id="X"> <li>X</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=Y" class="data"  id="Y"> <li>Y</li> </a>
 							 				    <a href="<?php echo get_site_url();?>/health-atoz?category=Z" class="data"  id="Z"> <li>Z</li> </a>
 							 					</ul>

                        </div>
                        <div class="clear"> </div>
                        <div class="col-lg-12"> 
                            <?php if(!empty($sidebar)){
                                 echo '<div class="heading-section"><h2>Conditions and treatments starting with ' . strtoupper($category). '</h2>';
                                 echo '<p> Please select a condition or treatment from the list below for further information </p></div>';
                                     echo $sidebar;
                            }
                             ?>
                        </div>
                    <!--</div> -->
                </div>
            </div>
        </section>
        <!--================End Static Area =================-->
<?php
function start($arr_main_array,$k){
    $arr_result = array();
    $final = array();
          foreach($arr_main_array as $key => $value){
         if((substr(strtolower($value->name), 0, 2) === $k) ){
              $url = $value->url;
              $name = $value->name;
              $q = str_replace("https://api.nhs.uk/conditions/","",$url);
              $baseUrl = ARTICLE_URL .'?article='.$q;
             $arr_result[] = "<li><a href='".$baseUrl."'>".$name."</a></li>";
             if (!in_array($k, $final)){
                 $final[] = $k;
             }
             //array_push($final,$k);
        }
     }
    
    if(sizeof($arr_result) > 0){
        return array('data'=>$arr_result,'key'=>$final);
   }
   
}
get_footer();
?>
