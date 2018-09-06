<?php
/*
Template Name: Article
*/
include 'constant.php';
if((isset($_GET['article'])) && (!isset($_GET['section']))){
  $getArticle = $_GET['article'];
  $q = str_replace("-"," ",$getArticle);

  require_once 'HTTP/Request2.php';

  $request = new Http_Request2('https://api.nhs.uk/conditions/'.$getArticle);
    $request->setConfig(array(
    'ssl_verify_peer'        => FALSE,
    'ssl_verify_host'        => FALSE,

));
  $url = $request->getUrl();

  $headers = array(
      // Request headers
      'subscription-key' =>  NHS_API_KEY,
  );

  $request->setHeader($headers);

  $parameters = array(
    'condition'=>$getArticle
  );

  $url->setQueryVariables($parameters);

  $request->setMethod(HTTP_Request2::METHOD_GET);

  // Request body
  $request->setBody("{body}");
$sidebar = '<ul>';
$result =' ';
  try
  {
      $response = $request->send();
      $jsonResponse =  $response->getBody();
      $data = json_decode($jsonResponse);
      if((isset($data))&&(!empty($data))) {

      foreach( $data->mainEntityOfPage as $headingtext){
          $sidebar1 = $headingtext->text;
          foreach($headingtext->mainEntityOfPage as $maintext){
             $id =   clean($sidebar1); //str_replace(" ", "-",$sidebar1 );
             if(!empty($headingtext->text)){
                $result .= '<section id="'.$id.'">'. $maintext->text ."</section>";
             }
          }
      }

     foreach( $data->mainEntityOfPage as $related){
           $id =  clean($related->text); //str_replace(" ", "-", $related->text);
           if(!empty($related->text)){
             $sidebar .= '<li><a class="relatedlink" href="#'.$id.'" >'.$related->text ."</a></li>";
           }
      }
      $sidebar .= '</ul>';
      $i=0;
    /*  foreach ($data->mainEntityOfPage as $key => $value) {
        $q = remove_trailing_slashes(str_replace("/conditions/".$getArticle,"",$value->text));
        $redirectUrl =ARTICLE_URL.'?article='.$getArticle;
        if($i==0){
              $sidebar .= "<a class='' href='".$redirectUrl."'>Introduction</a></br>";
        }else{
            $url = $redirectUrl.'&section='.$q;
            $sidebar .= "<a class='' href='".$url."' >".$value->name ."</a></br>";
        }
          $i++;
      } */
    }
  }
  catch (HttpException $ex)
  {
      echo $ex;
  }

}
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
if((isset($_GET['article'])) && (isset($_GET['section']))){
    $condition = $_GET['article'];
    $subPage =  $_GET['section'];

    require_once 'HTTP/Request2.php';

    $request = new Http_Request2('https://api.nhs.uk/conditions/'.$condition.'/'.$subPage);
      $request->setConfig(array(
    'ssl_verify_peer'        => FALSE,
    'ssl_verify_host'        => FALSE,

));
    $url = $request->getUrl();

    $headers = array(
        // Request headers
        'subscription-key' =>  NHS_API_KEY ,
    );

    $request->setHeader($headers);

    $parameters = array(
      'condition'=>$condition,
      'subPage'=>$subPage
    );

    $url->setQueryVariables($parameters);

    $request->setMethod(HTTP_Request2::METHOD_GET);

    // Request body
    $request->setBody("{body}");

    try
    {
        $response = $request->send();
        $jsonResponse = $response->getBody();
        $data = json_decode($jsonResponse);
        $result = $data->mainEntityOfPage[0]->text;
        // echo '<div id="result">' . $result . '</div>';
        $relatedLink = $data->relatedLink;
        $i=0;
        $sidebar = '';
        foreach ($relatedLink as $key => $value) {
          $q = remove_trailing_slashes(str_replace("/conditions/".$condition,"",$value->url));
            $redirectUrl =ARTICLE_URL.'?article='.$condition;
            if($i==0){
                $sidebar .= "<a class='' href='".$redirectUrl."'  >Introduction</a></br>";
            }else{
                $url = $redirectUrl.'&section='.$q;
                $sidebar .= "<a class='' href='".$url."'  >".$value->name ."</a></br>";
            }
            $i++;
        }
    }
    catch (HttpException $ex)
    {
        echo $ex;
    }

}
function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}
function remove_trailing_slashes( $url )
{
     $newUrl =  rtrim($url, '/');
     return ltrim($newUrl, '/');
}
get_header();
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script>
         $(document).ready(function(){
    $('.relatedlink').click(function(){
       
        $('.relatedlink').removeClass('active');
        $(this).addClass('active');
    });
});
     </script>
        <style>
            a {
    color: #007bff;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
    
}


.custom-top{
    float:left;
    padding:3px;
    margin-top:40px;
    margin-bottom:10px;
}
.custom-top a:hover {
    color:#39005E;
}
 .custom-top img {
     margin-right:5px;
      float:right;
 }
/*  SECTIONS  */
.sections {
	clear: both;
	padding: 0px;
	margin: 40px;
}

/*  COLUMN SETUP  */
.col {
	display: block;
	float:left;
	margin: 1% 0 1% 1.6%;
}
.col:first-child { margin-left: 0; }

/*  GROUPING  */
.group:before,
.group:after { content:""; display:table; }
.group:after { clear:both;}
.group { zoom:1; /* For IE 6/7 */ }
/*  GRID OF TWO  */
.span_2_of_2 {
	width: 100%;
}
.span_1_of_2 {
	width: 49.2%;
 
}
.related_1_of_2 {
    width: 22%;


}
.static_area{
     position: relative;
} 
.fixed {
   /* position: fixed;
    top: 0;*/
}
.content_1_of_2{
    width: 75%;
}

/*  GO FULL WIDTH AT LESS THAN 480 PIXELS */

@media only screen and (max-width: 480px) {
	.col {
		margin: 1% 0 1% 0%;
	}
}

@media only screen and (max-width: 480px) {
/*	.span_2_of_2, .span_1_of_2 { width: 100%; }*/
	.span_1_of_2, .related_1_of_2{ width: 100%; }
	#left{position:relative !important;}
	#right{float:left !important;}
}


#wrapper1 {
 /*  width: 500px*/
  height:auto;
  position:relative;
}
#sidebar {
   width: 150px;
 
 }
#left {
   
  position:absolute;
 /*  width: 150px;*/
  height:100%;
}

#right {
  position: relative;
/*  height:600px; */
}
.active{
    color: #4C92D9 !important;
    text-decoration: underline;
}

 /*.border{
     border: 1px solid #000000;
     padding:25px;
 } */
.clear {
  clear: both
}

        </style>
        <script>
            
              $(document).ready(function(){
            $('#result a').addClass('datalink');
              $('.datalink').attr('href', function() {
                var l = window.location;
                var base_url = l.protocol + "//" + l.host + "/";
                var href=  this.href;
                var res = href.replace(base_url,"https://www.nhs.uk/");//+this.href, this.href);
                return res;
              });
               $(".datalink").attr("target","_blank"); 
               
          });
        </script>
    <!--================Static Area =================-->
        <section class="static_area">
            <div class="container">
                <div class="static_inner" id="wrapper1">
                <!--  <div class="section group" >
                         <div class=" col span_1_of_2 custom-top">
                          <h4><a href="<?php echo get_site_url();?>/health-atoz/">  Back to List  </a></h4>
                          </div>
                        <div class=" col span_1_of_2 custom-top">
                            <img src="https://www.doorsteppharmacy.com/wp-content/uploads/2018/02/choices-logo.jpg" title="NHS Logo" alt="NHS Logo" />
                        </div>
                      </div>
                      <div class="clear"></div> -->
                    <div class="section1 group1">
                      <div class="col related_1_of_2 " >
                          <div class="right_sidebar_area "id="left" >
                              <div id="sidebar"  >
                                <h4><a href="<?php echo get_site_url();?>/health-atoz/">  Back to List  </a></h4>  
                               <aside class="right_widget r_cat_widget related" >
                                  <div class="r_w_title">
                                      <h3>Page contents</h3>
                                  </div>

                                  <?php echo $sidebar ; ?>
                              </aside>
                              </div>
                        </div>
                      </div> 
                      
                         <div class="col content_1_of_2"  id="right">
                             <div style="float:right">  <img src="https://www.doorsteppharmacy.com/wp-content/uploads/2018/02/choices-logo.jpg" title="NHS Logo" alt="NHS Logo" /> </div>
                            <div class="static_main_content">

                                <div class="static_text2" id="result">
                                    <?php echo $result; ?>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Static Area =================-->
<?php
get_footer();
?>
<script>

if ($(window).width() > 768) {var length = $('#left').height() - $('#sidebar').height() + $('#left').offset().top;

    $(window).scroll(function () {

        var scroll = $(this).scrollTop();
        var height = $('#sidebar').height() + 'px';

        if (scroll < $('#left').offset().top) {

            $('#sidebar').css({
                'position': 'absolute',
                'top': '0'
            });

        } else if (scroll > length) {

            $('#sidebar').css({
                'position': 'absolute',
                'bottom': '0',
                'top': 'auto'
            });

        } else {

            $('#sidebar').css({
                'position': 'fixed',
                'top': '0',
                'height': height
            });
        }
    });

}
// Fix sidebar ends 

// Jquery scroll starts
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
   
    if ( location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')&&location.hostname == this.hostname) {
      // Figure out element to scroll to
      var target = $(this.hash);
      var id = this.hash;
      //$('#result section').removeClass('border');
      //$(id).addClass('border');
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
     
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });    
// Jquery sidebar scroll ends


</script>
