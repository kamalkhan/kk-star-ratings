<div class="bhittani-framework">
    <?php if(isset($sidebar)) : ?>
	<div class="bf-wrap-small _right">
        <!-- Place this tag where you want the button to render. -->
        <a class="github-button" href="https://github.com/kamalkhan/kk-star-ratings" data-icon="octicon-star" data-style="mega" data-count-href="/kamalkhan/kk-star-ratings/stargazers" data-count-api="/repos/kamalkhan/kk-star-ratings#stargazers_count" data-count-aria-label="# stargazers on GitHub" aria-label="Star kamalkhan/kk-star-ratings on GitHub">
            kk Star Ratings
        </a>
        <br><br>
        <!-- Place this tag right after the last button or just before your close body tag. -->
        <script async defer id="github-bjs" src="https://buttons.github.io/buttons.js"></script>

        <a href="http://bit.ly/awesome-live-chat" title="Awesome Live Chat" target="_blank">
            <img alt="Awesome Live Chat - CodeCanyon Item for Sale" border="0" class="landscape-image-magnifier preload no_preview" data-google-analytics-payload="{&quot;id&quot;:9931156,&quot;name&quot;:&quot;Awesome Live Chat&quot;,&quot;brand&quot;:&quot;KamalKhan&quot;,&quot;category&quot;:&quot;codecanyon.net/category/wordpress&quot;,&quot;position&quot;:5,&quot;list&quot;:&quot;Author portfolio&quot;}" data-item-author="KamalKhan" data-item-category="WordPress" data-item-cost="25" data-item-id="9931156" data-item-name="Awesome Live Chat" data-preview-height="" data-preview-url="https://previews-codecanyon.imgix.net/files/248803484/jumbotron.jpg?auto=compress%2Cformat&fit=crop&crop=top&max-h=8000&max-w=590&s=9c2351b764d8c9a4f65796908b480b35" data-preview-width="" height="80" src="https://s3.envato.com/files/248803483/thumbnail.jpg" title="" width="80" data-tooltip="Awesome Live Chat">
        </a>
    </div>
    <!-- bf-wrap-small -->
    <?php endif; ?>
	<div class="bf-wrap">
    <div class="bf_head">
        <ul class="bf_navs _right">
            <li<?php echo ($opt=='general')?' class="active"':''; ?>><a href="#Settings">Settings</a></li>
            <li<?php echo ($opt=='stars')?' class="active"':''; ?>><a href="#Stars">Stars</a></li>
            <li<?php echo ($opt=='tooltips')?' class="active"':''; ?>><a href="#Tooltips">Tooltips</a></li>
            <li<?php echo ($opt=='reset')?' class="active"':''; ?>><a href="#Reset">Reset</a></li>
            <li<?php echo ($opt=='info')?' class="active"':''; ?>><a href="#Help">Help</a></li>
            <li class="bf-save"><a href="#" rel="save-options">Save</a></li>
        </ul>
        <!--bf_navs-->
        <div class="bf_logo">
            <h3>
            	<?php echo $h3; ?>
            </h3>
            <div class="links">
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like" data-href="https://github.com/kamalkhan/kk-star-ratings" data-width="167" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                <?php
					if(isset($Url) && is_array($Url))
					{
						$url_sep = '';
						foreach($Url as $url)
						{
							echo $url_sep . '<a href="'.$url['link'].'" target="_blank">' . $url['title'] . '</a>';
							$url_sep = ' | ';
						}
					}
				?>
            </div>
        </div>
        <!--bf_logo-->
    </div>
    <!--bf_head-->
    <form method="post" action="" name="bf_form">
    <div class="bf_container __settings <?php echo ($opt=='general')?'__active':''; ?>">
        <?php

            BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Enable/Disable',
				'description' => 'Choose whether you want to enable or disable the plugin',
				'obj' => array(
					array(
						'field' => 'kksr_enable',
						'label' => 'Enable',
						'value' => get_option('kksr_enable')
				    )
				)
			));
			BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Placement',
				'description' => 'Choose where you want the ratings to be placed',
				'obj' => array(
					array(
						'field' => 'kksr_show_in_home',
					    'label' => 'Show on Home Page',
					    'value' => get_option('kksr_show_in_home')
				    ),
				    array(
						'field' => 'kksr_show_in_archives',
					    'label' => 'Show in Archives',
					    'value' => get_option('kksr_show_in_archives')
				    ),
				    array(
						'field' => 'kksr_show_in_posts',
					    'label' => 'Show in Posts',
					    'value' => get_option('kksr_show_in_posts')
				    ),
				    array(
						'field' => 'kksr_show_in_pages',
					    'label' => 'Show in Pages',
					    'value' => get_option('kksr_show_in_pages')
				    ),
					array(
						'field' => 'kksr_disable_in_archives',
					    'label' => 'Disable voting in archives',
					    'value' => get_option('kksr_disable_in_archives')
				    )
				)
			));
			BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Exclude following category(s)',
				'description' => 'Comma seperated ids of categories.<br />e.g. <em>5,47,2</em>',
				'field' => 'kksr_exclude_categories',
				'value' => get_option('kksr_exclude_categories')
			));
			BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Google Rich Snippets',
				'description' => 'Do you want Google to index the ratings and hopefully show it in the search results',
				'obj' => array(
					array(
						'field' => 'kksr_grs',
					    'label' => 'Enable',
					    'value' => get_option('kksr_grs')
				    )
			    )
		    ));
			BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Unique voting',
				'description' => 'Choose whether you want unique votings based on IP or not',
				'obj' => array(
					array(
						'field' => 'kksr_unique',
					    'label' => 'Unique based on User IP',
					    'value' => get_option('kksr_unique')
				    )
			    )
		    ));
		    BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Clear line',
				'description' => 'Choose whether you want the ratings to be on its own line rather than floated',
				'obj' => array(
					array(
						'field' => 'kksr_clear',
					    'label' => 'Clear',
					    'value' => get_option('kksr_clear')
				    )
			    )
		    ));
		    BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Admin screen column',
				'description' => 'Choose whether you want a ratings column in the admin post/page screen',
				'obj' => array(
					array(
						'field' => 'kksr_column',
					    'label' => 'Admin Posts/Pages Column',
					    'value' => get_option('kksr_column')
				    )
			    )
		    ));
		    BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Legend',
				'description' => '
									How do you want the legend of the ratings to be shown? <br />
									<strong>Variables</strong> <br />
                                    <code>[best]</code>=max stars <br />
									<code>[total]</code>=total ratings <br />
									<code>[avg]</code>=average <br />
									<code>[per]</code>=percentage <br />
									<code>[s]</code>=for plural vs singular of votes occurred <br />
									<strong>NOTE</strong> <br />
									<code>[total]</code> and <code>[avg]</code> is mandatory for Google Rich Snippets to work
								',
				'field' => 'kksr_legend',
				'value' => get_option('kksr_legend')
			));
		    BhittaniPlugin_AdminMarkup::select(array(
				'title' => 'Position',
				'description' => 'Choose the position of the ratings',
				'field' => 'kksr_position',
				'options' => array(
				    array('top-left','Top Left'),
					array('top-right','Top Right'),
					array('bottom-left','Bottom Left'),
					array('bottom-right','Bottom Right'),
				),
				'value' => get_option('kksr_position')
			));
			BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Speed of fueling (in milliseconds)',
				'description' => 'Adjust the speed of the fueling of stars in milliseconds',
				'field' => 'kksr_js_fuelspeed',
				'value' => get_option('kksr_js_fuelspeed')
			));
			BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Initial text',
				'description' => 'Text to be displayed when there are no ratings',
				'field' => 'kksr_init_msg',
				'value' => get_option('kksr_init_msg')
			));
			BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Thank you message',
				'description' => 'Text to be displayed when user places a vote',
				'field' => 'kksr_js_thankyou',
				'value' => get_option('kksr_js_thankyou')
			));
			BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Error message',
				'description' => 'Text to be displayed when something goes wrong unexpectidly',
				'field' => 'kksr_js_error',
				'value' => get_option('kksr_js_error')
			));
	    ?>
    </div>
    <!--bf_container __general-->
    <div class="bf_container __stars <?php echo ($opt=='stars')?'__active':''; ?>">
        <?php
        	BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Amount of stars',
				'description' => 'How many stars do you want the ratings based on? Enter a numeric value',
				'field' => 'kksr_stars',
				'value' => get_option('kksr_stars')
			));
        	BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Width of single star',
				'description' => 'Set the width of a single star in pixels(px).<br /><strong>Note: </strong>All stars must be of equal width',
				'field' => 'kksr_stars_w',
				'value' => get_option('kksr_stars_w')
			));
			BhittaniPlugin_AdminMarkup::input(array(
				'title' => 'Height of single star',
				'description' => 'Set the height of a single star in pixels(px).<br /><strong>Note: </strong>All stars must be of equal height',
				'field' => 'kksr_stars_h',
				'value' => get_option('kksr_stars_h')
			));
		    BhittaniPlugin_AdminMarkup::image(array(
				'title' => 'Gray Star',
				'description' => 'You can modify the gray star image here',
				'field' => 'kksr_stars_gray',
				'label' => 'Choose an image',
				'caption' => 'Gray Star',
				'value' => get_option('kksr_stars_gray') ? get_option('kksr_stars_gray') : BhittaniPlugin_kkStarRatings::file_uri('gray.png')
			));
			BhittaniPlugin_AdminMarkup::image(array(
				'title' => 'Yellow Star',
				'description' => 'You can modify the yellow star image here',
				'field' => 'kksr_stars_yellow',
				'label' => 'Choose an image',
				'caption' => 'Yellow Star',
				'value' => get_option('kksr_stars_yellow') ? get_option('kksr_stars_yellow') : BhittaniPlugin_kkStarRatings::file_uri('yellow.png')
			));
			BhittaniPlugin_AdminMarkup::image(array(
				'title' => 'Orange Star',
				'description' => 'You can modify the orange star image here',
				'field' => 'kksr_stars_orange',
				'label' => 'Choose an image',
				'caption' => 'Orange Star',
				'value' => get_option('kksr_stars_orange') ? get_option('kksr_stars_orange') : BhittaniPlugin_kkStarRatings::file_uri('orange.png')
			));
	    ?>
    </div>
    <!--bf_container __stars-->
    <div class="bf_container __tooltips <?php echo ($opt=='tooltips')?'__active':''; ?>">
        <?php
	        BhittaniPlugin_AdminMarkup::checkbox(array(
				'title' => 'Tooltips',
				'description' => 'Choose whether you want to enable or disable the tooltips',
				'obj' => array(
					array(
						'field' => 'kksr_tooltip',
						'label' => 'Enable Tooltips',
						'value' => get_option('kksr_tooltip')
				    )
				)
			));
			$Tooltips = get_option('kksr_tooltips');
			for($tooltip_i=0;$tooltip_i<get_option('kksr_stars');$tooltip_i++)
			{
				BhittaniPlugin_AdminMarkup::input(array(
					'title' => 'Tooltip - star '.($tooltip_i+1),
					'description' => 'Displayed when mouse is hovered over star '.($tooltip_i+1),
					'field' => 'kksr_tooltips['.($tooltip_i).'][tip]',
					'value' => isset($Tooltips[$tooltip_i]['tip']) ? $Tooltips[$tooltip_i]['tip'] : ''
				));
				BhittaniPlugin_AdminMarkup::color(array(
					'title' => 'Tooltip Color - star '.($tooltip_i+1),
					'description' => 'Color for tooltip of star '.($tooltip_i+1),
					'field' => 'kksr_tooltips['.($tooltip_i).'][color]',
					'label' => 'Choose a color',
					'value' => isset($Tooltips[$tooltip_i]['color']) ? $Tooltips[$tooltip_i]['color'] : '#ffffff'
				));
			}
	    ?>
    </div>
    <!--bf_container __tooltips-->
    <div class="bf_container __reset <?php echo ($opt=='reset')?'__active':''; ?>">
        <?php
		    global $wpdb;
			$table = $wpdb->prefix . 'postmeta';
			$Posts = $wpdb->get_results("SELECT a.ID, a.post_title
										 FROM " . $wpdb->posts . " a, $table b
										 WHERE a.ID=b.post_id AND
										 b.meta_key='_kksr_ratings'
										 ORDER BY a.ID ASC");
			if(is_array($Posts))
			{
				$Obj = array();
				foreach($Posts as $post)
				{
					$Obj[] = array(
						'field' => 'kksr_reset['.$post->ID.']',
						'label' => $post->post_title,
						'class' => '_kksr_reset'
				    );
				}
				if(count($Obj))
				{
					BhittaniPlugin_AdminMarkup::html('<p>Select the posts/pages below
												and click the reset button to reset
												their ratings.</p>
												<p>
												<a href="#" rel="kksr-reset-all" class="button">Select All</a>
												<a href="#" rel="kksr-reset-none" class="button">Select None</a>
												<a href="#" rel="kksr-reset" class="button-primary" style="color:white;">Reset</a>
												</p>'
												);
					BhittaniPlugin_AdminMarkup::checkbox(array(
						'title' => '',
						'description' => '',
						'pclass' => '_left',
						'obj' => $Obj
					));
				}
				else
				{
					BhittaniPlugin_AdminMarkup::html('No ratings have been placed.');
				}
			}
			else
			{
				BhittaniPlugin_AdminMarkup::html('No ratings have been placed.');
			}
	    ?>
    </div>
    <!--bf_container __reset-->
    <div class="bf_container __help <?php echo ($opt=='info')?'__active':''; ?>">
    	<?php
    		BhittaniPlugin_AdminMarkup::html(
    			'<p>
				    <strong>To manually use in your post/page using admin screen, use the star icon in your post/page editor</strong>
                    <br /><br />
                    <strong>For use in theme files:</strong>
                    <br /> <code class="_block">&lt;?php if(function_exists("kk_star_ratings")) : echo kk_star_ratings($pid); endif; ?&gt;</code>
                    <br />Where $pid is the id of the post
					<br /><br />
                    <strong>Get top rated posts as array of objects:</strong>
                    <br /> <code class="_block">&lt;?php <br />   if(function_exists("kk_star_ratings_get")) <br />   { <br />      $top_rated_posts  = kk_star_ratings_get($total); <br />   } <br />?&gt;</code>
                    <br />Where $total is the limit (int)
					<br />$top_rated_posts will contain an array of objects, each containing an ID and ratings.
                    <br />
                    Example Usage:
                    <code class="_block">
<pre>
foreach($top_rated_posts as $post)
{
 // you get $post->ID and $post->ratings
 // Do anything with it like get_post($post->ID)
 // ...
}
</pre>
                    </code>
                    <strong>Action Hooks</strong>
					<br />
					When post rating is fetched initially.
                    <code class="_block">
<pre>
add_action("kksr_init", "my_super_function1", 10, 3);
</pre>
                    </code>
					example usage:
					<code class="_block">
<pre>
function my_super_function1($post_id, $avg, $votes);
{
 // $post_id is the id of the post.
 // $avg is the average ratings as a string (e.g. 4.3/5).
 // $votes is the total amount of votes occured.

 // Do your magic below
}
</pre>
                    </code>
					When a post gets rated
                    <code class="_block">
<pre>
add_action("kksr_rate", "my_super_function2", 10, 3);
</pre>
                    </code>
					example usage:
					<code class="_block">
<pre>
function my_super_function2($post_id, $no_of_stars, $ip_address);
{
 // $post_id is the id of the post.
 // $no_of_stars is the amount of stars the user rated.
 // $ip_address is the ip address of the user.

 // Do your magic below
}
</pre>
                    </code>
				 </p>'
    		);
    	?>
    </div>
    <!--bf_container __help-->
	</form>
    </div>
    <!-- bf-wrap -->
</div>
<!--bhittani-framework-->
