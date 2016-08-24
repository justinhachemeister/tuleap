<?php
/**
 * Copyright (c) Enalean, 2015. All Rights Reserved.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\RealTime;

use Http_Client;
use Http_ClientException;
use ForgeConfig;
use BackendLogger;

class NodeJSClient implements Client {
    /**
     * @var String
     */
    private $url;

    public function __construct() {
        $this->url = 'https://' . $this->getNodeJsServerAddress();
    }

    /**
     * Method to send an Https request when
     * want to broadcast a message
     *
     * @param $message (MessageDataPresenter) : Message to send to Node.js server
     * @throws \Http_ClientException
     */
    public function sendMessage(MessageDataPresenter $message) {
        if ($this->getNodeJsServerAddress() !== '') {
            $http_curl_client = new Http_Client();

            $options = array(
                CURLOPT_URL             => $this->url . '/message',
                CURLOPT_POST            => true,
                CURLOPT_POST            => 1,
                CURLOPT_HTTPHEADER      => array('Content-Type: application/json'),
                CURLOPT_POSTFIELDS      => json_encode($message)
            );

            $http_curl_client->addOptions($options);

            try {
                $http_curl_client->doRequest();
                $http_curl_client->close();
            } catch(Http_ClientException $e) {
                $logger = new BackendLogger();
                $logger->error('Unable to reach nodejs server '. $this->url .' -> '. $e->getMessage());
            }
        }
    }

    private function getNodeJsServerAddress()
    {
        return ForgeConfig::get('nodejs_server_int') !== '' ?
            ForgeConfig::get('nodejs_server_int') : ForgeConfig::get('nodejs_server');
    }
}