<?php

namespace Flurry\Middleware;

class FieldSelectors extends \Slim\Middleware {

	public function parseURI($uri) {
		$parts = explode("~:", $uri);
		$list = array_pop($parts);
		if(preg_match("/\((.*)\)/", $list, $matches)) {
			return [explode(',', $matches[1]), $parts[0]];
		} else {
			return [[], $uri];
		}

	}

	public function call() {
		$uri = $this->app->environment()['PATH_INFO'];
		list($fieldSelectors, $newURI) = $this->parseURI($uri);
		if(!empty($fieldSelectors)) {
			// put selectors in request
			$this->app->request->fieldSelectors = $fieldSelectors;
			$this->app->environment()['PATH_INFO'] = $newURI;
		}
	}
}
