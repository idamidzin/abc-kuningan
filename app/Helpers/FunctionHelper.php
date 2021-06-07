<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DummyFunction()
    {

    }
}


if (!function_exists('gen_string')) {

	function gen_string($string,$min=1000,$clean=true) {
		$text = trim(strip_tags($string));
		if(strlen($text)>$min) {
			$blank = strpos($text,'..');
			if($blank) {
                # limit plus last word
				$extra = strpos(substr($text,$min),' ');
				$max = $min+$extra;
				$r = substr($text,0,$max);

			} else {
                # if there are no spaces
				$r = substr($text,0,$min).'....';
			}

		} else {
            # if original length is lower than limit
			$r = $text;
		}
		return $r ;
	}

}


