<?php

    $settings['css_url'] = "css";
    $settings['images_url'] = "images";
    $settings['javascript_url'] = "js";
    $settings['logo_image'] = 'logo.png';
    $settings['title'] = 'Pre-Order Lodestar!';
    $settings['title-link'] = "../";

    $stats['backer_count'] = 0;
    
    $item['game']['image'] = 'item-game.png';
    $item['game']['header'] = '1x Copy of Lodestar';
    $item['game']['subheader'] = 'Estimated Release: TBA';
    $item['game']['title'] = 'Get the final, complete, polished version of Lodestar!';
    
    $item['beta']['image'] = 'item-beta.png';
    $item['beta']['header'] = 'Lodestar Beta Invite';
    $item['beta']['subheader'] = 'Estimated Release: TBA';
    $item['beta']['title'] = 'Be one of the first to play the beta!';
    
    $item['soundtrack']['image'] = 'item-soundtrack.png';
    $item['soundtrack']['header'] = 'Lodestar Soundtrack';
    $item['soundtrack']['subheader'] = 'Estimated Release: TBA';
    $item['soundtrack']['title'] = 'Get the Lodestar soundtrack in a popular DRM free format!';
    
    $item['name']['image'] = 'item-name.png';
    $item['name']['header'] = 'Your Name for Units';
    $item['name']['subheader'] = 'Added to name generator';
    $item['name']['title'] = 'We\'ll add your name to our random unit name generator!';
    
    $item['credits']['image'] = 'item-credits.png';
    $item['credits']['header'] = 'Your Name in the Credits';
    $item['credits']['subheader'] = 'Under "{:tier_title}"';
    $item['credits']['title'] = 'Get your name listed in the Lodestar credits!';
    
    /*
     * Forum Badges
     */
    $item['forum_badge'][1]['image'] = 'item-badge.png';
    $item['forum_badge'][1]['header'] = 'Tier One Forum Badge';
    $item['forum_badge'][1]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][1]['title'] = 'Get a tier one forum badge!';
    
    $item['forum_badge'][2]['image'] = 'item-badge.png';
    $item['forum_badge'][2]['header'] = 'Tier Two Forum Badge';
    $item['forum_badge'][2]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][2]['title'] = 'Get a tier two forum badge!';
    
    $item['forum_badge'][3]['image'] = 'item-badge.png';
    $item['forum_badge'][3]['header'] = 'Tier Three Forum Badge';
    $item['forum_badge'][3]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][3]['title'] = 'Get a tier three forum badge!';
    
    $item['forum_badge'][4]['image'] = 'item-badge.png';
    $item['forum_badge'][4]['header'] = 'Tier Four Forum Badge';
    $item['forum_badge'][4]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][4]['title'] = 'Get a tier four forum badge!';
    
    $item['forum_badge'][5]['image'] = 'item-badge.png';
    $item['forum_badge'][5]['header'] = 'Tier Five Forum Badge';
    $item['forum_badge'][5]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][5]['title'] = 'Get a tier five forum badge!';
    
    $item['forum_badge'][6]['image'] = 'item-badge.png';
    $item['forum_badge'][6]['header'] = 'Tier Six Forum Badge';
    $item['forum_badge'][6]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][6]['title'] = 'Get a tier six forum badge!';
    
    $item['forum_badge'][7]['image'] = 'item-badge.png';
    $item['forum_badge'][7]['header'] = 'Tier Seven Forum Badge';
    $item['forum_badge'][7]['subheader'] = 'Available: NOW!';
    $item['forum_badge'][7]['title'] = 'Get a tier seven forum badge!';
    
    $tier = array(
      array(
        'title' => 'Initiate Tier',
        'price' => '$15.00',
        'title_image' => 'tier-1-title.png',
        'price_image' => 'tier-1-price.png',
        'buy_link' => 'tier/initiate/',
        'counter' => 0,
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          )
        )
      ),
      array(
        'title' => 'Themite Tier',
        'price' => '$20.00',
        'title_image' => 'tier-2-title.png',
        'price_image' => 'tier-2-price.png',
        'buy_link' => 'tier/themite/',
        'counter' => 0,
        'row' => array(
          array(
            $item['game'],
            $item['beta']
          ),
          array(
            $item['soundtrack'],
            $item['forum_badge'][1]
          )
        )
      ),
      array(
        'title' => 'Astraean Tier',
        'price' => '$45.00',
        'title_image' => 'tier-3-title.png',
        'price_image' => 'tier-3-price.png',
        'buy_link' => 'tier/astraean/',
        'counter' => 0,
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          ),
          array(
            $item['forum_badge'][2],
            $item['name']
          )
        )
      ),
      array(
        'title' => 'Hyperion Tier',
        'price' => '$75.00',
        'title_image' => 'tier-4-title.png',
        'price_image' => 'tier-4-price.png',
        'buy_link' => 'tier/hyperion/',
        'counter' => 0,
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          ),
          array(
            $item['forum_badge'][3],
            $item['name'],
            $item['credits']
          )
        )
      ),
      array(
        'title' => 'Del\'fos Tier',
        'subtitle' => 'Design an Achievement to Challenge Players!',
        'price' => '$500.00',
        'title_image' => 'tier-5-title.png',
        'price_image' => 'tier-5-price.png',
        'buy_link' => 'tier/delfos/',
        'counter_limited' => 0,
        'counter_limit' => 30,
        'infobox' => array(
          'image' => 'tier-5-infobox.png',
          'text' => 'Submit your achievement idea and we\'ll add it to Lodestar\'s list of player collectible challenge awards!'
        ),
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          ),
          array(
            $item['forum_badge'][4],
            $item['name'],
            $item['credits']
          )
        )
      ),
      array(
        'title' => 'Del\'fi Tier',
        'subtitle' => 'Create a Legendary Weapon for Players to Find!',
        'price' => '$1000.00',
        'title_image' => 'tier-6-title.png',
        'price_image' => 'tier-6-price.png',
        'buy_link' => 'tier/delfi/',
        'counter_limited' => 0,
        'counter_limit' => 30,
        'infobox' => array(
          'image' => 'tier-6-infobox.png',
          'text' => 'Design a unique, legendary weapon for Lodestar! Submit your idea and we\'ll turn it into a usable weapon in the game!'
        ),
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          ),
          array(
            $item['forum_badge'][5],
            $item['name'],
            $item['credits']
          )
        )
      ),
      array(
        'title' => 'Ef\'kos Nan Tier',
        'subtitle' => 'Create Your Own Enemy Unit!',
        'price' => '$2000.00',
        'title_image' => 'tier-7-title.png',
        'price_image' => 'tier-7-price.png',
        'buy_link' => 'tier/efkosnan/',
        'counter_limited' => 0,
        'counter_limit' => 30,
        'infobox' => array(
          'image' => 'tier-7-infobox.png',
          'text' => 'Design an enemy unit for Lodestar! Submit your idea and we\'ll turn it into an enemy unit in the game!'
        ),
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          ),
          array(
            $item['forum_badge'][6],
            $item['name'],
            $item['credits']
          )
        )
      ),
      array(
        'title' => 'The Chosen Tier',
        'subtitle' => 'Become a part of Lodestar Lore!',
        'price' => '$5000.00',
        'title_image' => 'tier-8-title.png',
        'price_image' => 'tier-8-price.png',
        'buy_link' => 'tier/thechosen/',
        'counter_limited' => 0,
        'counter_limit' => 5,
        'infobox' => array(
          'image' => 'tier-8-infobox.png',
          'text' => 'Become a part of the Lodestar Universe! You will be immortalized in the lore as an influential character of your choosing!'
        ),
        'row' => array(
          array(
            $item['game'],
            $item['beta'],
            $item['soundtrack']
          ),
          array(
            $item['forum_badge'][7],
            $item['name'],
            $item['credits']
          )
        )
      ),
    );

function function_prep($string, $data)
{
  $string = preg_replace('/{:tier_title}/i', $data['title'], $string);
  return $string;
}
    
// display
echo '<!doctype html>
<html>
<head>
  <title>Lodestar Pre-Order</title>
  <meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\' />
  <link href="http://fonts.googleapis.com/css?family=Six+Caps" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="'.$settings['javascript_url'].'/jquery.scrolling-parallax.js"></script>
  <script src="'.$settings['javascript_url'].'/jquery.mousewheel.js"></script>
  <link href="'.$settings['css_url'].'/tierpage.css" rel="stylesheet" type="text/css">
  <script type="text/javascript">
  $(function () {
    var top = 0,
      step = 128,
      viewport = $(window).height(),
      body = $.browser.webkit ? $(\'body\') : $(\'html\'),
      wheel = false;

    $(\'body\').mousewheel(function(event, delta) {
      wheel = true;
      if (delta < 0) {
        top = (top+viewport) >= $(document).height() ? top : top+=step;
        body.stop().animate({scrollTop: top}, 200, function () {
          wheel = false;
        });
      } else {
        top = top <= 0 ? 0 : top-=step;
        body.stop().animate({scrollTop: top}, 200, function () {
          wheel = false;
        });
      }
      return false;
    });

    $(window).on(\'resize\', function (e) {
      viewport = $(this).height();
    });

    $(window).on(\'scroll\', function (e) {
      if (!wheel)
        top = $(this).scrollTop();
    });

});
    $( window ).scroll(function() {
      var y = -$( window ).scrollTop() / 1.5;
      $(\'#body-wrapper\').css(\'background-position\', \'center \' + y + \'px\');
    });
  </script>
</head>
<body>
<div id="body-wrapper">
';

// logo
if (!empty($settings['logo_image']) && file_exists($settings['images_url'].'/'.$settings['logo_image']))
  echo '
<div id="logo-wrapper">
  <div id="logo-image">
    <h1><a href="'.$settings['title-link'].'"><img src="'.$settings['images_url'].'/'.$settings['logo_image'].'" alt="Lodestar: Stygian Skies" id="main-logo" /></a></h1>
  </div>
</div>  
';

echo '
<div id="tierbox-wrapper">
  <div class="title-infobox">';

// title
if (!empty($settings['title']))
{
  echo '
    <div class="title">
      <h1>'.$settings['title'].'</h1>
    </div>
  ';
}

echo '
    <div class="title-link">
      <a href="'.$settings['title-link'].'">Click here to learn more about our game!</a>
    </div>
';

echo '
    <div class="title-body">
      <p>
      Thanks for your support! Your purchase will be used to directly fund the ongoing development
	  of Lodestar: Stygian Skies. We are currently moving into our closed  alpha phase. When we
	  enter our beta phase, we\'ll email you with the download info and you\'ll have access to the
	  beta, the soundtrack, and of course, the final game at no additional cost!
      </p>
      <p>
      If we get on Steam, we\'ll give you a key for that too!
      </p>
    </div>
';

echo '
  </div>
  ';

// loop through the tiers
$tier_num = 0;
foreach ($tier as $data)
{
  $tier_num++;
  echo '
  <div id="tier-'.$tier_num.'" class="tierbox">
    <!-- '.$data['title'].' Tier -->
    <div class="tierbox-top">';
  if (!empty($data['title_image']) && file_exists($settings['images_url'].'/'.$data['title_image']))
  {
    echo '
      <img class="tierbox-title" src="'.$settings['images_url'].'/'.$data['title_image'].'" alt="'.$data['title'].'" title="'.$data['title'].'" />';
  }
  if (!empty($data['price_image']) && file_exists($settings['images_url'].'/'.$data['price_image']))
  {
    echo '
      <img class="tierbox-price" src="'.$settings['images_url'].'/'.$data['price_image'].'" alt="'.$data['price'].'" title="'.$data['price'].'" />';
  }
  echo '
    </div>
    <div class="tierbox-mid">';
  
  echo '
    <div class="subtitle">
      '.(!empty($data['subtitle']) ? $data['subtitle'] : '').'
    </div>';

  // check for an info box and display it
  if (!empty($data['infobox']))
  {
    echo '
    <div class="infobox">
      <div class="infobox-top"></div>
      <div class="infobox-mid">
    ';
    if (!empty($data['infobox']['image']))
    {
      echo '
        <div class="image">
          <img src="'.$settings['images_url'].'/'.$data['infobox']['image'].'" />
        </div>';
    }
    if (!empty($data['infobox']['text']))
    {
      echo '
        <div class="text">
          '.$data['infobox']['text'].'
        </div>';
    }
    echo '
      <div class="clearfix"></div>
      </div>
      <div class="infobox-bot"></div>
    </div>
    ';
  }
  
  // check for and display counter
  if (!empty($data['counter']))
  {
    echo '
    <div class="counter">
      '.number_format($data['counter']).' Sold
    </div>
    ';
  } 
  elseif (!empty($data['counter_limited']) && !empty($data['counter_limit']))
  {
    echo '
    <div class="counter">
      Sold '.number_format($data['counter_limited']).' out of  '.number_format($data['counter_limit']).'
    </div>
    ';
  }
  
  // loop through the rows
  foreach ($data['row'] as $row)
  {
    $first = true;
    echo '
      <div>
    ';
    // loop through the items in each row
    foreach ($row as $i)
    {
      if (!$first)
      {
        echo '
          <div class="tierbox-plus">
            <img src="'.$settings['images_url'].'/plus.png" />
          </div>
        ';
      }
      echo '
          <div class="tierbox-item"'.(!empty($i['title']) ? ' title="'.$i['title'].'"' : '').' >
            <img src="'.$settings['images_url'].'/'.$i['image'].'" '.(!empty($i['title']) ? ' title="'.$i['title'].'"' : '').' />
            <div class="item-header">'.$i['header'].'</div>
            <div class="item-sub">'.function_prep($i['subheader'], $data).'</div>
          </div>
      ';
      $first = false;
    }
    echo '
      </div>
    ';
  }
  
  echo '
    </div>
    <div class="tierbox-bot">
      <a class="tierbox-buy-button" href="'.$data['buy_link'].'"></a>
    </div>
  </div>
  ';
}

echo '
</div>
</div> <!-- #body-wrapper -->
</body>
</html>
';

?>