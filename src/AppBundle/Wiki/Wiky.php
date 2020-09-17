<?php
namespace AppBundle\Wiki;
/* Wiky.php - A tiny PHP "library" to convert Wiki Markup language to HTML
 * Author: Toni Lähdekorpi <toni@lygon.net>
 *
 * Code usage under any of these licenses:
 * Apache License 2.0, http://www.apache.org/licenses/LICENSE-2.0
 * Mozilla Public License 1.1, http://www.mozilla.org/MPL/1.1/
 * GNU Lesser General Public License 3.0, http://www.gnu.org/licenses/lgpl-3.0.html
 * GNU General Public License 2.0, http://www.gnu.org/licenses/gpl-2.0.html
 * Creative Commons Attribution 3.0 Unported License, http://creativecommons.org/licenses/by/3.0/
 */

class Wiky {
	private $patterns, $replacements;

	public function __construct($analyze=false) {
		$this->patterns=array(
			"/\r\n/",

			// Headings
			"/^==== (.+?) ====$/m",						// Subsubheading
			"/^=== (.+?) ===$/m",						// Subheading
			"/^== (.+?) ==$/m",						// Heading

			// Formatting
			"/\'\'\'\'\'(.+?)\'\'\'\'\'/s",					// Bold-italic
			"/\'\'\'(.+?)\'\'\'/s",						// Bold
			"/\'\'(.+?)\'\'/s",						// Italic

			// Special
			// jamie commented out this section because it just doesn't work
			#"/^----+(\s*)$/m",						// Horizontal line
			#"/\[\[(file|img):((ht|f)tp(s?):\/\/(.+?))( (.+))*\]\]/i",	// (File|img):(http|https|ftp) aka image
			#"/\[((news|(ht|f)tp(s?)|irc):\/\/(.+?))( (.+))\]/i",		// Other urls with text
			#"/\[((news|(ht|f)tp(s?)|irc):\/\/(.+?))\]/i",			// Other urls without text

			// Indentations
			"/[\n\r]: *.+([\n\r]:+.+)*/",					// Indentation first pass
			"/^:(?!:) *(.+)$/m",						// Indentation second pass
			"/([\n\r]:: *.+)+/",						// Subindentation first pass
			"/^:: *(.+)$/m",						// Subindentation second pass

			// Ordered list
			"/[\n\r]?#.+([\n|\r]#.+)+/",					// First pass, finding all blocks
			"/[\n\r]#(?!#) *(.+)(([\n\r]#{2,}.+)+)/",			// List item with sub items of 2 or more
			"/[\n\r]#{2}(?!#) *(.+)(([\n\r]#{3,}.+)+)/",			// List item with sub items of 3 or more
			"/[\n\r]#{3}(?!#) *(.+)(([\n\r]#{4,}.+)+)/",			// List item with sub items of 4 or more

			// Unordered list
			"/[\n\r]?\*.+([\n|\r]\*.+)+/",					// First pass, finding all blocks
			"/[\n\r]\*(?!\*) *(.+)(([\n\r]\*{2,}.+)+)/",			// List item with sub items of 2 or more
			"/[\n\r]\*{2}(?!\*) *(.+)(([\n\r]\*{3,}.+)+)/",			// List item with sub items of 3 or more
			"/[\n\r]\*{3}(?!\*) *(.+)(([\n\r]\*{4,}.+)+)/",			// List item with sub items of 4 or more

			// List items
			"/^[#\*]+ *(.+)$/m",						// Wraps all list items to <li/>

			// Newlines (TODO: make it smarter and so that it groupd paragraphs)
			// jamie disabled newline replacements because they just aren't tenable. Use explicit headers and <p>s instead
			//"/^(?!<li|dd).+(?=(<a|strong|em|img)).+$/mi",			// Ones with breakable elements (TODO: Fix this crap, the li|dd comparison here is just stupid)
			//"/^[^><\n\r]+$/m",						// Ones with no elements
			);
		$this->replacements=array(
			"\n",

			// Headings
			"<h3>$1</h3>",
			"<h2>$1</h2>",
			"<h1>$1</h1>",

			//Formatting
			"<strong><em>$1</em></strong>",
			"<strong>$1</strong>",
			"<em>$1</em>",

			// Special
			// jamie commented out this section because it just doesn't work
			#"<hr/>",
			#"<img src=\"$2\" alt=\"$6\"/>",
			#"<a href=\"$1\">$7</a>",
			#"<a href=\"$1\">$1</a>",

			// Indentations
			"\n<dl>$0\n</dl>", // Newline is here to make the second pass easier
			"<dd>$1</dd>",
			"\n<dd><dl>$0\n</dl></dd>",
			"<dd>$1</dd>",

			// Ordered list
			"\n<ol>\n$0\n</ol>",
			"\n<li>$1\n<ol>$2\n</ol>\n</li>",
			"\n<li>$1\n<ol>$2\n</ol>\n</li>",
			"\n<li>$1\n<ol>$2\n</ol>\n</li>",

			// Unordered list
			"\n<ul>\n$0\n</ul>",
			"\n<li>$1\n<ul>$2\n</ul>\n</li>",
			"\n<li>$1\n<ul>$2\n</ul>\n</li>",
			"\n<li>$1\n<ul>$2\n</ul>\n</li>",

			// List items
			"<li>$1</li>",

			// Newlines
			// jamie disabled newline replacements because they just aren't tenable. Use explicit headers and <p>s instead
			//"$0",
			//"$0",
		);
		if($analyze) {
			foreach($this->patterns as $k=>$v) {
				$this->patterns[$k].="S";
			}
		}
	}

	public function parse($input) {

		if (!empty($input)) {

			$output=preg_replace($this->patterns,$this->replacements,$input);

		} else {

			$output=false;

		}

		return $output;
	}

	public function doubleBracket($input, $wiki_image_path, $controller) {

		// elements in double brackets are images and internal links

		if(!empty($input)) {

			$output=preg_replace_callback('/\[\[(.+?)\]\]/s', 
				function ($matches) use($wiki_image_path, $controller) {

					$components = explode("|", $matches[1]);

					if (substr($components[0], 0, 5) === "File:") {

						// image
						$img = substr($components[0], 5);
						//$disp = $components[1];
						$side = $components[1];
						$width = $components[2];
						$caption = "";
						if (isset($components[3])) {
							$caption = $components[3];
						}
						$img = str_replace(" ", "_", $img);
						$md5ByteCode = md5(utf8_encode($img));
						$src = $wiki_image_path.$md5ByteCode[0].'/'.$md5ByteCode[0].$md5ByteCode[1].'/'.$img;
						$html = '<div class="card mr-4 float-'.$side.'"><div class="card-body"><img class="img-fluid" src="'.$src.'" style="width:'.$width.'"><figcaption class="figure-caption">'.$caption.'</figcaption></div></div>';
						return $html;

					} else {

						// internal link
						$linkpage = $components[0];
						#$linkurl = $controller->generateUrl('wiki', array('slug' => str_replace(' ', '_', $linkpage)));
						$linkurl = $controller->getUrl('wiki', array('slug' => str_replace(' ', '_', $linkpage)));

						if (count($components) === 2) {

							// internal link with link text
							$linktext = $components[1];
							$html = '<a href="'.$linkurl.'">'.$linktext.'</a>';
							return $html;

						} else {

							// internal link without link text
							$html = '<a href="'.$linkurl.'">'.$linkpage.'</a>';
							return $html;

						}

					}

				}, $input);



		} else {

			$output = false;

		}

		return $output;

	}

	public function singleBracket($input) {

		// elements in single brackets are external links

		if(!empty($input)) {

			$output=preg_replace_callback('/\[(http.+?)\]/s', 
				function ($matches) {

					if (substr($matches[1], 0, 4) === "http") {

						$components = explode(" ", $matches[1], 2);

						if (count($components) > 1) {

							// An external link expressed in the format [http://www.forensic-focus.co.uk Forensic Focus]

							$url = $components[0];
							$title = substr($matches[1], strlen($url));

							$ytpos = strpos($url, "://www.youtube.com/watch?v=");

							if ($ytpos != false) {

								// convert youtube links into embedded videos

								$ytslug = substr($url, $ytpos + 27);

								return '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$ytslug.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';

							} else {

								return "<a href=\"".$url."\">".$title."</a>";

							}

						} else {

							# multiple components

						}

					}	

				}, $input);

		} else {

			$output = false;

		}

		return $output;

	}

}

