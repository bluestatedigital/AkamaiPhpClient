<?php

/**
 *
 * Author: Michael Coury <mcoury@vorien.com>
 * Based on work by: Hideki Okamoto <hokamoto@akamai.com>
 *
 * For more information visit https://developer.akamai.com
 *
 * Copyright 2014 Akamai Technologies, Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Akamai\Credentials;

class Edgerc
{
    private $host;
    private $clientToken;
    private $clientSecret;
    private $accessToken;
    private $errors = [];

    function __construct($section = 'default', $edgercLocation = null)
    {
        if ($edgerc = $this->parseEdgerc($edgercLocation, $section))
        {
            if(!array_key_exists($section, $edgerc))
            {
                throw new \RuntimeException(sprintf("section '%s' does not exist in edgerc", $section));
            }

			$this->host = $edgerc[$section]['host'];
			$this->clientToken = $edgerc[$section]['client_token'];
			$this->clientSecret = $edgerc[$section]['client_secret'];
			$this->accessToken = $edgerc[$section]['access_token'];
		} else {
            throw new \RuntimeException(sprintf("failed to load edgerc: %s", join(",", $this->errors)));
		}
	}

    private function parseEdgerc($edgercLocation, $section)
    {
        $parsedArray = array();

		$contents = file_get_contents($edgercLocation);
		preg_match_all("/\[([^\]].*?)\]\s*([^\[]*)/", $contents, $matches);
		if (false !== array_search($section, $matches[1])) {
			$sectionKey = array_search($section, $matches[1]);
			preg_match_all("/^\s*(host|client_token|client_secret|access_token|max_body)\s*[:=]\s*([^\s]*)\s*$/m", $matches[2][$sectionKey], $tokens);
			foreach ($tokens[1] as $tokenKey => $tokenValue) {
				$parsedArray[$section][$tokenValue] = $tokens[2][$tokenKey];
			}
		} else {
			$this->errors[] = "Section: $section not found in $edgerc";
			return false;
        }


		return $parsedArray;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getClientToken()
    {
        return $this->clientToken;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
