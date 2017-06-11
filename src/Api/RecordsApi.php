<?php
/**
 * Created by PhpStorm.
 * User: tvorwachs
 * Date: 11.06.2017
 * Time: 13:01
 */

namespace tvorwachs\ClouDNS\Api;

use tvorwachs\ClouDNS\Connection;

class RecordsApi extends Connection
{
    /**
     * List of records in the domain zone
     *
     * @param string $domain
     * @param string $host
     * @param string $type
     * @return array
     */
    public function listRecords($domain, $host = null, $type = null)
    {
        $get = $this->getAuth();

        $get['domain-name'] = $this->getDomain($domain);

        if ($host !== null) $get['host'] = $host;
        if ($type !== null) $get['type'] = $type;

        $get_string = $this->url_encode($get);
        $result = $this->connect($get_string, 'dns/records.json');

        return json_decode($result, true);
    }

    /**
     * Delete record of your domain zone.
     *
     * @param string $domain
     * @param string $recordId
     * @return array
     */
    public function deleteRecord($domain, $recordId)
    {
        $get = $this->getAuth();

        $get['domain-name'] = $this->getDomain($domain);
        $get['record-id'] = $recordId;

        $get_string = $this->url_encode($get);
        $result = $this->connect($get_string, 'dns/delete-record.json');

        return json_decode($result, true);
    }

    /**
     * Copies all the records from a specified zone.
     * Note: This function is available only for master zones.
     *
     * @param string $domain
     * @param string $fromDomain
     * @param int $deleteCurrent
     * @return array
     */
    public function copyRecords($domain, $fromDomain, $deleteCurrent = null)
    {
        $get = $this->getAuth();

        $get['domain-name'] = $this->getDomain($domain);
        $get['from-domain'] = $this->getDomain($fromDomain);

        if ($deleteCurrent !== null && $deleteCurrent === 1) $get['delete-current-records'] = 1;

        $get_string = $this->url_encode($get);
        $result = $this->connect($get_string, 'dns/copy-records.json');

        return json_decode($result, true);
    }
}