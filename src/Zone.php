<?php
/**
 * Created by PhpStorm.
 * User: tvorwachs
 * Date: 08.06.2017
 * Time: 18:10
 */

namespace tvorwachs\ClouDNS;


class Zone extends ClouDNS
{
    /**
     * Get a list with available domain name servers.
     * @return array
     */
    public function listNameServers(){
        $get_string = $this->urlEncode($this->getAuth());
        $result = $this->connect($get_string,'dns/available-name-servers.json');
        return json_decode($result,true);
    }

    /**
     * Gets a list with zones you have or zone names matching a keyword. The method works with pagination. Reverse zones are included.
     * @param $page - Current page your zone list is on
     * @param $rows - Results per page. Can be 10, 20, 30, 50 or 100.
     * @param $search - Domain name, reverse zone name or keyword to search for in the zone names
     * @return array('Pages','Data' => Array)
     */
    public function listZones($page = 1, $rows = 10, $search = null){
        $get = $this->getAuth();

        /* Validate the params, default if fail */
        $get['page'] = intval($page) > 0 ? intval($page) : 1;
        $get['rows-per-page'] = in_array(intval($rows), array(10,20,30,50,100)) ? intval($rows) : 10;
        if($search != null) $get['search'] =  $search;

        /* Run the connection and get result for page count */
        $get_string = $this->urlEncode($get);
        $pg_result = $this->connect($get_string,'dns/get-pages-count.json');

        /* Run the connection and get result */
        $get_string = $this->urlEncode($get);
        $result = $this->connect($get_string,'dns/list-zones.json');

        return array('Pages'=>json_decode($pg_result,true),'Data'=>json_decode($result,true));
    }

    /**
     * Gets the number of the zones you have and the zone limit of your customer plan. Reverse zones are included.
     * @return array
     */
    public function listZoneStats(){
        $get_string = $this->urlEncode($this->getAuth());
        $result = $this->connect($get_string,'dns/get-zones-stats.json');
        return json_decode($result,true);
    }

    /**
     * This function is available only for slave zones, master zones and cloud/bulk domains. Works with reverse zones too.
     * @param $domain
     * @return array
     */
    public function deleteDomainZone($domain){
        $get = $this->getAuth();

        if(filter_var($domain, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)){
            $get['domain-name'] = $domain.'.in-addr.arpa';
        }elseif(filter_var($domain, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){
            $get['domain-name'] = $domain.'.ip6.arpa';
        }else{
            $get['domain-name'] = $domain;
        }

        $get_string = $this->urlEncode($get);
        $result = $this->connect($get_string,'dns/delete.json');
        return json_decode($result,true);
    }

}